@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="jumbotron text-center">
                <h1 class="text-center">Welcome to the digital Airbnb Guestbook</h1>
                <hr>
                <p class="text-center">This application is used to fulfill the registration needs of the city of Vienna! Each and every visitor has to register in that application and his or her data will be kept for seven years as the law requires it.</p>
                <hr>
                @can('create-guest')
                    <a class="btn btn-lg btn-primary mx-auto" href="{{ route('guests.create') }}">Register a guest!</a>
                    <hr>
                @endcan
                <h5 class="text-center">You like this app?</h5>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="text-center" target="_top">

                    <!-- Identify your business so that you can collect the payments. -->
                    <input type="hidden" name="business" value="soledat@gmx.net">

                    <!-- Specify a Donate button. -->
                    <input type="hidden" name="cmd" value="_donations">

                    <!-- Specify details about the contribution -->
                    <input type="hidden" name="item_name" value="AirBnB Guestbook Vienna">
                    <input type="hidden" name="currency_code" value="EUR">

                    <!-- Display the payment button. -->
                    <input type="submit" class="btn btn-lg btn-success mx-auto d-none d-sm-block" value="&#128523; Buy me some chocolate! &#128523;" name="submit">
                    <input type="submit" class="btn btn-lg btn-success mx-auto d-sm-none d-block" value="&#128523; Donate? &#128523;" name="submit">

                </form>
            </div>
        </div>
    </div>
@endsection
