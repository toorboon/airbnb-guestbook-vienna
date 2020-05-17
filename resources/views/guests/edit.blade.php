@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8 offset-2">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Editing Guest Record!</h3>
            </div>

            <form action="{{ action('GuestController@update', $guest->id)}}" method='POST'>
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-12">
                        <a href="{{ route('guests.show', $guest->id) }}" class="btn btn-sm btn-secondary mr-2">Go Back</a>
                        <input class="btn btn-sm btn-success mr-2" type="submit" value="Save">
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="last_name">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{$guest->last_name}}" required>
                    </div>
                    <div class="form-group col-lg-4 col-md-8">
                        <label for="first_name">First Name</label>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{$guest->first_name}}" required>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="citizenship">Citizenship</label>
                        <input id="citizenship" type="text" class="form-control" name="citizenship" value="{{$guest->citizenship}}" required>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label class="col-2">Gender:</label>
                        <div class="col-4">
                            <div class="form-check form-check-inline">
                                <input id="male" type="radio" class="form-check-input" name="gender" value="male" {{$guest->gender === 'male' ? 'checked' : ''}} required>
                                <label for="male" class="form-check-label mr-2">Male</label>
                                <input id="female" type="radio" class="form-check-input" name="gender" value="female" {{$guest->gender === 'female' ? 'checked' : ''}}>
                                <label for="female" class="form-check-label">Female</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="birth_date">Birth Date</label>
                        <div class="js-datepicker d-flex pr-0">
                            <input id="birth_date" type="text" name="birth_date" placeholder="Select date.." value="{{$guest->birth_date}}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8 pl-3">
                        <label class="d-block">IDtype:</label>
                        <div class="form-check form-check-inline">
                            <input id="passport" type="radio" class="form-check-input" name="document_type" value="Passport" {{$guest->document_type === 'Passport' ? 'checked' : ''}} required>
                            <label for="passport" class="form-check-label mr-2">Passport</label>
                            <input id="idcard" type="radio" class="form-check-input" name="document_type" value="IDCard" {{$guest->document_type === 'IDCard' ? 'checked' : ''}}>
                            <label for="idcard" class="form-check-label">IDcard</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-8">
                        <label for="document">Identity Document</label>
                        <input id="document" type="text" class="form-control" name="document" title="Passport or id-card, id-number, year of issue, issuing authority, country" value="{{$guest->document}}" required>
                    </div>

                    <div class="form-group col-lg-6 col-md-8">
                        <label for="address">Address</label>
                        <input id="address" type="text" class="form-control" name="address" value="{{$guest->address}}" required>
                    </div>

                    <div class="w-100">
                        <div class="d-flex">
                            <h5 title="Only for travellers which are part of a family!">Fellow Travelers - Family</h5>
                            <button id="add_row" type="button" class="ml-3 btn btn-sm btn-outline-primary rounded">+</button>
                        </div>
                        <div id="base" class="d-flex-column mb-3">
                            @if($fellows->count() > 0)
                                @foreach($fellows as $fellow)
                                    <div class="d-flex fellow">

                                        <div class="form-group col-lg-4 col-md-8">
                                            <label for="first_name100{{$fellow->id}}">First Name</label>
                                            <input type="text" id="first_name100{{$fellow->id}}" class="form-control" name="fellows[100{{$fellow->id}}][first_name]" value="{{$fellow->first_name}}">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-8">
                                            <label for="last_name100{{$fellow->id}}">Last Name</label>
                                            <input type="text" id="last_name100{{$fellow->id}}" class="form-control" name="fellows[100{{$fellow->id}}][last_name]" value="{{$fellow->last_name}}">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-8 ">
                                            <label for="birth_date100{{$fellow->id}}">Birth Date</label>
                                            <div class="js-datepicker datepickerSet d-flex">
                                                <input type="text" id="birth_date100{{$fellow->id}}" name="fellows[100{{$fellow->id}}][birth_date]" placeholder="Select date.." value="{{$fellow->birth_date}}" data-input>
                                                <a class="btn" title="Clear" data-clear>
                                                    &#10539;
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-center mt-3 ml-4">
                                            <button id="delete{{$fellow->id}}" type="button" class=" btn btn-sm btn-outline-danger artificial_delete">X</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{--Here the HTML for new fellows is dropped via Javascript --}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="arrival_date">Arrival Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="arrival_date" type="text" name="arrival_date" placeholder="Select date.." value="{{$guest->arrival_date}}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="est_departure_date">Estimated Departure Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="est_departure_date" type="text" name="est_departure_date" placeholder="Select date.." value="{{\Carbon\Carbon::parse($guest->est_departure_date)->format('Y-m-d\TH:i:s')}}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="act_departure_date">Actual Departure Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="act_departure_date" type="text" name="act_departure_date" placeholder="Not checked out yet.." value="{{$guest->act_departure_date ?? ''}}" data-input>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label for="notes">Notes</label>
                        <input id="notes" type="text" class="form-control" name="notes" placeholder="Put some notes here!" value="{{$guest->notes}}">
                    </div>

                    <div class="form-group col-12 d-flex">
                        <canvas class="border border-success" width="400" height="100">
                            This text is displayed if your browser does not support HTML5 Canvas.
                        </canvas>
                        <div class="ml-3 btn-group-vertical">
                            <button id="clear_signature" type="button" class="btn btn-outline-danger">Clear Signature</button>
                            <button id="save_signature" type="button" class="btn btn-outline-primary">Accept Signature</button>
                            <input id="signature" type="text" class="d-none" name="signature">
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('guests.show', $guest->id) }}" class="btn btn-sm btn-secondary mr-2">Go Back</a>
                        <input class="btn btn-sm btn-success mr-2" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('pagespecificscripts_signature')
    <script defer src="{{asset('js/signature.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
