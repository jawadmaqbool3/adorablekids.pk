<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];
}
