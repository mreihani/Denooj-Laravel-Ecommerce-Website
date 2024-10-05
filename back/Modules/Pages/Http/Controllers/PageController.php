<?php

namespace Modules\Pages\Http\Controllers;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Modules\Pages\Entities\Page;
use Modules\Products\Entities\Product;
use Spatie\SchemaOrg\Schema;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if ($page->status != 'published' && !auth()->guard('admin')->check()) {
            abort(404);
        }

        views($page)->record();

        // meta tags
        SEOMeta::setTitle($page->getSeoTitle());
        SEOMeta::setDescription($page->meta_description);
        SEOMeta::setCanonical(route('page.show', $page));
        OpenGraph::setDescription($page->meta_description);
        OpenGraph::setTitle($page->getSeoTitle());
        OpenGraph::setUrl(route('page.show', $page));
        OpenGraph::addImage($page->getImage());
        OpenGraph::addProperty('updated_time', $page->updated_at);
        TwitterCard::setDescription($page->meta_description);
        TwitterCard::setUrl(route('page.show', $page));
        TwitterCard::addImage($page->getImage());
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($page->title_tag)
            ->description($page->meta_description)
            ->url(route('page.show', $page))
            ->image($page->getImage());

        $products = Product::where('recommended',true)->take(6)->get();

        $similarPages = Page::where('id','!=',$page->id)->latest()->take(4)->get();

        return view('pages::show', compact('page', 'products','schema','similarPages'));
    }

}
