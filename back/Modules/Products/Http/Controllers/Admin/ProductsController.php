<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Post;
use Modules\Comments\Entities\Comment;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\AttributeValue;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;
use Modules\Products\Entities\ProductSize;
use Modules\Questions\Entities\Question;
use Modules\Settings\Entities\SeoSetting;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Tags\Tag;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:see-products'])->only(['index', 'search']);
        $this->middleware(['can:see-product-trash'])->only(['trash', 'searchTrash']);
        $this->middleware(['can:add-product'])->only(['create', 'store']);
        $this->middleware(['can:edit-product'])->only(['edit', 'update']);
        $this->middleware(['can:delete-product'])->only(['destroy', 'ajaxDelete']);
        $this->middleware(['can:duplicate-product'])->only(['duplicate']);
        $this->middleware(['can:force-delete-product'])->only(['forceDelete', 'emptyTrash']);
        $this->middleware(['can:restore-products'])->only(['restore']);
    }

    public function makeInventories($product, $request, $update = false)
    {
        $type = $request->variation_type;
        $newInventoryIds = [];

        // get current inventories
        $currentInventories = $product->inventories();

        switch ($type) {
            case "size":
            case "color":

                // get size names
                $variations = [];
                foreach ($request->all() as $key => $value) {
                    if (str_starts_with($key, $type . '_')) {
                        $name = str_replace($type . '_', '', explode('|', $key)[0]);
                        array_push($variations, $name);
                    }
                }
                // get values for each variation
                foreach (array_unique($variations) as $name) {
                    $inputs = [];
                    foreach ($request->all() as $key => $value) {
                        if (str_starts_with($key, $type . '_' . $name)) {
                            // this is a value for this variation
                            // get key and value
                            if (str_contains($key, '|_price')) {
                                $price = intval($value);
                                $inputs['price'] = $price;

                            } elseif (str_contains($key, '|_saleprice')) {
                                if ($value) $salePrice = intval($value); else $salePrice = null;
                                $inputs['sale_price'] = $salePrice;

                            } elseif (str_contains($key, '|_managestock')) {
                                if ($value && $value == 'on') $value = true;
                                $inputs['manage_stock'] = $value;

                            } elseif (str_contains($key, '|_stockstatus')) {
                                $inputs['stock_status'] = $value;

                            } elseif (str_contains($key, '|_stock')) {
                                if ($value == null || intval($value) < 0) $value = 0;
                                $inputs['stock'] = $value;
                            }
                        }
                    }

                    // calculate price and discount
                    if ($inputs['sale_price']) {
                        $inputs['discount_percent'] = round((($inputs['price'] - $inputs['sale_price']) / $inputs['price']) * 100);
                    }

                    // check sale price
                    if (intval($inputs['sale_price']) >= intval($inputs['price'])) {
                        $inputs['sale_price'] = null;
                        $inputs['discount_percent'] = null;
                    }
                    if ($type == 'color') {
                        $model = ProductColor::where('name', $name)->first();
                    } else {
                        $model = ProductSize::where('name', $name)->first();
                    }
                    if ($model) {
                        $inputs['product_id'] = $product->id;
                        $inputs[$type . '_id'] = $model->id;

                        if ($update){
                            $inventory = null;
                            if ($type == 'color'){
                                $inventory = ProductInventory::where('color_id',$model->id)
                                    ->where('size_id',null)
                                    ->where('product_id',$product->id)->first();
                            }elseif ($type == 'size'){
                                $inventory = ProductInventory::where('size_id',$model->id)
                                    ->where('color_id',null)
                                    ->where('product_id',$product->id)->first();
                            }
                            if ($inventory){
                                $inventory->update($inputs);
                            }else{
                                $inventory = ProductInventory::create($inputs);
                            }
                        }else{
                            $inventory = ProductInventory::create($inputs);
                        }
                        array_push($newInventoryIds, $inventory->id);
                    }
                }
                break;

            case "color_size":

                // get colors
                $colors = [];
                foreach ($request->all() as $key => $value) {
                    if (str_starts_with($key, 'colorsize_')) {
                        $arr = explode('|', $key);
                        $colorName = $arr[1];
                        // add color name if not exists
                        if (!array_key_exists($colorName, $colors)) {
                            array_push($colors, $colorName);
                        }
                    }
                }
                // remove duplicate colors
                $colors = array_unique($colors);

                // get variations for each color
                foreach ($colors as $color) {
                    $colorModel = ProductColor::where('name', $color)->first();
                    if ($colorModel) {

                        $sizes = [];
                        foreach ($request->all() as $key => $value) {
                            if (str_starts_with($key, 'colorsize_')) {
                                $arr = explode('|', $key);
                                $sizeName = str_replace('colorsize_', '', $arr[0]);
                                array_push($sizes, $sizeName);
                            }
                        }
                        // remove duplicate sizes
                        $sizes = array_values(array_unique($sizes));

                        // get value for each sizes

                        foreach ($sizes as $size) {
                            $inputs = [];
                            foreach ($request->all() as $key => $value) {
                                if (str_starts_with($key, 'colorsize_' . $size . '|' . $color)) {
                                    // this is a value for this variation
                                    // get key and value
                                    if (str_contains($key, '|_price')) {
                                        $price = intval($value);
                                        $inputs['price'] = $price;

                                    } elseif (str_contains($key, '|_saleprice')) {
                                        if ($value) $salePrice = intval($value); else $salePrice = null;
                                        $inputs['sale_price'] = $salePrice;

                                    } elseif (str_contains($key, '|_managestock')) {
                                        if ($value && $value == 'on') $value = true;
                                        $inputs['manage_stock'] = $value;

                                    } elseif (str_contains($key, '|_stockstatus')) {
                                        $inputs['stock_status'] = $value;

                                    } elseif (str_contains($key, '|_stock')) {
                                        if ($value == null) $value = 0;
                                        $inputs['stock'] = $value;
                                    }
                                }
                            }

                            // calculate price and discount
                            if ($inputs['sale_price']) {
                                $inputs['discount_percent'] = round((($inputs['price'] - $inputs['sale_price']) / $inputs['price']) * 100);
                            }

                            // check sale price
                            if (intval($inputs['sale_price']) >= intval($inputs['price'])) {
                                $inputs['sale_price'] = null;
                                $inputs['discount_percent'] = null;
                            }


                            $sizeModel = ProductSize::where('name', $size)->first();
                            if ($sizeModel) {
                                $inputs['product_id'] = $product->id;
                                $inputs['color_id'] = $colorModel->id;
                                $inputs['size_id'] = $sizeModel->id;

                                if ($update){
                                    $inventory = ProductInventory::where('size_id',$sizeModel->id)
                                        ->where('color_id',$colorModel->id)
                                        ->where('product_id',$product->id)->first();
                                    if ($inventory){
                                        $inventory->update($inputs);
                                    }else{
                                        $inventory = ProductInventory::create($inputs);
                                    }
                                }else{
                                    $inventory = ProductInventory::create($inputs);
                                }

                                array_push($newInventoryIds, $inventory->id);
                            }
                        }

                    }
                }
                break;
        }

        // check deleted inventories by user
        $currentInventories->whereNotIn('id',$newInventoryIds)->delete();

    }


    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('products::admin.products.index', compact('products'));
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(20);
        return view('products::admin.products.trash', compact('products'));
    }

    public function create()
    {
        return view('products::admin.products.create');
    }

    public function store(CreateProductRequest $request)
    {
        // check if any variation exists in request
        $validVariation = false;
        foreach ($request->all() as $key => $field){
            if(str_contains($key,'color_') || str_contains($key,'size_') || str_contains($key,'colorsize_')){
                $validVariation = true;
            }
        }
        if (!$validVariation && $request->product_type == 'variation') {
            session()->flash('error','هیچ متغییری برای محصول تعریف نشده است.');
            return redirect()->back();
        }

        $inputs = $request->all();

        // generate slug from user input
        if ($request->has('slug') && !empty($request->slug)) {
            $inputs['slug'] = SlugService::createSlug(Product::class, 'slug', str_replace('/', '', $request->slug));
        }

        // generate product unique code
        $inputs['code'] = strtolower($this->generateRandomString());

        // attributes
        $attrs = $this->generateAttributes($inputs);
        $inputs['attributes'] = $attrs['attributes'];
        $inputs['total_attributes'] = $attrs['total_attributes'];



        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq, $input);
            }
        }
        $inputs['faq'] = $faq;

        $inputs['recommended'] = false;
        if ($request->has('recommended') && $request->recommended == 'on') {
            $inputs['recommended'] = true;
        }


        $inputs['display_comments'] = false;
        if ($request->has('display_comments') && $request->display_comments == 'on') {
            $inputs['display_comments'] = true;
        }

        $inputs['display_questions'] = false;
        if ($request->has('display_questions') && $request->display_questions == 'on') {
            $inputs['display_questions'] = true;
        }

        // images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            // check images count
            if (count($files) > 15) {
                session()->flash('error', 'تصاویر گالری حداکثر میتواند 15 مورد باشد.');
                return redirect()->back();
            }
            $images = array();
            foreach ($files as $image) {
                $uploaded = $this->uploadImage($image, 'products');
                array_push($images, $uploaded);
            }
            $inputs['images'] = $images;
        }

        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $inputs['image'] = $this->uploadImage($image, 'products');
        }


        // simple product calculations
        // inventory
        if ($request->stock == null) $inputs['stock'] = 0;
        if ($request->has('manage_stock') && $request->manage_stock == 'on') {
            $inputs['manage_stock'] = true;
        } else {
            $inputs['stock'] = 0;
        }

        // calculate price and discount
        $price = intval($request->price);
        if ($request->sale_price) {
            $salePrice = intval($request->sale_price);
            $inputs['sale_price'] = $salePrice;
            $inputs['discount_percent'] = round((($price - $salePrice) / $price) * 100);
        }

        // create product model
        $product = Product::create($inputs);

        // create inventories
        if ($product->product_type == 'variation') {

            // check if eny variation selected

            $this->makeInventories($product, $request);
        }

        // attach categories
        $product->categories()->attach($request->categories);

        // attach keywords
        if (!empty($request->keywords)) {
            $keys = explode(',', $request->keywords);
            $tags = [];
            foreach ($keys as $key) {
                $tag = Tag::findOrCreate($key, 'Product');
                array_push($tags, $tag);
            }
            $product->attachTags($tags);
        }

        session()->flash('success', 'محصول جدید با موفقیت اضافه شد.');
        return redirect(route('products.edit',$product));
    }

    public function edit(Product $product)
    {
        return view('products::admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // check if any variation exists in request
        $validVariation = false;
        foreach ($request->all() as $key => $field){
            if(str_contains($key,'color_') || str_contains($key,'size_') || str_contains($key,'colorsize_')){
                $validVariation = true;
            }
        }
        if (!$validVariation && $request->product_type == 'variation') {
            session()->flash('error','هیچ متغییری برای محصول تعریف نشده است.');
            return redirect()->back();
        }

        $inputs = $request->all();

        // update slug
        if ($request->slug != $product->slug) {
            $inputs['slug'] = SlugService::createSlug(Product::class, 'slug', str_replace('/', '', $request->slug));
        }

        // attributes
        $attrs = $this->generateAttributes($inputs);
        $inputs['attributes'] = $attrs['attributes'];
        $inputs['total_attributes'] = $attrs['total_attributes'];



        // calculate price and discount
        if ($request->product_type == 'simple'){
            $price = intval($request->price);
            if ($request->sale_price) {
                $salePrice = intval($request->sale_price);
                $inputs['sale_price'] = $salePrice;
                if ($price < 1) {
                    session()->flash('error','قیمت محصول را وارد کنید.');
                    return redirect()->back();
                }
                $inputs['discount_percent'] = round((($price - $salePrice) / $price) * 100);
            }
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq, $input);
            }
        }
        $inputs['faq'] = $faq;

        $inputs['recommended'] = false;
        if ($request->has('recommended') && $request->recommended == 'on') {
            $inputs['recommended'] = true;
        }

        $inputs['display_comments'] = false;
        if ($request->has('display_comments') && $request->display_comments == 'on') {
            $inputs['display_comments'] = true;
        }

        $inputs['display_questions'] = false;
        if ($request->has('display_questions') && $request->display_questions == 'on') {
            $inputs['display_questions'] = true;
        }

        // inventory
        if ($request->stock == null) $inputs['stock'] = 0;
        if ($request->has('manage_stock') && $request->manage_stock == 'on') {
            $inputs['manage_stock'] = true;
        } else {
            $inputs['manage_stock'] = false;
            $inputs['stock'] = 0;
        }

        $images = json_decode(request('old_images'));
        if (is_array($images)) {
            $images = array_values($images);
        }
        if ($images == null) {
            $images = array();
        }
        // TODO delete removed images (storage)

        // gallery images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            // check image count
            if ((count($files) + count($images)) > 15) {
                session()->flash('error', 'تصاویر گالری حداکثر میتواند 15 مورد باشد.');
                return redirect()->back();
            }
            $newImages = array();
            foreach ($files as $image) {
                $uploaded = $this->uploadImage($image, 'products');
                array_push($newImages, $uploaded);
            }
            foreach ($newImages as $img) {
                array_push($images, $img);
            }
        }
        $inputs['images'] = $images;


        // image
        if ($request->remove_image != null) {
            $fileUrl = request('remove_image');
//            $this->removeStorageFile($fileUrl);
            $inputs['image'] = null;
        } else {
            $inputs['image'] = $product->image;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $inputs['image'] = $this->uploadImage($image, 'products');
        }

        $product->update($inputs);

        // update inventories
        if ($product->product_type == 'variation') {
            $this->makeInventories($product, $request, true);
        }

        // attach categories
        $product->categories()->sync($request->categories);

        // sync keywords
        $tags = [];
        $keys = [];
        if (!empty($request->keywords)) {
            $keys = explode(',', $request->keywords);
            foreach ($keys as $key) {
                $tag = Tag::findOrCreate($key, 'Product');
                array_push($tags, $tag);
            }
        }
        $product->syncTagsWithType($keys, 'Product');


        session()->flash('success', 'تغییرات با موفقیت ذخیره شد.');
        return redirect(route('products.edit', $product));
    }

    public function destroy(Product $product)
    {
        $name = $product->title;
        $product->delete();
        session()->flash('success', 'محصول با عنوان (' . $name . ') به زباله دان منتقل شد');
        return redirect(route('products.index'));
    }

    public function restore()
    {
        $id = request('id');
        $product = Product::onlyTrashed()->where('id', $id)->first();
        $name = $product->title;
        $product->restore();
        session()->flash('success', 'محصول با عنوان (' . $name . ') با موفقیت بازگردانی شد');
        return redirect(route('products.trash'));
    }

    public function beforeForceDelete($product)
    {

        // delete images
//        $copiedFrom = Product::find($product->copy_from);
//        if (!$copiedFrom){
//            $imageArray = array();
//            if ($product->image){
//                array_push($imageArray,
//                    $product->image['thumb'],
//                    $product->image['large_thumb'],
//                    $product->image['medium'],
//                    $product->image['large'],
//                    $product->image['original']
//                );
//            }
//            if ($product->images != null){
//                if (count($product->images) > 0){
//                    foreach ($product->images as $img) {
//                        array_push($imageArray,
//                            $img['thumb'],
//                            $img['large_thumb'],
//                            $img['medium'],
//                            $img['large'],
//                            $img['original']
//                        );
//                    }
//                }
//            }
//            if (count($imageArray) > 0){
//                foreach ($imageArray as $img){
//                    $this->removeStorageFile($img);
//                }
//            }
//        }

        // delete inventories
        $product->inventories()->delete();

        // delete comments
        Comment::where('product_id',$product->id)->delete();

        // delete related questions
        $questions = Question::where('model_type','product')->where('user_id',$product->id);
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
        $product->questions()->delete();



        // delete categories relation
        $product->categories()->sync([]);
    }

    public function forceDelete()
    {
        $id = request('id');
        $product = Product::onlyTrashed()->where('id', $id)->first();
        $name = $product->title;

        $this->beforeForceDelete($product);
        $product->forceDelete();
        session()->flash('success', 'محصول با عنوان (' . $name . ') با موفقیت حذف شد');

        return redirect(route('products.trash'));
    }

    public function emptyTrash()
    {
        $products = Product::onlyTrashed();
        foreach ($products->get() as $product) {
            $this->beforeForceDelete($product);
        }
        $products->forceDelete();
        session()->flash('success', 'زباله‌دان خالی شد.');
        return redirect(route('products.trash'));
    }

    public function ajaxDelete(Request $request)
    {
        $deleted = Product::where('id', $request->id)->delete();
        if ($deleted) {
            session()->flash('success', 'محصول به زباله‌دان منتقل شد.');
            return "success";
        }
        return "couldn't delete product";
    }

    public function search()
    {
        $query = request('query');
        $products = Search::add(Product::class, ['title', 'slug', 'title_latin'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $products->appends(array('query' => $query))->links();
        return view('products::admin.products.index', compact('products', 'query'));
    }

    public function searchTrash()
    {
        $query = request('query');
        $products = Product::onlyTrashed()->where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('slug', 'LIKE', '%' . $query . '%')
            ->orWhere('title_latin', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $products->appends(array('query' => $query))->links();
        return view('products::admin.products.trash', compact('products', 'query'));
    }

    public function duplicate(Product $product)
    {
        $newProduct = $product->replicate([
            'sell_count'
        ]);
        $newProduct->status = 'draft';
        $newProduct->title = $product->title . ' (کپی)';
        $newProduct->sku = null;

        // copy from
        $copyFrom = $product->copy_from == null ? $product->id : $product->copy_from;
        $newProduct->copy_from = $copyFrom;

        // generate product unique code
        $newProduct->code = strtolower($this->generateRandomString(15));

        // generate slug
        $newProduct->slug = SlugService::createSlug(Product::class, 'slug', str_replace('/', '', $newProduct->title));


        $newProduct->save();

        // attach categories
        $newProduct->categories()->sync($product->categories);

        // sync keywords
        $newProduct->attachTags($product->tags);

        // check inventory
        if ($product->product_type == 'variation'){
            foreach ($product->inventories as $inventory) {
                ProductInventory::create([
                    'product_id' => $newProduct->id,
                    'color_id' => $inventory->color_id,
                    'size_id' => $inventory->size_id,
                    'price' => $inventory->price,
                    'sale_price' => $inventory->sale_price,
                    'discount_percent' => $inventory->discount_percent,
                    'stock' => $inventory->stock,
                    'manage_stock' => $inventory->manage_stock,
                    'stock_status' => $inventory->stock_status,
                ]);
            }
        }


        session()->flash('success', 'کپی جدیدی از محصول با عنوان (' . $newProduct->title . ') ساخته شد.');
        return redirect(route('products.index'));
    }

    public function generateAttributes($inputs)
    {
        $attributes = array();
        $totalAttributes = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'attr_')) {

                $arr = explode('_', str_replace('attr_', '', $key));

                if (count($arr) == 4) {
                    $label = $arr[3];
                } else {
                    $label = implode(' ', str_replace('_', ' ', array_slice($arr, 3)));
                }

                $attrObject = [
                    'code' => $arr[0],
                    'frontend_type' => $arr[1],
                    'required' => $arr[2],
                    'label' => $label,
                    'value' => $input
                ];
                array_push($attributes, $attrObject);

            } else if (str_starts_with($key, 'total_attr_')) {
                $arr = explode('_', str_replace('total_attr_', '', $key));

                if (count($arr) == 4) {
                    $label = $arr[3];
                } else {
                    $label = implode(' ', str_replace('_', ' ', array_slice($arr, 3)));
                }
                $attrObject = [
                    'code' => $arr[0],
                    'frontend_type' => $arr[1],
                    'required' => $arr[2],
                    'label' => $label,
                    'value' => $input
                ];
                array_push($totalAttributes, $attrObject);

                // store attribute values
                $attribute = Attribute::where('code',$arr[0])->first();
                $value = AttributeValue::where('attribute_id',$attribute->id)->where('value',$input)->first();
                if (!$value){
                    $attribute->values()->create(['value' => $input]);
                }
            }
        }
        return [
            'attributes' => $attributes,
            'total_attributes' => $totalAttributes
        ];
    }

}
