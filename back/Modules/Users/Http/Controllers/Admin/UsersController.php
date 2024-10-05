<?php

namespace Modules\Users\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Comments\Entities\Comment;
use Modules\Questions\Entities\Question;
use Modules\Users\Entities\User;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:see-users'])->only(['index','search']);
        $this->middleware(['can:manage-users-wallet'])->only(['showBalance','updateBalance']);
        $this->middleware(['can:edit-users'])->only(['edit','update']);
        $this->middleware(['can:show-user'])->only(['show','showPayments','showSecurity','showAddresses']);
        $this->middleware(['can:add-user'])->only(['create','store']);
    }

    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('users::admin.index',compact('users'));
    }

    public function create()
    {
        return view('users::admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'password' => 'required|min:8',
            'email' => 'nullable|email',
            'mobile' => 'required|digits:11|unique:users',
            'national_code' => 'nullable|digits:10',
            'avatar' => 'mimes:jpeg,jpg,png,gif,webp'
        ]);

        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $image      = $request->file('avatar');
            $inputs['avatar'] = $this->uploadImage($image,'users',['original' => 400],80);
        }
        User::create($inputs);
        session()->flash('success','کاربر جدید با موفقیت ایجاد شد.');
        return redirect(route('users.index'));
    }

    public function show(User $user)
    {
        $orders = $user->orders()->latest()->paginate(20);
        return view('users::admin.show.account',compact('user','orders'));
    }

    public function showPayments(User $user)
    {
        return view('users::admin.show.payments',compact('user'));
    }

    public function showAddresses(User $user)
    {
        return view('users::admin.show.addresses',compact('user'));
    }

    public function showSecurity(User $user)
    {
        return view('users::admin.show.security',compact('user'));
    }

    public function edit(User $user)
    {
        return view('users::admin.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'password' => 'nullable|min:8',
            'email' => 'nullable|email',
            'mobile' => 'required|unique:users,mobile,'.$user->id,
            'national_code' => 'nullable|digits:10',
            'avatar' => 'mimes:jpeg,jpg,png,gif,webp',
        ]);

        $inputs = $request->except('_token');

        // change password
        if ($request->password != '') {
            $inputs['password'] = Hash::make($request->password);
        }else{
            $inputs['password'] = $user->password;
        }

        // image
        if ($request->remove_avatar != null) {
            $fileUrl = request('remove_avatar');
            $this->removeStorageFile($fileUrl);
            $inputs['avatar'] = null;
        }else{
            $inputs['avatar'] = $user->avatar;
        }

        if ($request->hasFile('avatar')) {
            $image      = $request->file('avatar');
            $inputs['avatar'] = $this->uploadImage($image,'users',['medium' => 400],80);
        }

        $user->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('users.index'));
    }

    public function destroy(User $user)
    {
        $name = "(" . $user->getFullName() . " / " . $user->mobile . ")";

        // delete relations
        $user->tickets()->delete();
        $user->payments()->delete();
        Comment::where('user_id',$user->id)->delete();

        // delete user related questions
        $questions = Question::where('user_id',$user->id);
        foreach ($questions->get() as $question) {
            $level1 = Question::where('parent_id', $question->id);
            foreach ($level1->get() as $level1Question) {
                $level2 = Question::where('parent_id', $level1Question->id);
                foreach ($level2->get() as $level2Question) {
                    $level3 = Question::where('parent_id', $level2Question->id);
                    foreach ($level3->get() as $level3Question) {
                        $level4 = Question::where('parent_id', $level3Question->id);
                        $level4->delete();
                    }
                    $level3->delete();
                }
                $level2->delete();
            }
            $level1->delete();
        }
        $questions->update(['parent_id' => null]);
        $user->questions()->delete();

        $user->delete();
        session()->flash('success','کاربر   '.$name.' با موفقیت حذف شد');
        return redirect(route('users.index'));
    }

    public function showBalance(User $user){
        return view('users::admin.show.wallet',compact('user'));
    }

    public function updateBalance(Request $request,User $user){
        $request->validate([
            'amount' => 'required',
            'type' => 'required'
        ]);

        if ($request->type == 'deposit') {
            $user->wallet->deposit($request->amount);
            session()->flash('success','مبلغ '.number_format($request->amount).' تومان به کیف پول ('.$user->getFullName().' - ' .$user->mobile.') اضافه شد. موجودی فعلی: '.number_format($user->wallet->balance).' تومان');

        }else if ($request->type == 'withdraw') {
            // check amount
            if (intval($user->wallet->balance) >= intval($request->amount)){
                $user->wallet->withdraw($request->amount);
                session()->flash('success','مبلغ '.number_format($request->amount).' تومان از کیف پول ('.$user->getFullName().' - ' .$user->mobile.') کسر شد. موجودی فعلی: '.number_format($user->wallet->balance).' تومان');
            }else{
                session()->flash('error','مبلغ وارد شده از موجودی فعلی کاربر بیشتر است.');
            }
        }else {
            session()->flash('error','عملیات با مشکل مواجه شد!');
        }

        return redirect()->back();
    }

    public function search(){
        $query = request('query');
        $users = Search::add(User::class,['first_name','last_name','mobile','national_code','email'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)
            ->search($query);
        $users->appends(array('query' => $query))->links();
        return view('users::admin.index',compact('users','query'));
    }

    public function updatePassword(User $user,Request $request){
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);
        $password = $request->password;
        $user->update(['password' => Hash::make($password)]);
        session()->flash('success','کلمه عبور با موفقیت تغییر کرد.');
        return redirect()->back();
    }
}
