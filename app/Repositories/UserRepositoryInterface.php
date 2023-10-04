<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * @return \App\Models\User
     */
    public function getBlankModel();

    public function registerUser($userData);
}
