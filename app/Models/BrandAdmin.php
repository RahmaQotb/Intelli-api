<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;
class BrandAdmin extends Authenticatable
{
    use HasFactory,HasRoles;

    protected $fillable = ['name', 'email', 'password', 'is_super_brand_admin', 'brand_id'];

    protected $guard_name = 'brand_admin';

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
