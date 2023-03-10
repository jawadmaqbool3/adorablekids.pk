@extends('layout.basic')
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css" />
@section('content')
@section('page_title', 'adorablekids.pk customer registation form')
<section class="hero">
    <div class="container">
        <x-bread-crumbs :links="[
            'Home' => route('dashboard'),
            'Customer Registration Form' => route('registration.form'),
        ]" />
        <div class="row shadow rounded">
            <div class="col-md-8 bg-light p-0 py-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <h3>User Registration Form</h3>
                            </div>
                            <div class="col-md-12 ">
                                <form data-ajax="true" action="{{ route('customer.store') }}" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 ">
                                            <div class="mb-3">
                                                <label for="" class="form-label">First Name <b
                                                        class="text-danger">*</b></label>
                                                <input maxlength="20" required type="text" name="name"
                                                    id="first_name" class="form-control" placeholder="e.g. John">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Last Name</label>
                                                <input maxlength="20" type="text" name="last_name" id="last_name"
                                                    class="form-control" placeholder="e.g. Doe">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Cell No. <b
                                                        class="text-danger">*</b></label>
                                                <input maxlength="10" required type="text" name="cell_no"
                                                    id="cell_no" class="form-control" placeholder="e.g. 3445909505">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Email <b
                                                        class="text-danger">*</b></label>
                                                <input maxlength="30" required type="email" name="email"
                                                    id="email" class="form-control"
                                                    placeholder="e.g. jawadmaqboo32@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Address</label>
                                                <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="" class="form-label">Password <b
                                                                class="text-danger">*</b></label>
                                                        <input maxlength="30" required type="password" name="password"
                                                            id="password" class="form-control">
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="" class="form-label">Confirm Password <b
                                                                class="text-danger">*</b></label>
                                                        <input maxlength="30" required type="password"
                                                            name="password_confirmation" id="password_confirmation "
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="site-btn float-right">Submit</button>
                                            <a type="submit" class="site-btn float-right bg-primary"
                                                href="{{ route('dashboard') }}">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4 p-0">
                @php
                    $random = rand(1, 3);
                @endphp
                <img style="height:100%" src="{{ asset('assets/img/auth' . $random . '.jpg') }}" alt="">
            </div>
        </div>
</section>
@endsection
@section('jsOutSide')
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    var input = document.querySelector("#cell_no");
    window.intlTelInput(input, {
        separateDialCode: true,
        preferredCountries: ["pk", "us"]
    });
</script>
@endsection
