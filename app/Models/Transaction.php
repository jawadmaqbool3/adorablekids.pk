<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function voucher()
    {
        return $this->hasMany(Voucher::class, 'id', 'voucher_id');
    }

    public function account()
    {
        return $this->hasOne(AccountLevel4::class, 'id', 'account_id');
    }
}
