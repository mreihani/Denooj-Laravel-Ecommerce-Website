<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Custom\Filters\FilterProductAttribute;
use App\Http\Custom\Filters\FilterProductPrice;
use App\Http\Custom\Filters\FilterProductSearch;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductInventory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\SchemaOrg\FAQPage;
use Spatie\SchemaOrg\Schema;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Spatie\Tags\Tag;

class ProductsController extends Controller
{
    private $PER_PAGE = 18;
    private $ALLOWED_SORTS = ['created_at', 'price', 'sell_count', 'discount_percent'];

    public function product(Product $product)
    {
        if ($product->status != 'published' && !auth()->guard('admin')->check()) {
            abort(404);
        }

        views($product)->record();
        $categoryIds = $product->categories->pluck('id')->toArray();
        $similarProducts = Product::whereHas('categories', function ($query) use ($categoryIds) {
            return $query->whereIn('categories.id', $categoryIds);
        })->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->limit(10)
            ->get();

        $questions = $product->questions()->where('status', 'published')->get();

        // meta tags
        SEOMeta::setTitle($product->getSeoTitle());
        SEOMeta::setDescription($product->meta_description);
        SEOMeta::setCanonical(route('product.show', $product));
        OpenGraph::setDescription($product->meta_description);
        OpenGraph::setTitle($product->getSeoTitle());
        OpenGraph::setUrl(route('product.show', $product));
        OpenGraph::addImage($product->getImage());
        OpenGraph::addProperty('updated_time', $product->updated_at);
        TwitterCard::setDescription($product->meta_description);
        TwitterCard::setUrl(route('product.show', $product));
        TwitterCard::addImage($product->getImage());
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($product->title_tag)
            ->description($product->meta_description)
            ->url(route('product.show', $product))
            ->image($product->getImage());

        return view('products::product', compact('product', 'similarProducts', 'questions', 'schema'));
    }

    public function tag($tag)
    {
        $tag = Tag::findFromString($tag, 'Product');
        if (empty($tag)) return redirect(404);
        $searchQ = null;
        if (request()->has('filter')) {
            if (array_key_exists('search', request('filter'))) {
                $searchQ = request('filter')['search'];
            }
        }

        $products = Product::withAnyTags([$tag], 'Product')
            ->published()
            ->latest()
            ->paginate($this->PER_PAGE);

        $maxPriceRange = 0;
        $postExpensiveProduct = Product::orderByDesc('price')->first();
        if ($postExpensiveProduct) {
            $maxPriceRange = $postExpensiveProduct->price;
        }

        $count = $products->total();

        // meta tags
        SEOMeta::setTitle($tag->getSeoTitle());
        SEOMeta::setDescription($tag->meta_description);
        SEOMeta::setCanonical(route('tag.show', $tag->slug));
        OpenGraph::setDescription($tag->meta_description);
        OpenGraph::setTitle($tag->getSeoTitle());
        OpenGraph::setUrl(route('tag.show', $tag->slug));
        OpenGraph::addProperty('updated_time', $tag->updated_at);
        TwitterCard::setDescription($tag->meta_description);
        TwitterCard::setUrl(route('tag.show', $tag->slug));
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($tag->title_tag)
            ->description($tag->meta_description)
            ->url(route('tag.show', $tag->slug));

        return view('products::products', compact('products', 'tag', 'maxPriceRange', 'count', 'searchQ', 'schema'));
    }

    public function showCategory(Category $category)
    {

        $searchQ = null;
        if (request()->has('filter')) {
            if (array_key_exists('search', request('filter'))) {
                $searchQ = request('filter')['search'];
            }
        }

        $filters = [
            AllowedFilter::custom('search', new FilterProductSearch),
            AllowedFilter::custom('price', new FilterProductPrice),
            AllowedFilter::scope('hasDiscount'),
            AllowedFilter::scope('available')
        ];

        // append attribute filters
        if (request()->has('filter') && is_array(request('filter'))) {
            foreach (request('filter') as $key => $requestStr) {
                if (str_starts_with($key, 'attribute-')) {
                    $filter = AllowedFilter::custom($key, new FilterProductAttribute);
                    array_push($filters, $filter);
                }
            }
        }


        // get category ids
        $category = Category::with('subCategories')->find($category->id);
        $categoryIds = $category->subCategories->pluck('id')->push($category->id);
        foreach ($category->subCategories as $subCategory) {
            $subCategoryIds = $subCategory->subCategories->pluck('id');
            $categoryIds->push($subCategoryIds);
        }
        $categoryIds = $categoryIds->flatten();

        // sort by stock status
//        $sorted = Product::get()
//            ->sortBy('in_stock')  //appended attribute
//            ->pluck('id')
//            ->toArray();
//        $orderedIds = implode(',', $sorted);
//        $productsQuery = Product::orderByRaw(DB::raw("FIELD(id, ".$orderedIds." ) DESC"));

        $productsQuery = Product::orderBy('stock','ASC')->orderBy('stock_status','ASC');
        $products = QueryBuilder::for($productsQuery)
            ->allowedSorts($this->ALLOWED_SORTS)
            ->defaultSort('-created_at')
            ->allowedFilters($filters)
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->published()
            ->paginate($this->PER_PAGE);

        $maxPriceRange = 0;
        $postExpensiveProduct = Product::orderByDesc('price')->first();
        if ($postExpensiveProduct) {
            $maxPriceRange = $postExpensiveProduct->price;
        }

        $count = $products->total();

        // meta tags
        SEOMeta::setTitle($category->getSeoTitle());
        SEOMeta::setDescription($category->meta_description);
        SEOMeta::setCanonical(route('category.show', $category));
        OpenGraph::setDescription($category->meta_description);
        OpenGraph::setTitle($category->getSeoTitle());
        OpenGraph::setUrl(route('category.show', $category));
        OpenGraph::addProperty('updated_time', $category->updated_at);
        TwitterCard::setDescription($category->meta_description);
        TwitterCard::setUrl(route('category.show', $category));
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($category->title_tag)
            ->description($category->meta_description)
            ->url(route('category.show', $category));

        views($category)->record();
        return view('products::products', compact('category', 'products', 'searchQ', 'maxPriceRange', 'count', 'schema'));
    }

    public function products()
    {
        $searchQ = null;
        if (request()->has('filter')) {
            if (array_key_exists('search', request('filter'))) {
                $searchQ = request('filter')['search'];
            }
        }

        $filters = [
            AllowedFilter::custom('search', new FilterProductSearch),
            AllowedFilter::custom('price', new FilterProductPrice),
            AllowedFilter::scope('hasDiscount'),
            AllowedFilter::scope('available')
        ];

        // append attribute filters
        if (request()->has('filter') && is_array(request('filter'))) {
            foreach (request('filter') as $key => $requestStr) {
                if (str_starts_with($key, 'attribute-')) {
                    $filter = AllowedFilter::custom($key, new FilterProductAttribute);
                    array_push($filters, $filter);
                }
            }
        }

        // sort by stock status
        $productsQuery = Product::orderBy('stock','ASC')->orderBy('stock_status','ASC');
        $products = QueryBuilder::for($productsQuery)
            ->allowedSorts($this->ALLOWED_SORTS)
            ->defaultSort('-created_at')
            ->allowedFilters($filters)

            ->published()
            ->paginate($this->PER_PAGE);

        $maxPriceRange = 0;
        $postExpensiveProduct = Product::orderByDesc('price')->first();
        if ($postExpensiveProduct) {
            $maxPriceRange = $postExpensiveProduct->price;
        }
        $count = $products->total();
        return view('products::products', compact('products', 'searchQ', 'maxPriceRange', 'count'));
    }

    public function search()
    {
        if (request()->ajax()) {
            $query = request('q');
            $results = (new Search())
                ->registerModel(Product::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title')
                        ->addSearchableAttribute('slug')
                        ->addSearchableAttribute('title_latin')
                        ->addSearchableAttribute('sku')
                        ->where('deleted_at', null)
                        ->published();
                })
                ->limitAspectResults(6)
                ->search($query);
            return response($results);
        }
        return redirect(404);
    }

    public function productShortUrl($code)
    {
        $product = Product::where('code', $code)->first();
        if ($product) {
            return redirect(route('product.show', $product));
        }
        return abort(404);
    }

    public function getInventory()
    {

        $type = request('inventory_type');

        if ($type == 'color') {
            $inventory = ProductInventory::where('product_id', request('product_id'))
                ->where('color_id', request('color_id'))->first();

        } elseif ($type == 'size') {
            $inventory = ProductInventory::where('product_id', request('product_id'))
                ->where('size_id', request('size_id'))->first();

        } elseif ($type == 'color_size') {
            $inventory = ProductInventory::where('product_id', request('product_id'))
                ->where('color_id', request('color_id'))
                ->where('size_id', request('size_id'))->first();
        }

        if (empty($inventory)) {
            return response([
                'status' => 'error',
                'msg' => 'inventory not found.'
            ]);
        }

        return response([
            'status' => 'success',
            'inventory' => $inventory,
            'msg' => 'success'
        ]);
    }
}
