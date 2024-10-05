<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;

class PostCatsImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0,$importedRows = 0;


    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['slug', 'term_id', 'parent','name','object_id'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }

        $termId = $row['term_id'];
        $postId = $row['object_id'];
        $title = $row['name'];
        $slug = urldecode($row['slug']);
        $parent = $row['parent'] ;
        if ($row['parent'] == 0){
            $parent = null;
        }
        ++$this->rows;

        // check duplicate records
        $relationExists = DB::table('post_category')->where('post_id',$postId)->where('category_id',$termId)->first();
        $category = PostCategory::find($termId);
        if ($relationExists && $category) {
            ++$this->rejectedRows;
            return null;
        }


        // check parent
        if ($parent){
            $parentCat = PostCategory::find($parent);
            if (!$parentCat) $parent = null;
        }

        if (!$category){
            $category = PostCategory::create([
                'id' => $termId,
                'title' => $title,
                'slug' => $slug,
                'seo_description' => $row['description'] ?? null,
                'parent_id' => $parent,
            ]);
            ++$this->importedRows;
        }

        // attach to post
        $post = Post::find($postId);
        if ($post){
            $post->categories()->attach([$category->id]);
        }

        return $category;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getImportedRowCount(): int
    {
        return $this->importedRows;
    }

    public function getRejectedRowCount(): int
    {
        return $this->rejectedRows;
    }

}
