<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Product;
use App\Models\UserCart;
use App\Models\UserWishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('inde');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserWishlist  $userWishlist
     * @return \Illuminate\Http\Response
     */
    public function show(UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserWishlist  $userWishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserWishlist  $userWishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserWishlist  $userWishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserWishlist $userWishlist)
    {
        //
    }


    public function toggleProduct(Product $product)
    {

        DB::beginTransaction();
        try {
            
            $isAdded = UserCart::where('product_id', $product->id)
                ->where('user_id', auth()->user()->id)->exists();
            if ($isAdded) {
                UserCart::where('product_id', $product->id)
                    ->where('user_id', auth()->user()->id)->delete();
            } else {

                UserCart::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id
                ]);
            }
            DB::commit();
            return response([
                'success' => true,
                'event' => [
                    'name' => $isAdded ? 'product_removed_from_cart' : 'product_added_to_cart'
                ]
            ]);
        } catch (CustomException $e) {
            DB::rollBack();
            return response([
                $e->getLevel() => true,
                'message' => $e->getMessage(),
                'console' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'error' => true,
                'message' => 'Something went wrong',
                'console' => $e->getMessage(),
            ]);
        }
    }
}
