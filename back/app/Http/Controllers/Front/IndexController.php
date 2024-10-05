<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Modules\Banners\Entities\Banner;
use Modules\Blog\Entities\Post;
use Modules\PageBuilder\Entities\Template;
use Modules\Products\Entities\Category;
use Modules\Settings\Entities\AppearanceSetting;
use Modules\Settings\Entities\GeneralSetting;
use Modules\Story\Entities\Story;
use Spatie\SchemaOrg\Schema;

class IndexController extends Controller
{
    public function home()
    {
        $generalSettings = GeneralSetting::firstOrCreate();
        $appearanceSettings = AppearanceSetting::firstOrCreate();
        $template = Template::find($appearanceSettings->home_template);


        // meta tags
        SEOMeta::setTitle($generalSettings->home_title_tag, false);
        SEOMeta::setDescription($generalSettings->home_meta_description);
        SEOMeta::setCanonical(url(''));
        OpenGraph::setDescription($generalSettings->home_meta_description);
        OpenGraph::setTitle($generalSettings->home_title_tag);
        OpenGraph::setUrl(url(''));
        OpenGraph::addImage($generalSettings->home_og_image);
        OpenGraph::addProperty('image:width', $generalSettings->home_og_image_width);
        OpenGraph::addProperty('image:height', $generalSettings->home_og_image_height);
        OpenGraph::addProperty('updated_time', $generalSettings->updated_at);
        OpenGraph::addVideo($generalSettings->home_og_video);
        TwitterCard::setDescription($generalSettings->home_meta_description);
        TwitterCard::setUrl(url(''));
        TwitterCard::addImage($generalSettings->home_og_image);
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($generalSettings->home_title_tag)
            ->description($generalSettings->home_meta_description)
            ->url(url(url('')));

        return view('front.home', compact('schema','template'));
    }

    public function previewTemplate(Template $template){
        return view('front.home', compact('template'));

    }

}
