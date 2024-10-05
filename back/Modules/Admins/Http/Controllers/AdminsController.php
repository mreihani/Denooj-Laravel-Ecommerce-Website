<?php

namespace Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Admins\Entities\Admin;
use Modules\Blog\Entities\Post;
use Modules\Products\Entities\Product;
use Modules\Questions\Entities\Question;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class AdminsController extends Controller
{
    public function index(){
        $admins = Admin::latest()->paginate(20);
        return view('admins::admins.index',compact('admins'));
    }

    public function edit(Admin $admin){
        if ($admin->id == auth()->guard('admin')->user()->id){
            return redirect(route('admin.profile'));
        }
		return view('admins::admins.edit',compact('admin'));
    }

    public function update(Admin $admin,Request $request){
        $request->validate([
            'name'=> 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|email|string|max:255|unique:admins,email,'.$admin->id,
            'avatar' => 'mimes:jpeg,bmp,png,gif,svg,webp,jpg'
        ]);

        $inputs = $request->all();

        if ($request->has('password') && $request->password != ''){
            $inputs['password'] = Hash::make($request->password);
        }else{
            $inputs['password'] = $admin->password;
        }

        // avatar image
        if ($request->remove_avatar_image != null) {
            $fileUrl = request('remove_avatar_image');
            $this->removeStorageFile($fileUrl);
            $inputs['avatar'] = null;
        }
        if ($request->hasFile('avatar')) {
            $imageFile = $request->file('avatar');
            $inputs['avatar'] = $this->uploadRealFile($imageFile,'admins');
        }

        $admin->update($inputs);
		$admin->syncRoles($request->role);

        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('admins.index'));
    }

    public function create(){
        return view('admins::admins.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|email|unique:admins|string|max:255',
            'password' => 'required',
            'avatar' => 'mimes:jpeg,bmp,png,gif,svg,webp,jpg|nullable'
        ]);

        $inputs = $request->all();

        $inputs['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $inputs['avatar'] = $this->uploadRealFile($file,'admins');
        }

        $admin = Admin::create($inputs);
        $admin->syncRoles($request->role);

        session()->flash('success','مدیر جدید با موفقیت اضافه شد.');
        return redirect(route('admins.index'));
    }

    public function deleteForm(Admin $admin){
        if ($admin->id == auth()->guard('admin')->user()->id) {
            session()->flash('error', 'شما نمیتوانید حساب کاربری خود را حذف کنید.');
            return redirect()->back();
        }
        return view('admins::admins.delete_form',compact('admin'));
    }

    public function destroy(Request $request,Admin $admin){
        $request->validate([
            'result' => 'required'
        ]);

        if ($admin->id == auth()->guard('admin')->user()->id) {
            session()->flash('error', 'شما نمیتوانید حساب کاربری خود را حذف کنید.');
        }else{
            if ($request->result == 'to_me'){
                $myId = auth()->guard('admin')->user()->id;
                Post::withTrashed()->where('author_id',$admin->id)->update(['author_id' => $myId]);
                Product::withTrashed()->where('author_id',$admin->id)->update(['author_id' => $myId]);
                Question::where('admin_id',$admin->id)->update(['admin_id' => $myId]);
            }else{
                $admin->posts()->forceDelete();
                $admin->products()->forceDelete();
            }
            $admin->delete();
            session()->flash('success','حساب مدیر با موفقیت حذف شد.');
        }
        return redirect(route('admins.index'));
    }

    public function search(){
        $query = request('query');
        $admins = Search::add(Admin::class,['name','email','mobile'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)
            ->search($query);
        $admins->appends(array('query' => $query))->links();
        return view('admins::admins.index',compact('admins','query'));
    }

}
