<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Users\Entities\MobileNumber;
use Modules\Users\Entities\User;

class UsersImport extends Controller implements ToModel, WithHeadingRow
{
    private $rows = 0, $rejectedRows = 0, $importedRows = 0;


    /**
     * @param array $row
     *
     * @return Model|null
     */

    public function model(array $row)
    {
        // check correct file format
        $requiredFields = ['user_email','user_login','ID'];
        if (!empty(array_diff($requiredFields, array_keys($row)))) {
            return null;
        }
        ++$this->rows;

        $userId = $row['ID'];

        // check valid mobile number
        $email = $row['user_email'];
        $mobile = $row['digits_phone'] ?? '';
        if (str_starts_with($mobile, '98')) {
            $mobile = '0' . substr($mobile, 2);
        } elseif (str_starts_with($mobile, '+98')) {
            $mobile = '0' . substr($mobile, 3);
        }

        // generate random mobile for user if mobile was incorrect or not exists
        if (strlen($mobile) != 11) {
            $mobile = '00000000000';
            $mobile = substr($mobile,strlen($userId)) . $userId;
        }

        // no email and phone number found
        if (empty($email) && $mobile == '00000000000') {
            ++$this->rejectedRows;
            return null;
        }

        $firstName = $row['billing_first_name'] ?? null;
        $lastName = $row['billing_last_name'] ?? null;

        if (empty($row['billing_first_name']) && empty($row['billing_last_name'])) {
            $firstName = 'کاربر';
            $lastName = 'بی نام';
        }

        // prevents from creating duplicate users
        if (strlen($mobile) == '00000000000') {
            $userExist = User::where('mobile', $mobile)->orWhere('id', $row['ID'])->first();
            if ($userExist) return null;
        }


        $user = User::firstOrCreate(
            ['id' => $userId],
            [
                'mobile' => $mobile,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email ?? null,
            ]
        );
        ++$this->importedRows;

        // create mobile number model
        MobileNumber::create([
            'user_id' => $user->id,
            'number' => $user->mobile,
            'auth_code' => '16824' // doesn't matter
        ]);

        return $user;

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
