<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class SystemRole extends Role
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $fillable = ["name", "active", "guard_name"];
}
