@extends('layout.basic')
@section('page_title', $category->meta_title ?? $category->name)
@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)
@section('content')
    <section class="hero">
        <div class="container">

            <div class="row">
                <x-bread-crumbs :links="[
                    'Home' => route('dashboard'),
                    $category->name => route('category.show', $category->uid),
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
                        <div class="col-md-12">
                            <h2 class="">{{ $category->name }}</h2>
                            <div class="border-bottom mb-5  mt-3 pb-0">
                                <x-description :text="$category->description" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <x-products-paginator :category="$category" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jsOutSide')
@endsection
