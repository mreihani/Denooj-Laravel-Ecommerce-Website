<?php

namespace Modules\FileManager\Entities;

use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    protected $fillable = [
        'name',
        'link',
        'size',
        'extension',
        'image_thumb'
    ];

    protected $casts = [
        'image_thumb' => 'array'
    ];

    public function getUrl(){
        return rtrim(url('/storage' . $this->link), '/');
    }

    public function isImage(){
        $imgExt = [
            'jpg',
            'png',
            'gif',
            'jpeg',
            'jfif',
            'webp'
        ];
        return in_array($this->extension,$imgExt);
    }

    public function scopeImage($query){
        $query->where('extension','jpg')
            ->orWhere('extension','png')
            ->orWhere('extension','gif')
            ->orWhere('extension','jpeg')
            ->orWhere('extension','webp')
            ->orWhere('extension','jfif');
    }

    function humanFileSize($unit="") {
        if( (!$unit && $this->size >= 1<<30) || $unit == "GB")
            return number_format($this->size/(1<<30),2)."GB";
        if( (!$unit && $this->size >= 1<<20) || $unit == "MB")
            return number_format($this->size/(1<<20),2)."MB";
        if( (!$unit && $this->size >= 1<<10) || $unit == "KB")
            return number_format($this->size/(1<<10),2)."KB";
        return number_format($this->size)." bytes";
    }

    public function getIcon(){

        switch ($this->extension){
            case "pdf":
                return asset('admin/assets/img/icons/misc/pdf.png');
            case "css":
                return asset('admin/assets/img/icons/misc/css.png');
            case "txt":
                return asset('admin/assets/img/icons/misc/txt.png');
            case "js":
                return asset('admin/assets/img/icons/misc/js.png');
            case "psd":
                return asset('admin/assets/img/icons/misc/psd.png');
            case "zip":
            case "rar":
                return asset('admin/assets/img/icons/misc/zip.png');
            case "html":
            case "htm":
                return asset('admin/assets/img/icons/misc/html.png');
            case "jpg":
            case "png":
            case "gif":
            case "jpeg":
            case "jfif":
            case "webp":
                return asset('admin/assets/img/icons/misc/jpg.png');
            default:
                return asset('admin/assets/img/icons/misc/doc.png');
        }
    }
}
