@extends('layout.basic')
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css" />
@section('content')
@section('page_title', 'Order Confirmation')
<section class="hero">
    <div class="container">
        <x-bread-crumbs :links="[
            'Home' => route('dashboard'),
            'Cart' => route('cart.index'),
            'Order Confirmation' => '',
        ]" />
        <div class="row shadow rounded">
            {{-- <div class="col-md-4 p-0">
                @php
                    $random = rand(1, 3);
                @endphp
                <img style="height:100%" src="{{ asset('assets/img/auth' . $random . '.jpg') }}" alt="">
            </div> --}}
            <div class="col-md-12 bg-light p-0 py-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center mt-5">
                                <h3>Confirm Your Order</h3>
                            </div>
                            <div class="col-md-12 ">
                                <form action="{{ route('orders.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SR</th>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $amount = 0;
                                                    @endphp
                                                    @foreach ($products as $key => $product)
                                                        <input type="hidden" value="{{ $product->uid }}"
                                                            name="products[]">
                                                        <input type="hidden" value="{{ $quantities[$key] }}"
                                                            name="quantities[]">
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td class="text-right">{{ $quantities[$key] }}</td>
                                                            <td class="text-right">
                                                                {{ $product->calculatePrice($quantities[$key]) }}
                                                                {{ config('app.currency') }}</td>
                                                            @php
                                                                $amount += $product->calculatePrice($quantities[$key]);
                                                            @endphp
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total</th>
                                                        <th class="text-right" colspan="2">{{ $amount }}
                                                            {{ config('app.currency') }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Delivery Address<b
                                                        class="text-danger">*</b></label>
                                                <textarea required class="form-control" name="delivery_address" id="delivery_address" rows="3">{{ @$user->details->address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to
                                                Cart</a>
                                            <button type="submit" class="float-right btn btn-primary">Confirm</button>
                                        </div>
                                    </div>
                                </form>
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
