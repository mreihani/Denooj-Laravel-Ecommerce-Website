<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\AttributeCategory;
use Modules\Products\Entities\Product;

class AttributeCategoriesController extends Controller
{

    public function index()
    {
        $categories = AttributeCategory::latest()->paginate(20);
        return view('products::admin.attributes.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('products::admin.attributes.categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'attribute_list' => 'required',
        ]);
        $category = AttributeCategory::create($request->all());
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key,'attr_')){
                $array = explode('_',$key);
                $id = $array[1];
                $category->attributesList()->attach($id, ['default' => $value]);
            }
        }

        session()->flash('success','گروه جدید با موفقیت ساخته شد.');
        return redirect(route('attribute-categories.create'));
    }

    public function edit(AttributeCategory $attributeCategory)
    {
        return view('products::admin.attributes.categories.edit',compact('attributeCategory'));
    }

    public function update(Request $request, AttributeCategory $attributeCategory)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'attribute_list' => 'required',
        ]);
        $attributeCategory->update($request->all());
        $attributeCategory->attributesList()->sync([]);
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key,'attr_')){
                $array = explode('_',$key);
                $id = $array[1];
                $attributeCategory->attributesList()->attach($id, ['default' => $value]);
            }
        }

        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect()->back();
    }

    public function destroy(AttributeCategory $attributeCategory)
    {
        $label = $attributeCategory->name;
        $attributeCategory->delete();
        session()->flash('success','گروه ویژگی با عنوان '.$label.' حذف شد.');
        return redirect(route('attribute-categories.index'));
    }

    public function search()
    {
        $query = request('query');
        $categories = AttributeCategory::where('name', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $categories->appends(array('query' => $query))->links();
        return view('products::admin.attributes.categories.index', compact('categories', 'query'));
    }

    public function getAttributes(){
        $catId = request('category_id');
        $category = AttributeCategory::find($catId);
        return $category->attributesList;
    }
}
