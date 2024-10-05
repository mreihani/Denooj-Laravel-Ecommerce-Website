<?php

namespace Modules\FileManager\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\FileManager\Entities\FileModel;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class FilesController extends Controller
{

    public function index()
    {
        $files = FileModel::latest()->paginate(20);
        return view('filemanager::admin.index',compact('files'));
    }

    public function create()
    {
        return view('filemanager::admin.create');
    }

    public function isImage($ext){
        $imgExt = [
            'jpg',
            'png',
            'gif',
            'jpeg',
            'jfif',
            'webp'
        ];
        return in_array($ext,$imgExt);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        foreach ($request->file('file') as $file){
            $extension = $file->getClientOriginalExtension();

            // check mime type
            if (str_contains($extension,'php')){
                return redirect()->back();
            }

            $inputs = $request->all();
            $inputs['link'] = $this->uploadRealFile($file,'files', false);
            $inputs['name'] = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $inputs['size'] = $file->getSize();
            $inputs['extension'] = $extension;
            if ($this->isImage($extension)){
                $inputs['image_thumb'] = $this->uploadImage($file,'files',[],80, false, false);
            }
            FileModel::create($inputs);
        }

        session()->flash('success','فایل(ها) با موفقیت آپلود شد.');
        return redirect(route('files.index'));
    }

    public function destroy(FileModel $file)
    {
        $this->removeStorageFile($file->link);
//        $this->removeStorageFile($file->image_thumb['thumb']);
        $file->delete();
        session()->flash('success','فایل مورد نظر با موفقیت حذف شد.');
        return redirect(route('files.index'));
    }

    public function search(){
        $query = request('query');
        $files = Search::add(FileModel::class,['link','extension'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $files->appends(array('query' => $query))->links();
        return view('filemanager::admin.index',compact('files','query'));
    }
}
