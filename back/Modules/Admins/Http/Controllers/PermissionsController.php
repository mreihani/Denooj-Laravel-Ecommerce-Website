<?php

namespace Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index(){
    	$permissions = Permission::latest()->paginate(20);
    	return view('admins::permissions.index',compact('permissions'));
	}

	public function create(){
		return view('admins::permissions.create');
	}

	public function store(Request $request){
		$request->validate([
			'name' => 'required|string|max:255|unique:permissions|regex:/^[A-Za-z -]+$/',
			'label' => 'required|string|max:255',
		]);

        // create slug name
        $name = Str::slug($request->name);

        Permission::create(['guard_name' => 'admin', 'name' => $name , 'label' => $request->label]);
		session()->flash('success','مجوز جدید ایجاد شد!');
		return redirect()->back();
	}

	public function edit(Permission $permission){
		return view('admins::permissions.edit',compact('permission'));
	}

	public function update(Permission $permission,Request $request){
		$request->validate([
			'name' => 'required|string|max:255|regex:/^[A-Za-z -]+$/|unique:permissions,name,'.$permission->id,
			'label' => 'required|string|max:255',
			'module' => 'required|string|max:255',
		]);

        // create slug name
        $name = Str::slug($request->name);

		$permission->update(['name' => $name , 'label' => $request->label, 'module' => $request->module]);

		session()->flash('success','تغییرات با موفقیت ذخیره شد!');
		return redirect()->back();
	}

	public function destroy(Permission $permission)
	{
		$name = $permission->name;
		$permission->delete();
		session()->flash('success','مجوز ('.$name.') با موفقیت حذف شد!');
		return redirect(route('permissions.index'));
	}

	public function search(){
		$query = request('query');
		$permissions = Search::add(Permission::class,['name','label'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)
            ->search($query);
		return view('admins::permissions.index',compact('permissions','query'));
	}
}
