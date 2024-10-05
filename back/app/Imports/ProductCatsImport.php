<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\Product;

class ProductCatsImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0,$importedRows = 0;
    private $downloadImages;


    public function __construct($downloadImages)
    {
        $this->downloadImages = $downloadImages;
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['slug', 'term_id', 'parent','name'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }

        $title = $row['name'];
        $productId = $row['object_id'] ?? null;
        $termId = $row['term_id'];
        $parent = $row['parent'] ;
        if ($row['parent'] == 0){
            $parent = null;
        }
        ++$this->rows;


        // check duplicate records
        if ($productId){
            $relationExists = DB::table('product_category')->where('product_id',$productId)->where('category_id',$termId)->first();
            $category = Category::find($termId);
            if ($relationExists && $category) {
                ++$this->rejectedRows;
                return null;
            }
        }


        $thumbnailUrl = null;
        if ($this->downloadImages) {
            $thumbnailUrl = $row['thumbnail'];
            if (!empty($thumbnailUrl)) {
                // fix special character bug
                $ext = pathinfo($thumbnailUrl, PATHINFO_EXTENSION);
                $filename = pathinfo($thumbnailUrl, PATHINFO_FILENAME);
                $dirname = pathinfo($thumbnailUrl, PATHINFO_DIRNAME);
                $encoded = $dirname . '/' . urlencode($filename) . '.' . $ext;
                $thumbnailUrl = $this->uploadRealImageFromUrl($encoded, 'categories');
            }
        }

        // check parent
        if ($parent){
            $parentCat = Category::find($parent);
            if (!$parentCat) $parent = null;
        }

        if (!isset($category)){
            $category = Category::create([
                'id' => $row['term_id'],
                'title' => $title,
                'slug' => $row['slug'],
                'image' => $thumbnailUrl,
                'seo_description' => $row['description'] ?? null,
                'parent_id' => $parent,
            ]);
            ++$this->importedRows;
        }

        // attach to post
        $product = Product::find($productId);
        if ($product){
            $product->categories()->attach([$category->id]);
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
