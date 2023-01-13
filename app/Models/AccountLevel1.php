<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountLevel1 extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public function scopeGet($query)
    {
        return $query;
    }
    public function level2()
    {
        return $this->hasMany(AccountLevel2::class, 'parent_id', 'id');
    }

    public function calculatebalance()
    {
        $level1 = $this;
        return AccountLevel4::whereHas('level3.level2.level1', function ($query) use ($level1) {
            $query->where('id', $level1->id);
        })->sum('balance');
    }
}
