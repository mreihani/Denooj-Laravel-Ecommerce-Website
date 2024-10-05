<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Blog\Entities\Post;
use Modules\Comments\Entities\Comment;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\User;

class PostCommentImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0, $importedRows = 0;
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
        $requiredFields = ['comment_id', 'comment_post_id', 'user_id', 'comment_content', 'comment_date'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }
        if ($this->type == 'Product' && empty($row['score'])){
            ++$this->rejectedRows;
            return null;
        }
        ++$this->rows;

        $postId = $row['comment_post_id'];
        $commentId = $row['comment_id'];
        $userId = $row['user_id'];
        $body = $row['comment_content'] ?? '-';
        $date = Carbon::make($row['comment_date']);
        $status = $row['comment_approved'] ? 'published' : 'pending';
        $score = $row['score'] ?? 0;

        // check duplicate records
        $comment = Comment::find($commentId);
        if ($comment) {
            ++$this->rejectedRows;
            return null;
        }

        // check user
        $mobile = '00000000000';
        $mobile = substr($mobile, strlen($userId)) . $userId;
        $user = User::where('id', $userId)->orWhere('mobile',$mobile)->first();
        if (!$user) {
            $authorName = $row['comment_author'];
            $nameArr = explode(' ',$authorName);
            $firstName = $nameArr[0];
            $lastName = '-';
            if (count($nameArr) > 1){
                $lastName = $nameArr[1];
            }
            $user= User::create([
                'id' => $userId,
                'mobile' => $mobile,
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
        }


        // check post
        $postKey = 'post_id';
        if ($this->type == 'Post'){
            $post = Post::find($postId);
        }else{
            $post = Product::find($postId);
            $postKey = 'product_id';
        }
        if (!$post) {
            ++$this->rejectedRows;
            return null;
        }

        $user->comments()->create([
            'id' => $commentId,
            $postKey => $postId,
            'comment' => $body,
            'score' => $score,
            'status' => $status,
            'created_at' => $date,
        ]);

        ++$this->importedRows;
        return $comment;
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
