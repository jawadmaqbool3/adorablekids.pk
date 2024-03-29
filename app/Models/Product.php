<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\Facades\DataTables;

class Product extends UIDModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeGet($query)
    {
        return $query;
    }

   

    public function calculatePrice($units)
    {
        return $this->unit_price * $units;
    } 

    public function scopePublished($query)
    {
        $today = Carbon::now();
        return $query->where('status', 'published')->orWhere(function ($query) use ($today) {
            $query->where('status', 'scheduled')->whereDate('published_date', '<=', $today->format('Y-m-d'));
        });
    }


    public function scopeFeatured($query)
    {
        return $query->whereHas('feature');
    }


    public function scopeDataTable($query)
    {
        $products = $query;
        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('thumbnail', function ($product) {
                if (!$product->thumbnail) {
                    return "Image not available";
                }
                return  '<div class="d-flex align-items-center">
                <div class="symbol symbol-45px me-5">
                    <img alt="thumbnail" src="' . asset("assets/media/products/thumbs/" . $product->thumbnail) . '">
                </div>
            </div>';
            })
            ->editColumn('status', function ($product) {
                $text = ucwords($product->status);
                if ($product->status == 'published') {
                    $color = 'btn-success';
                } elseif ($product->status == 'unpublished') {
                    $color = 'btn-warning';
                } else {
                    $text = $text . ' (' . date('d M, Y h:i A', strtotime($product->published_date)) . ')';
                    $color = 'btn-danger';
                }
                return '<button class="btn btn-sm ' . $color . '">' . $text . '</button>';
            })
            ->addColumn('action', function ($product) {
                $btns = [];
                if (auth()->user()->hasPermission('edit product')) {
                    $btns[] = '<a title="edit product" href="' . route('products.edit', $product->uid) . '"  class="mx-1 float-end btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </a>';
                }
                if (auth()->user()->hasPermission('delete product')) {
                    $btns[] = '<a href="#" title="delete product" data-bs-target="#delete_modal" data-bs-toggle="modal" data-modal_id="' . $product->uid . '" data-modal_name="' . $product->name . '" data-modal_title="Delete ' . $product->name . '?" class="mx-1 float-end btn btn-icon btn-bg-light btn-active-color-primary btn-sm modal-button">
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </a>';
                }
                if (auth()->user()->hasPermission('print barcode')) {
                    $btns[] = '<a title="generate bar-code" target="_blank" href="' . route('print.barcode', $product->uid) . '"  class="mx-1 float-end btn btn-icon btn-bg-light btn-active-color-primary btn-sm modal-button">
                    <span class="svg-icon svg-icon-3">
                    <span class="bi bi-qr-code"></span>
                    </span>
                </a>';
                }
                if (count($btns)) {
                    return implode($btns);
                } else {
                    return null;
                }
            })
            ->rawColumns(['action', 'thumbnail', 'status'])
            ->make(true);
    }

    public function scopeStockTable($query)
    {
        $products = $query;
        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('thumbnail', function ($product) {
                if (!$product->thumbnail) {
                    return "Image not available";
                }
                return  '<div class="d-flex align-items-center">
                <div class="symbol symbol-45px me-5">
                    <img alt="thumbnail" src="' . asset("assets/media/products/thumbs/" . $product->thumbnail) . '">
                </div>
            </div>';
            })
            ->editColumn('stock', function ($product) {
                $html = '';
                if ($product->stock == 0) {
                    $html = '<span class="badge py-3 px-4 fs-7 badge-light-danger">Out of Stock</span>';
                } elseif ($product->stock < 10) {
                    $html = '<span class="badge py-3 px-4 fs-7 badge-light-warning">Low Stock</span>';
                } else {
                    $html = '<span class="badge py-3 px-4 fs-7 badge-light-primary">In Stock</span>';
                }
                return $html;
            })
            ->addColumn('quantity', function ($product) {
                return $product->stock . ' PCS';
            })
            ->rawColumns(['stock'])
            ->make(true);
    }

    public function categories()
    {
        return $this->hasManyThrough(
            Category::class,
            ProductCategories::class,
            'product_id',
            'id',
            'id',
            'category_id',
        );
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            OrderProduct::class,
            'product_id',
            'id',
            'id',
            'order_id',
        );
    }

    public function wishListUsers()
    {
        return $this->hasManyThrough(
            User::class,
            UserWishlist::class,
            'product_id',
            'id',
            'id',
            'user_id',
        );
    }


    public function cartListUsers()
    {
        return $this->hasManyThrough(
            User::class,
            UserCart::class,
            'product_id',
            'id',
            'id',
            'user_id',
        );
    }

    public function feature()
    {
        return $this->hasOne(
            Feature::class,
            'feature_id',
            'id'
        )->where('type', 'product');
    }
}
