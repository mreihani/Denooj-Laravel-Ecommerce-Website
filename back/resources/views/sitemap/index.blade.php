<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @php $seoSetting = \Modules\Settings\Entities\SeoSetting::firstOrCreate(); @endphp
    @if($seoSetting->page_sitemap_inc)
    <sitemap>
        <loc>{{ url('sitemap-page.xml') }}</loc>
    </sitemap>
    @endif

    @if($seoSetting->post_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-post.xml') }}</loc>
        </sitemap>
    @endif
    @if($seoSetting->product_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-product.xml') }}</loc>
        </sitemap>
    @endif
    @if($seoSetting->post_cat_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-post-category.xml') }}</loc>
        </sitemap>
    @endif
    @if($seoSetting->post_tag_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-post-tag.xml') }}</loc>
        </sitemap>
    @endif
    @if($seoSetting->product_cat_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-category.xml') }}</loc>
        </sitemap>
    @endif
    @if($seoSetting->product_tag_sitemap_inc)
        <sitemap>
            <loc>{{ url('sitemap-tag.xml') }}</loc>
        </sitemap>
    @endif


    <sitemap>
        <loc>{{ url('sitemap-static.xml') }}</loc>
    </sitemap>
</sitemapindex>
