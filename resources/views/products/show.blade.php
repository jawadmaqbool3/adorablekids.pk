@extends('layout.basic')
@section('page_title', $product->meta_title ?? $product->name)
@section('meta_description', $product->meta_description)
@section('meta_keywords', $product->meta_keywords)
@section('content')
    <section class="hero">
        <div class="container">

            <div class="row">
                <x-bread-crumbs :links="[
                    'Home' => route('dashboard'),
                    $product->name => route('product.show', $product->uid),
                ]" />
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <x-page-slider :prefix="$product->name" :images="json_decode($product->images)" />
                        </div>
                        <div class="col-md-12">
                            <x-all-categories-sidebar />
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <x-search-bar />

                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="border-bottom mb-5 pb-3 mt-3">{{ $product->name }}</h2>
                            <x-description :text="$product->description" />
                        </div>
                        <div class="col-md-4">
                            <div class="card text-start">
                                <div class="card-body">
                                    @if ($product->stock)
                                        <p class="mb-1">Available Stock <span
                                                class="float-right">{{ $product->stock }}</span>
                                        </p>
                                        <p>Price <span class="float-right">{{ $product->unit_price }}
                                                {{ config('app.currency') }}</span></p>
                                    @else
                                        <p class="text-center"><strong>Out of Stock</strong></p>
                                    @endif
                                    <div class="col-12 text-center">
                                        <ul class="featured__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            @if ($product->stock)
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jsOutSide')
@endsection
