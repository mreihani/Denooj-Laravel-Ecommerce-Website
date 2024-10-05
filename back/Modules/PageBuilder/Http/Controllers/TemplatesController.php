<?php

namespace Modules\PageBuilder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PageBuilder\Entities\Template;
use Modules\PageBuilder\Entities\TemplateRow;
use Modules\Settings\Entities\AppearanceSetting;
use Spatie\Searchable\Search;

class TemplatesController extends Controller
{

    public function index()
    {
        $templates = Template::latest()->paginate(20);
        $appearanceSettings = AppearanceSetting::firstOrCreate();
        return view('pagebuilder::templates.index',compact('templates','appearanceSettings'));
    }

    public function create()
    {
        return view('pagebuilder::templates.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required'
        ]);

        $template = Template::create($request->all());
        session()->flash('success','قالب جدید با موفقیت ایجاد شد.');
        return redirect(route('templates.edit',$template));
    }


    public function edit(Template $template)
    {
        return view('pagebuilder::templates.edit',compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $template->update($request->all());
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect()->back();

    }

    public function destroy(Template $template)
    {
        $template->delete();
        session()->flash('success','قالب با موفقیت حذف شد.');
        return redirect(route('templates.index'));
    }

    public function search()
    {
        $query = request('query');
        $templates = Search::add(Template::class,['title'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $templates->appends(array('query' => $query))->links();
        return view('pagebuilder::templates.index', compact('templates', 'query'));
    }

    public function addRow(){
        $widgetType = request('widget_type');
        $widgetName = request('widget_name');
        $widgetIcon = request('widget_icon');
        $layout = 'box';

        $templateId = request('template_id');
        $template = Template::find($templateId);
        $order = 1;
        $latestRow = $template->rows()->orderBy('order','desc')->first();

        if ($latestRow){
            $order = intval($latestRow->order) + 1;
        }

        // add index to widget name
        $latestRowOfType = $template->rows()->where('widget_type',$widgetType)->orderBy('order','desc');
        if ($latestRowOfType->count() > 0){
            if ($widgetType == 'image_slider' || $widgetType == 'banner_location'){
                $count = 1;
                while (TemplateRow::where('widget_name', $widgetName)->where('template_id',$templateId)->exists()) {
                    $widgetName = request('widget_name') . " (" . $count . ")";
                    $count++;
                }
            }
        }






        if ($widgetType == 'stories' && $latestRowOfType->first()){
            return response()->json([
                'success' => false,
                'msg' => 'ویجت دستان ها از قبل به این قالب اضافه شده است.'
            ]);
        }


        $btnLink = '/products/?filter[hasDiscount]=true';
        $sectionTitle = 'پیشنهاد شگفت‌انگیز';
        $itemsCount = 12;
        if ($widgetType == 'featured_products' || $widgetType == 'posts'){
            $layout = 'full';
        }

        if ($widgetType == 'posts'){
            $btnLink = '/blog';
            $sectionTitle = 'جدیدترین مقالات سایت';
            $itemsCount = 6;
        }

        if ($widgetType == 'faq'){
            $sectionTitle = 'سوالات متداول';
        }

        TemplateRow::create([
            'template_id' => $templateId,
            'widget_type' => $widgetType,
            'widget_name' => $widgetName,
            'widget_icon' => $widgetIcon,
            'order' => $order,
            'layout' => $layout,

            'featured_products_title' => $sectionTitle,
            'featured_products_title_icon' => 'icon-percent',
            'featured_products_count' => $itemsCount,
            'featured_products_btn_link' => $btnLink,
            'featured_products_source' => 'discounted',
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function deleteRow(){
        $row = TemplateRow::find(request('id'));
        if ($row){
            $row->delete();
            return true;
        }
        return false;
    }


    public function updateRow(Request $request, TemplateRow $row){

        $request->validate([

        ]);

        $inputs = $request->all();

        $inputs['featured_categories_show_count'] = false;
        if ($request->has('featured_categories_show_count') && $request->featured_categories_show_count == 'on'){
            $inputs['featured_categories_show_count'] = true;
        }

        $inputs['stories_show_title'] = false;
        if ($request->has('stories_show_title') && $request->stories_show_title == 'on'){
            $inputs['stories_show_title'] = true;
        }


        $inputs['featured_products_available'] = false;
        if ($request->has('featured_products_available') && $request->featured_products_available == 'on'){
            $inputs['featured_products_available'] = true;
        }

        $inputs['featured_products_recommended'] = false;
        if ($request->has('featured_products_recommended') && $request->featured_products_recommended == 'on'){
            $inputs['featured_products_recommended'] = true;
        }

        $inputs['featured_products_discounted'] = false;
        if ($request->has('featured_products_discounted') && $request->featured_products_discounted == 'on'){
            $inputs['featured_products_discounted'] = true;
        }

        if (!$request->has('featured_products_categories_source')){
            $inputs['featured_products_categories_source'] = null;
        }

        // home faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        $row->update($inputs);

        return redirect()->back();
    }

    public function updateRowOrder(){
        $dataArray = json_decode(request('data'));
        foreach ($dataArray as $rowData){
            $row = TemplateRow::find($rowData->id);
            $row->update([
                'order' => $rowData->order
            ]);
        }
        return true;
    }

}
