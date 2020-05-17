@extends('layouts.app')

@section('content')

    <div class="col-12">
        <h2 class="text-center bg-secondary text-white">Guestboard</h2>
        <div class="col-md-12 mt-4 mb-3 text-center px-0">
            <h4>Actions</h4>
            <div class="col-md-4 offset-md-4 d-flex flex-column flex-sm-row justify-content-around px-0">
                <a href="{{ route( 'guests.create' ) }}" class="flex-sm-grow-1 btn btn-primary">New Guest</a>
            </div>
        </div>

        <form action="{{ route('guests.index') }}" method="GET">
            <div title="Filter here for the arrival date!">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="js-datepicker d-flex mb-1 mb-sm-0">
                        <input id="search_from_date" type="text" class="form-control" name="search_from_date" placeholder="Select from date.." data-input value="{{ old('search_from_date') }}">
                        <a class="btn" title="Clear" data-clear>
                            &#10539;
                        </a>
                    </div>
                    <div class="js-datepicker d-flex">
                        <input id="search_to_date" type="text" class="form-control" name="search_to_date" placeholder="Select to date.." data-input value="{{ old('search_to_date') }}">
                        <a class="btn" title="Clear" data-clear>
                            &#10539;
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-100 mt-3 ">
                <div class="d-flex flex-md-nowrap flex-wrap justify-content-center">
                    <div class="d-flex w-100">
                        <input id="search" class="form-control text-center" type="text" name="search" placeholder="Full Text Search" title="This field does a full text search for Guests in first name, last name, document, address, gender and notes!" value="{{ old('search') }}">
                        <button id="clear_search" type="button" class="btn">&#10539;</button>
                    </div>
                    <div class="d-flex mt-2 mt-md-0">
                        <button id="reset_guests_search" type="button" class="btn btn-outline-secondary btn-sm">Reset</button>
                        <button id="filter" type="submit" class="btn btn-outline-secondary btn-sm ml-1">Filter</button>
                    </div>
                </div>
            </div>
        </form>

        <hr>
        @if (count($guests) > 0)
            {{--Paginator goes here--}}
            <div class="d-flex justify-content-center"><span>{{ $guests->links() }}</span></div>

            <div class="d-flex flex-wrap justify-content-between align-content-between align-items-center align-self-center">

                {{--Drawing cards for guests--}}
                @foreach($guests as $booking)
                  <div class="col-lg-4 col-md-6">
                    <div  class="card border-dark p-0 mb-4">

                        <div class="card-header" tabindex="0" role="button" data-toggle="popover" data-html="true" data-trigger="focus" title="Booking information"
                             data-content="Arrival: {{ $booking['start']->format('d.m.Y') }}<br>
                                           Departure: {{ $booking['end'] }}<br>
                                           @if($booking['fellows'])
                                            <span>Fellows Travelling:</span><br>
                                                @foreach($booking['fellows'] as $fellow)
                                                    | {{ $fellow->first_name }} {{ $fellow->last_name }}
                                                @endforeach
                                           @endif
                                           ">

                            <h4 class="card-title mt-2 text-center" title="Click me, for more information!">{{ $booking['start']->format('d.m.') }} - {{ $booking['end'] }}</h4>
                            <h6 class="card-subtitle text-muted text-center">Number of visitors {{ $booking['count'] }}</h6>
                            <span class="d-block text-center">Acc.: {{ $booking['accommodation'] }}</span>
                        </div>

                        <div class="card-body d-flex-column justify-content-center">
                            @foreach($booking['guests'] as $guest)
                                <div data-href="{{ route('guests.show', $guest->id) }}" class="guest_box rounded p-1 d-flex justify-content-around align-items-baseline ">
                                    <h5 class="card-text text-center m-0">{{ $guest->first_name }} {{ $guest->last_name }}</h5><small class="align-self-center">{!! $guest->flag !!} {{ $guest->citizenship }}</small>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer text-center p-0 m-0">
                            <small class="text-muted">created {{ $booking['created_at'] !== 0 ? $booking['created_at']." days ago" : 'today'}} by {{ $booking['created_by'] }}</small>
                        </div>

                    </div>
                  </div>
                @endforeach
            </div>
        @else
            </div>
            <p class="mx-auto">No guests found!</p>
        @endif

    </div>
@endsection
