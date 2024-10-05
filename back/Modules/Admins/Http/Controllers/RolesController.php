<?php

namespace Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(){
    	$roles = Role::where('name','!=','super-admin')->latest()->paginate(20);
    	return view('admins::roles.index',compact('roles'));
	}

	public function create(){
		return view('admins::roles.create');
	}

	public function store(Request $request){
		$request->validate([
			'name' => 'required|string|max:255|unique:roles|regex:/^[A-Za-z 0-9 -]+$/',
			'label' => 'required|string|max:255'
		]);

        // create slug name
        $name = Str::slug($request->name);

        // check role name
        $roleExist = Role::where('name',$name)->first();
        if ($roleExist){
            session()->flash('error','یک نقش با این نام از قبل وجود دارد!');
            return redirect()->back()->withInput();
        }

		$role = Role::create(['guard_name' => 'admin', 'name' =>$name , 'label' => $request->label]);
		$role->syncPermissions($request->permissions);

		session()->flash('success','نقش جدید ایجاد شد!');
		return redirect(route('roles.index'));
	}

	public function edit(Role $role){
		return view('admins::roles.edit',compact('role'));
	}

	public function update(Role $role,Request $request){
		$request->validate([
			'name' => 'required|string|max:255|regex:/^[A-Za-z -]+$/|unique:roles,name,'.$role->id,
			'label' => 'required|string|max:255'
		]);

        // create slug name
        $name = Str::slug($request->name);

        // check role name
        $roleExist = Role::where('name',$name)->where('id','!=',$role->id)->first();
        if ($roleExist){
            session()->flash('error','یک نقش با این نام از قبل وجود دارد!');
            return redirect()->back()->withInput();
        }

		$role->update(['name' => $name , 'label' => $request->label]);
		$role->syncPermissions($request->permissions);

		session()->flash('success','تغییرات با موفقیت ذخیره شد!');
		return redirect()->back();
	}

	public function destroy(Role $role)
	{
		$name = $role->name;
		$role->delete();
		session()->flash('success','نقش ('.$name.') با موفقیت حذف شد!');
		return redirect(route('roles.index'));
	}

	public function search(){
		$query = request('query');
		$roles = Search::add(Role::class,['name','label'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)
            ->search($query);
		return view('admins::roles.index',compact('roles','query'));
	}
}
