@extends('layout.basic')
@section('page_title', 'Thousands of Products for your adorable kids are available here')
@section('meta_description', 'Thousands of Products for your adorable kids are available here')
@section('meta_keywords', 'Products, Adorables, Kids, Diapers, Blankets, Toys and Much More')
@section('content')
    <section class="hero">
        <div class="container">

            <div class="row">
                <x-bread-crumbs :links="[
                    'Home' => route('dashboard'),
                    'Products' => route('products.index'),
                ]" />
                <div class="col-md-3">
                    <div class="row">

                        <div class="col-md-12">
                            <x-all-categories-sidebar />
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <x-search-bar />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 border-bottom mb-5  mt-3 pb-0">
                            <h2 class="">Products For All Kids</h2>

                        </div>
                        <div class="col-md-12">

                            <x-products-paginator />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jsOutSide')
@endsection
