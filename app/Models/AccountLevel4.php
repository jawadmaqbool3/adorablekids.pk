<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountLevel4 extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];
    public function scopeGet($query)
    {
        return $query;
    }
    public function level3()
    {
        return $this->hasOne(AccountLevel3::class, 'id', 'parent_id');
    }

    public function calculatebalance()
    {
        return $this->balance;
    }
}
