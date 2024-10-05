<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Products\Entities\Product;
use Spatie\Tags\Tag;

class TagsImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0,$importedRows = 0;
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['slug', 'term_id', 'name','object_id'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }

        $termId = $row['term_id'];
        $postId = $row['object_id'];
        $slug = urldecode($row['slug']);
        $name = $row['name'];

        ++$this->rows;

        // check duplicate records
        $relationExists = DB::table('taggables')->where('taggable_id',$postId)->where('tag_id',$termId)->first();
        $tag = Tag::find($termId);
        if ($relationExists && $tag) {
            ++$this->rejectedRows;
            return null;
        }

        if (!$tag){
            $tag = Tag::create([
                'id' => $termId,
                'name->fa' => $name,
                'slug->fa' => $slug,
                'type' => $this->type,
                'seo_description' => $row['description'] ?? null,
            ]);
            ++$this->importedRows;
        }

        if ($this->type == 'Post'){
            $post = Post::find($postId);
        }else{
            $post = Product::find($postId);
        }
        if ($post){
            $post->attachTags([$tag]);
        }

        return $tag;
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
