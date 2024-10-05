<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Entities\Post;

class PostsImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0, $importedRows = 0;
    private $authorId;
    private $baseUrl;
    private $downloadImages;

    public function __construct($authorId,$baseUrl, $downloadImages)
    {
        $this->authorId = $authorId;
        $this->downloadImages = $downloadImages;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['ID', 'post_content', 'post_excerpt'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }


        $postId = $row['ID'];
        $title = $row['post_title'];
        $slug = urldecode($row['post_name']);
        $status = $row['post_status'] == 'publish' ? 'published' : 'draft';
        $excerpt = $row['post_excerpt'];
        $createdAt = Carbon::make($row['post_date']);
        $updatedAt = Carbon::make($row['post_modified']);

        ++$this->rows;

        // check if post with this id already exists
        $exist = Post::find($postId);
        if ($exist) {
            ++$this->rejectedRows;
            return null;
        }

        // download image
        $imageUrl = null;
        if ($this->downloadImages) {
            $imgPath = $row['thumbnail'];
            if (!empty($imgPath) && $imgPath != 'NULL') {
                $url = rtrim($this->baseUrl,'/') . '/wp-content/uploads/' .$imgPath;
                $imageUrl = $this->uploadImage($url, 'posts');
            }
        }

        $post = Post::create([
            'id' => $postId,
            'author_id' => $this->authorId,
            'title' => $title,
            'excerpt' => $excerpt,
            'body' => $row['post_content'],
            'image' => $imageUrl,
            'slug' => $slug,
            'status' => $status,
//                'featured' => false,
//                'order' => $row['post'],
//                'h1_hidden' => $row['post'],
//                'nav_title' => $row['post'],
//                'meta_description' => $row['post'],
//                'canonical' => $row['post'],
//                'title_tag' => $row['post'],
            'image_alt' => $title,
            'reading_time' => '5 دقیقه',
//                'faq' => $row['post'],
//                'sidebar' => $row['post'],
            'created_at' => $createdAt,
            'updated_at' => $updatedAt
        ]);
        ++$this->importedRows;

        return $post;

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
