<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadImage($image, $folder, $sizes = ['medium' => 350,'large' => 650], $thumbSize = 60, $largeThumbSize = 150, $original = true){

        $imageName = Str::random(15);

        // path to upload
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $path = "/".$folder."/{$year}/{$month}/";
        $thumb_path = "/".$folder."/{$year}/{$month}/thumb/";


        // create images
        $flag = true;
        $try = 1;
        while ($flag && $try <= 3):
            try {
                $img = Image::make($image);
                //Image migrated successfully
                $flag = false;
            } catch (\Exception $e) {
                dd($e);

                //not throwing  error when exception occurs
            }
            $try++;
        endwhile;

        if (!isset($img)) return null;

        $images = [];
        $img->backup();

        // upload original
//        if ($original){
//            $url = $path . $imageName . "_original.jpg";
//            $uploadTo = 'public/' . $url;
//            $img->reset();
//            $original = $img->stream();
//            Storage::put($uploadTo, $original, 'public');
//            $images['original'] = $url;
//        }

        foreach ($sizes as $key => $size) {
            $url = $path . $imageName . "_{$size}.jpg";
            $uploadTo = 'public/' . $url;
            $img->reset();

            $resized = $img->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();

            Storage::put($uploadTo, $resized, 'public');
            $images[$key] = $url;
        }

        // upload original
        if ($original){
            if (is_string($image)){
                // upload from string
                $url = $path . $imageName . "_original.jpg";
                $uploadTo = 'public/' . $url;
                $img->reset();
                $originalImg = $img->stream();
                Storage::put($uploadTo, $originalImg, 'public');
            }else{
                $url = $this->uploadRealFile($image,'products');
            }
            $images['original'] = $url;
        }

        // thumb
        $url = $thumb_path . $imageName . "_" . $thumbSize . ".jpg";

        $uploadTo = 'public/' . $url;
        $img->reset();
        $thumb = $img->fit($thumbSize, $thumbSize)->stream();
        Storage::put($uploadTo, $thumb, 'public');
        $images['thumb'] = $url;

        // large thumb
        if ($largeThumbSize != null){
            $url = $thumb_path . $imageName . "_" . 150 . ".jpg";
            $uploadTo = 'public/' . $url;
            $img->reset();
            $thumb = $img->fit($largeThumbSize, $largeThumbSize)->stream();
            Storage::put($uploadTo, $thumb, 'public');
            $images['large_thumb'] = $url;
        }


        header('Content-Type: application/json');

        return $images;
    }

    public function uploadRealImageFromUrl($image, $folder){
        $imageName = Str::random(15);

        // path to upload
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $path = "/".$folder."/{$year}/{$month}/";

        // create images
        $flag = true;
        $try = 1;
        while ($flag && $try <= 3):
            try {
                $img = Image::make($image);
                //Image migrated successfully
                $flag = false;
            } catch (\Exception $e) {
                dd($e);

                //not throwing  error when exception occurs
            }
            $try++;
        endwhile;

        if (!isset($img)) return null;


        // upload original
        $url = $path . $imageName . ".jpg";
        $uploadTo = 'public/' . $url;
        $original = $img->stream();
        Storage::put($uploadTo, $original, 'public');

        header('Content-Type: application/json');

        return $url;
    }

    public function uploadRealFile($file, $folderName, $rename = true){
        if ($rename){
            $fileName = Str::random(15);
        }else{
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }
        $fileName .= '.' . $file->getClientOriginalExtension();

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $path = "/".$folderName."/{$year}/{$month}/";

        // check file name exist
        if (file_exists(storage_path('app/public' .$path . $fileName))){
            $pathInfo = pathinfo($fileName);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';
            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                $base = $pathInfo['filename'];
                $number = 0;
            }
            do {
                $fileName = $base . ++$number . $extension;
            } while (file_exists(storage_path('app/public' .$path . $fileName)));
        }

        $file->storeAs("/public".$path,$fileName);
        return $path . $fileName;
    }

    public function removeStorageFile($fileUrl){
        try {
            unlink(storage_path('app/public'.$fileUrl));
        } catch (\Exception $e){
            // show some error
        }
    }

    public function convertPersianNumToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persian, $english, $string);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function publicMetas()
    {
        OpenGraph::setType('website');
        OpenGraph::addProperty('locale', 'fa_IR');
        OpenGraph::setSiteName(config('app.app_name_fa'));
        OpenGraph::addProperty('image:type', 'image/jpeg');
        TwitterCard::setType('summary_large_image');
        TwitterCard::setSite(config('app.app_name_fa'));
        TwitterCard::addValue('creator', config('app.site_domain'));
    }

}
