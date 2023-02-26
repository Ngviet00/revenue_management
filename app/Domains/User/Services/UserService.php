<?php

namespace App\Domains\User\Services;

use App\Domains\User\Models\User;
use App\Services\BaseService;

class UserService extends BaseService
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
