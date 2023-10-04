<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserRepository  implements UserRepositoryInterface
{

    public function getBlankModel()
    {
        return new User();
    }

    public function registerUser($request)
    {

        $user = $this->getBlankModel();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->father_name = $request->father_name;
        $user->mather_name = $request->mather_name;
        $user->date_of_birth = $request->date_of_birth;
        $user->nid = $request->nid;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->mobile = $request->mobile;
        $user->blood_group = $request->blood_group;
        $user->marital_status = $request->marital_status;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->save();
        return  $user;
    }
}
