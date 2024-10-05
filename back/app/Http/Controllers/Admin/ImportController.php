<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\OrdersImport;
use App\Imports\PagesImport;
use App\Imports\PostCatsImport;
use App\Imports\PostCommentImport;
use App\Imports\PostsImport;
use App\Imports\TagsImport;
use App\Imports\ProductCatsImport;
use App\Imports\ProductsImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importForm(){
        return view('admin.views.import.index');
    }

    public function import(Request $request){
        ini_set('max_execution_time', 6000);

        $request->validate([
            'type' => 'required',
            'file' => 'required',
            'author_id' => 'required',
        ]);

        $imageDownload = $request->has('download_images') && $request->download_images == 'on';

        // check base url
        if ($imageDownload && (!isset($request->base_url) || empty($request->base_url))){
            session()->flash('error','جهت دانلود تصاویر باید آدرس دامنه سایت مبدا را وارد کنید.');
            return redirect()->back();
        }

        $csvFile = $request->file('file');

        switch ($request->type){
            case "page":
                $type = 'برگه';
                $import = new PagesImport($request->base_url,$imageDownload);
                break;

            case "post":
                $type = 'مقاله';
                $import = new PostsImport($request->author_id,$request->base_url,$imageDownload);
                break;

            case "post_cat":
                $type = 'دسته‌بندی مقاله';
                $import = new PostCatsImport();
                break;

            case "post_tag":
                $type = 'برچسب مقاله';
                $import = new TagsImport('Post');
                break;

            case "post_comment":
                $type = 'دیدگاه مقاله';
                $import = new PostCommentImport('Post');
                break;

            case "user":
                $type = 'کاربر';
                $import = new UsersImport();
                break;

            case "product":
                $type = 'محصول';
                $import = new ProductsImport($request->author_id, $imageDownload);
                break;

            case "product_cat":
                $type = 'دسته‌بندی محصول';
                $import = new ProductCatsImport($imageDownload);
                break;

            case "product_tag":
                $type = 'برچسب محصول';
                $import = new TagsImport('Product');
                break;

            case "product_comment":
                $type = 'دیدگاه محصول';
                $import = new PostCommentImport('Product');
                break;

            case "order":
                $type = 'سفارش';
                $import = new OrdersImport();
                break;

            default:
                session()->flash('error', 'نوع پست تایپ انتخابی پشتیبانی نمیشود.');
                return redirect()->back();
        }

        Excel::import($import, $csvFile);

        $rowCount = $import->getRowCount();
        $rejectedRowCount = $import->getRejectedRowCount();
        $importedRowCount = $import->getImportedRowCount();

        $result = "<strong class='mb-3 d-block'>نتیجه درون ریزی:</strong>";
        if ($rowCount > 0) {
            $result .= "<p class='text-success mb-0 mt-1'>تعداد $rowCount $type در فایل شناسایی شد.</p>";
        }else{
            $result .= "<p class='text-danger mb-0 mt-1'>هیچ $type معتبری در فایل پیدا نشد! ممکن است فرمت فایل اشتباه باشد.</p>";
        }
        if ($importedRowCount > 0) {
            $result .= "<p class='text-success mb-0 mt-1'>$importedRowCount $type با موفقیت درون ریزی شد.</p>";
        }
        if ($rejectedRowCount > 0) {
            $result .= "<p class='text-danger mb-0 mt-1'>$rejectedRowCount $type بدلیل داشتن فرمت اشتباه و یا تکراری بودن درون ریزی نشد.</p>";
        }
        session()->flash('result',$result);

        return back();
    }
}
