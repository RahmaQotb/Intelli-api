<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait GuardAccess
{
    public function scopeAccessByCurrentGuard(Builder $query): Builder
    {
        $guard = get_current_guard();

        if ($guard === 'admin') {
            return $query;
        }

        if ($guard === 'brand_admin') {
            $brandAdmin = Auth::guard($guard)->user();

            if ($brandAdmin && $brandAdmin->brand_id) {
                return $query->where('brand_id', $brandAdmin->brand_id);
            }
        }

        return $query->whereRaw('0 = 1');
    }
}