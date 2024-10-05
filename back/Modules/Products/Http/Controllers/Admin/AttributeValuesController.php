<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\AttributeCategory;
use Modules\Products\Entities\AttributeValue;
use Modules\Products\Entities\Product;

class AttributeValuesController extends Controller
{

    public function index()
    {
        $values = AttributeValue::latest()->paginate(20);
        return view('products::admin.attributes.values.index',compact('values'));
    }

    public function create()
    {
        return view('products::admin.attributes.values.create');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $label = $attributeValue->value;
        $attributeValue->delete();
        session()->flash('success','آیتم با عنوان '.$label.' حذف شد.');
        return redirect(route('attribute-values.index'));
    }

    public function search()
    {
        $query = request('query');
        $values = AttributeValue::where('value', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $values->appends(array('query' => $query))->links();
        return view('products::admin.attributes.values.index', compact('values', 'query'));
    }
}
