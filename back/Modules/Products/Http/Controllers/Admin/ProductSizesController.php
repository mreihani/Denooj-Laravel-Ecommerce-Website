<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductSize;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ProductSizesController extends Controller
{

    public function index()
    {
        $sizes = ProductSize::orderByDesc('id')->paginate(20);
        return view('products::admin.sizes.index',compact('sizes'));
    }

    public function create()
    {
        return view('products::admin.sizes.create');

    }

    public function store(Request $request){
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $inputs = $request->all();

        // slugify name
        $inputs['name'] = Str::slug($request->name);

        // check for already exists
        $exists = ProductSize::where('name',$inputs['name'])->first();
        if ($exists) {
            session()->flash('error','یک سایز از قبل با این نام لاتین ('.$inputs['name'].') وجود دارد، دقت کنید که نام لاتین باید یونیک باشد.');
            return redirect()->back();
        }

        ProductSize::create($inputs);
        session()->flash('success','سایز جدید با موفقیت اضافه شد.');
        return redirect(route('product-sizes.create'));
    }

    public function edit(ProductSize $productSize)
    {
        return view('products::admin.sizes.edit',compact('productSize'));
    }

    public function update(Request $request, ProductSize $productSize)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $inputs = $request->all();

        // slugify name
        $inputs['name'] = Str::slug($request->name);

        // check for already exists
        $exists = ProductSize::where('name',$inputs['name'])->where('id','!=',$productSize->id)->first();
        if ($exists) {
            session()->flash('error','یک سایز از قبل با این نام لاتین ('.$inputs['name'].') وجود دارد، دقت کنید که نام لاتین باید یونیک باشد.');
            return redirect()->back();
        }

        $productSize->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('product-sizes.edit',$productSize));
    }

    public function destroy(ProductSize $productSize)
    {
        $name = $productSize->label;
        $productSize->delete();
        session()->flash('success','سایز ('.$name.') با موفقیت حذف شد.');
        return redirect(route('product-sizes.index'));
    }

    public function search(){
        $query = request('query');
        $sizes = Search::add(ProductSize::class,['label','name'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $sizes->appends(array('query' => $query))->links();
        return view('products::admin.sizes.index',compact('sizes','query'));
    }
}
