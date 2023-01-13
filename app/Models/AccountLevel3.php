<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountLevel3 extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public function scopeGet($query)
    {
        return $query;
    }
    public function level2()
    {
        return $this->hasOne(AccountLevel2::class,  'id', 'parent_id');
    }
    public function level4()
    {
        return $this->hasMany(AccountLevel4::class, 'parent_id', 'id');
    }

    public function calculatebalance()
    {
        $level3 = $this;
        return AccountLevel4::whereHas('level3', function ($query) use ($level3) {
            $query->where('id', $level3->id);
        })->sum('balance');
    }
}
