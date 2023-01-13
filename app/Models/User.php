<?php

namespace App\Models;

use App\Core\Helper;
use App\Http\Traits\EmployeeTrait;
use App\Http\Traits\OrderTrait;
use App\Http\Traits\RoleTrait;
use App\Http\Traits\UserDataTableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Yajra\DataTables\Facades\DataTables;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        OrderTrait,
        RoleTrait;
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uid = Helper::_uid();
        });
    }
    public function resetKey()
    {
        $this->primaryKey = 'id';
        $this->incrementing = true;
    }

    public function scopeGet($query)
    {
        return $query;
    }








    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
