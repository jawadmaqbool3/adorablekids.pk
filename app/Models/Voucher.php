<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function voucherType()
    {
        return $this->hasOne(VoucherType::class, 'id', 'voucher_type_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'voucher_id', 'id');
    }

    
}
