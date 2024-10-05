<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Products\Entities\ProductColor;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ProductColorsController extends Controller
{

    public function index()
    {
        $colors = ProductColor::orderByDesc('id')->paginate(20);
        return view('products::admin.colors.index',compact('colors'));
    }

    public function create()
    {
        return view('products::admin.colors.create');

    }

    public function store(Request $request){
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'hex_code' => 'required'
        ]);

        $inputs = $request->all();

        // slugify name
        $inputs['name'] = Str::slug($request->name);

        // check for already exists
        $exists = ProductColor::where('name',$inputs['name'])->first();
        if ($exists) {
            session()->flash('error','یک رنگ از قبل با این نام لاتین ('.$inputs['name'].') وجود دارد، دقت کنید که نام لاتین باید یونیک باشد.');
            return redirect()->back();
        }

        ProductColor::create($inputs);
        session()->flash('success','رنگ جدید با موفقیت اضافه شد.');
        return redirect(route('product-colors.create'));
    }

    public function edit(ProductColor $productColor)
    {
        return view('products::admin.colors.edit',compact('productColor'));
    }

    public function update(Request $request, ProductColor $productColor)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'hex_code' => 'required'
        ]);

        $inputs = $request->all();

        // slugify name
        $inputs['name'] = Str::slug($request->name);

        // check for already exists
        $exists = ProductColor::where('name',$inputs['name'])->where('id','!=',$productColor->id)->first();
        if ($exists) {
            session()->flash('error','یک رنگ از قبل با این نام لاتین ('.$inputs['name'].') وجود دارد، دقت کنید که نام لاتین باید یونیک باشد.');
            return redirect()->back();
        }

        $productColor->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('product-colors.edit',$productColor));
    }

    public function destroy(ProductColor $productColor)
    {
        $name = $productColor->label;
        $productColor->delete();
        session()->flash('success','رنگ ('.$name.') با موفقیت حذف شد.');
        return redirect(route('product-colors.index'));
    }

    public function search(){
        $query = request('query');
        $colors = Search::add(ProductColor::class,['label','name'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $colors->appends(array('query' => $query))->links();
        return view('products::admin.colors.index',compact('colors','query'));
    }
}
