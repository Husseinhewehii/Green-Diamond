<?php

namespace App\Repositories\User;

use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function getUsers()
    {
        return QueryBuilder::for(User::class)
        ->allowedFilters(["first_name", "last_name", "phone", "type", "email", "active"])
        ->allowedSorts(["first_name", "last_name", "phone", "type", "email", "active"])
        ->paginate(10);
    }

}
