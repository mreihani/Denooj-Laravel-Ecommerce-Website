<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\Product;

class AttributesController extends Controller
{

    public function index()
    {
        $attributes = Attribute::latest()->paginate(20);
        return view('products::admin.attributes.index',compact('attributes'));
    }

    public function create()
    {
        return view('products::admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'frontend_type' => 'required',
        ]);

        $inputs = $request->except('_token');
        $code = $this->generateRandomString(8);
        $inputs['code'] = strtolower($code);

        $inputs['filterable']= false;
        if ($request->filterable == 'on') {
            $inputs['filterable']= true;
        }

        $inputs['required']= false;
        if ($request->required == 'on') {
            $inputs['required']= true;
        }

        Attribute::create($inputs);
        session()->flash('success','ویژگی جدید با موفقیت ساخته شد.');
        return redirect(route('attributes.create'));
    }


    public function edit(Attribute $attribute)
    {
        return view('products::admin.attributes.edit',compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'frontend_type' => 'required',
        ]);

        $inputs = $request->except('_token');

        if ($request->filterable == 'on') {
            $inputs['filterable']= true;
        }else {
            $inputs['filterable']= false;
        }

        if ($request->required == 'on') {
            $inputs['required']= true;
        }else {
            $inputs['required']= false;
        }

        $attribute->update($inputs);

        // update related products attributes
        $attrCode = $attribute->code;
        $products = Product::whereJsonContains('total_attributes', ['code' => $attrCode])
            ->orWhereJsonContains('attributes', ['code' => $attrCode])->get();
        foreach ($products as $product) {
            $totalAttributes = $product->total_attributes;
            $attributes = $product->attributes;
            $newTotalAttributes = [];
            $newAttributes = [];
            foreach ($totalAttributes as $attr){
                if ($attr['code'] == $attrCode){
                    $attr = [
                        'code' => $attribute->code,
                        'frontend_type' =>$attribute->frontend_type,
                        'required' => $attribute->required,
                        'label' => $attribute->label,
                        'value' => $attr['value']
                    ];
                }
                array_push($newTotalAttributes,$attr);
            }
            $product->update(['total_attributes' => $newTotalAttributes]);
            foreach ($attributes as $attr){
                if ($attr['code'] == $attrCode){
                    $attr = [
                        'code' => $attribute->code,
                        'frontend_type' =>$attribute->frontend_type,
                        'required' => $attribute->required,
                        'label' => $attribute->label,
                        'value' => $attr['value']
                    ];
                }
                array_push($newAttributes,$attr);
            }
            $product->update(['attributes' => $newAttributes]);
        }


        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect()->back();
    }

    public function destroy(Attribute $attribute)
    {
        $label = $attribute->label;

        // update related products attributes
        $attrCode = $attribute->code;
        $products = Product::whereJsonContains('total_attributes', ['code' => $attrCode])
            ->orWhereJsonContains('attributes', ['code' => $attrCode])->get();
        foreach ($products as $product) {
            $totalAttributes = $product->total_attributes;
            $attributes = $product->attributes;
            $newTotalAttributes = [];
            $newAttributes = [];
            foreach ($totalAttributes as $attr){
                if ($attr['code'] != $attrCode){
                    array_push($newTotalAttributes,$attr);
                }
            }
            $product->update(['total_attributes' => $newTotalAttributes]);
            foreach ($attributes as $attr){
                if ($attr['code'] != $attrCode){
                    array_push($newAttributes,$attr);
                }
            }
            $product->update(['attributes' => $newAttributes]);
        }

        $attribute->delete();

        session()->flash('success','ویژگی با عنوان '.$label.' حذف شد.');
        return redirect(route('attributes.index'));
    }

    public function search()
    {
        $query = request('query');
        $attributes = Attribute::where('label', 'LIKE', '%' . $query . '%')
            ->orWhere('code', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $attributes->appends(array('query' => $query))->links();
        return view('products::admin.attributes.index', compact('attributes', 'query'));
    }
}
