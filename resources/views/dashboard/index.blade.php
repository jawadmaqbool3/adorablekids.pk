@extends('layout.basic')
@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-all-categories-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-12">
                            <x-search-bar />
                        </div>
                    </div>
                    <x-dashboard-slider />
                </div>
            </div>
        </div>
    </section>

    <section class="categories mt-5">
        <div class="container">
            <div class="row">
                <x-featured-categories-slider />
            </div>
        </div>
    </section>

    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <x-featured-product-grid />
            </div>
        </div>
    </section>

   
@endsection
@section('jsOutSide')
@endsection
