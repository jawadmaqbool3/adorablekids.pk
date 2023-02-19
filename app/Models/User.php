<?php

namespace App\Models;

use App\Core\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable;
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


    public function hasWishListProduct($product)
    {
        return UserWishlist::where('product_id', $product->id)->where('user_id', $this->id)->exists();
    }

    public function hasCartProduct($product)
    {
        return UserCart::where('product_id', $product->id)->where('user_id', $this->id)->exists();
    }



    public function wishlistProducts()
    {
        return $this->hasManyThrough(
            Product::class,
            UserWishlist::class,
            'user_id',
            'id',
            'id',
            'product_id',
        );
    }
    
    public function cartProducts()
    {
        return $this->hasManyThrough(
            Product::class,
            UserCart::class,
            'user_id',
            'id',
            'id',
            'product_id',
        );
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
