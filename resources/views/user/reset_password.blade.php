@extends('layout.basic')
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css" />
@section('content')
@section('page_title', 'adorablekids.pk customer login')
<section class="hero">
    <div class="container">
        <x-bread-crumbs :links="[
            'Home' => route('dashboard'),
            'Login' => route('login.form'),
        ]" />
        <div class="row shadow rounded">
            <div class="col-md-8 bg-light p-0 py-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center mt-5">
                                <h3>Reset Password</h3>
                            </div>
                            <div class="col-md-12 ">
                                <form data-ajax="true" action="{{ route('reset.password', $user->remember_token) }}"
                                    method="post">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Password <b
                                                        class="text-danger">*</b></label>
                                                <input maxlength="30" required type="password" name="password"
                                                    id="password" class="form-control">
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Confirm Password <b
                                                        class="text-danger">*</b></label>
                                                <input maxlength="30" required type="password"
                                                    name="password_confirmation" id="password_confirmation "
                                                    class="form-control">
                                            </div>
                                        </div>


                                        <div class="col-md-12 mt-2">
                                            <a href="{{ route('login.form') }}">Login?</a> <br>
                                            <a href="{{ route('registration.form') }}">Don't have account?</a> <br>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="site-btn float-right">Login</button>
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
