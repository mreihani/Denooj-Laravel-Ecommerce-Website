<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Products\Entities\Attribute;
use Modules\Products\Entities\Product;

class ProductsImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0, $importedRows = 0;
    private $authorId;
    private $downloadImages;


    public function __construct($authorId, $downloadImages)
    {
        $this->authorId = $authorId;
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
        $requiredFields = ['post_title', 'post_name', 'ID', 'post_content', 'post_excerpt','regular_price','stock_status'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }

        ++$this->rows;

        // generate product unique code
        $code = strtolower($this->generateRandomString());

        // get images links
        $imagesRow = $row['images'];
        $images = null;
        $image = null;
        if ($this->downloadImages) {
            if (!empty($imagesRow)) {
                $array = explode('|', $imagesRow);
                $links = [];
                foreach ($array as $imageObj) {
                    $link = trim(explode('!', $imageObj)[0]);
                    array_push($links, $link);
                }

                // download images and upload to server
                if (count($links) > 0) {
                    $uploadedImages = array();
                    foreach ($links as $url) {

                        // fix special character bug
                        $ext = pathinfo($url, PATHINFO_EXTENSION);
                        $filename = pathinfo($url, PATHINFO_FILENAME);
                        $dirname = pathinfo($url, PATHINFO_DIRNAME);
                        $encoded = $dirname . '/' . urlencode($filename) . '.' . $ext;

                        $uploaded = $this->uploadImage($encoded, 'products');
                        array_push($uploadedImages, $uploaded);
                        $images = $uploadedImages;
                    }
                }
            }

            // take main image and remove from gallery array
            if ($images != null && count($images) > 0) {
                $image = array_shift($images);
            }
        }

        // calculate discount percent
        $discountPercent = null;
        $regularPrice = intval($row['regular_price']);
        $salePrice = $row['sale_price'];
        if(!$salePrice) $salePrice = intval($row['sale_price']);
        if (!empty($row['sale_price'])) {
            $discountPercent = round((($regularPrice - $salePrice) / $regularPrice) * 100);
        }
        if (empty($row['regular_price'])){
            $regularPrice = 0;
        }

        // create attributes
        $totalAttributes = [];
        foreach ($row as $key => $rowItem) {
            if (str_starts_with($key, 'attribute:') && !empty($rowItem)) {
                $code = $this->generateRandomString(8);
                $type = 'text';
                $label = str_replace('pa_', '', explode(':', $key)[1]);
                $label = str_replace('-', ' ', $label);

                // generate attribute model
                $attribute = Attribute::where('label', $label)->first();
                if (!$attribute) {
                    $attribute = Attribute::create(
                        [
                            'code' => $code,
                            'label' => $label,
                            'frontend_type' => $type,
                            'required' => true,
                            'filterable' => false
                        ]
                    );
                }

                // make product attr object
                $attrObject = [
                    'code' => $attribute->code,
                    'frontend_type' => $attribute->frontend_type,
                    'required' => $attribute->required,
                    'label' => $attribute->label,
                    'value' => $rowItem
                ];
                array_push($totalAttributes, $attrObject);
            }
        }

        $attributes = [];
        if (count($totalAttributes) > 3) {
            $attributes = array_slice($totalAttributes, 0, 3);
        }

        // generate unique slug
        $slug = SlugService::createSlug(Product::class, 'slug', str_replace('/', '', $row['post_name']));

        // check title
        $title = $row['post_title'];
        $status = $row['post_status'];
        if (empty($title)) {
            $status = 'draft';
            $title = 'بدون عنوان';
        }

        $product = Product::create([
            'id' => $row['ID'],
            'code' => $code,
            'author_id' => $this->authorId,
            'sku' => $row['sku'] ?? null,
//            'label' => $row[''],
            'title' => $title,
//            'title_latin' => $row[''],
            'slug' => $slug,
            'short_description' => $row['post_excerpt'],
            'image' => $image,
            'images' => $images,
            'body' => $row['post_content'],
            'manage_stock' => !($row['manage_stock'] == 'no'),
            'stock' => $row['stock'] ?? 0,
            'stock_status' => $row['stock_status'] == 'instock' ? 'in_stock' : 'out_of_stock',
            'price' => $regularPrice,
            'sale_price' => $salePrice,
            'discount_percent' => $discountPercent,
            'status' => $status == 'publish' ? 'published' : 'draft',
//            'recommended' => $row[''],
            'sell_count' => $row['meta:total_sales'] ?? 0,
            'attributes' => $attributes,
            'total_attributes' => $totalAttributes,
//            'copy_from' => $row[''],
//            'h1_hidden' => $row[''],
//            'nav_title' => $row[''],
//            'meta_description' => $row[''],
//            'canonical' => $row[''],
//            'title_tag' => $row[''],
//            'image_alt' => $row[''],
//            'faq' => $row['']
        ]);

        ++$this->importedRows;
        return $product;
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


    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
