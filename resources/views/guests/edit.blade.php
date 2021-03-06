@extends('layouts.app')

@section('content')
    <div class="row mx-2">
        <div class="col-12 col-lg-8 offset-lg-2">
            <h3 class="text-center">Editing Guest Record!</h3>

            <form action="{{ action('GuestController@update', $guest->id)}}" method='POST'>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="d-flex justify-content-center justify-content-sm-start col-12">
                        <a href="{{ route('guests.show', $guest->id) }}" class="btn btn-sm btn-secondary mr-2">Go Back</a>
                        <input class="btn btn-sm btn-success mr-2" type="submit" value="Save">
                    </div>

                    <div class="form-group col-12 mt-3">
                        <label for="accommodation">Accommodation</label>
                        <select class="form-control custom-select" name="accommodation_id" required>
                            @foreach($accommodations as $accommodation)
                                @if ($accommodation)
                                    <option value="{{ $accommodation->id }}" {{ $accommodation->id === $guest->accommodation_id ? 'selected' : '' }}>{{ $accommodation->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="first_name">First Name</label>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') ?? $guest->first_name }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="last_name">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? $guest->last_name }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="citizenship">Citizenship</label>
                        <select class="form-control custom-select" name="citizenship" required>
                            @foreach($countries as $country)
                                <option value="{{ $country }}"
                                    @if(old('citizenship') AND $country === old('citizenship')) selected
                                    @else {{ $country === $guest->citizenship ? 'selected' : '' }}
                                    @endif
                                >{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Gender:</label>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input id="male" type="radio" class="form-check-input" name="gender" value="male" @if(old('gender') === 'male') checked @elseif(!old('gender')) {{ $guest->gender === 'male' ? 'checked' : '' }} @endif required>
                                <label for="male" class="form-check-label mr-2">Male</label>
                                <input id="female" type="radio" class="form-check-input" name="gender" value="female" @if(old('gender') === 'female') checked @elseif(!old('gender')) {{ $guest->gender === 'female' ? 'checked' : '' }} @endif>
                                <label for="female" class="form-check-label">Female</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="birth_date">Birth Date</label>
                        <div class="js-datepicker d-flex pr-0">
                            <input id="birth_date" type="text" name="birth_date" placeholder="Select date.." value="{{ old('birth_date') ?? $guest->birth_date }}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>IDtype:</label>
                        <div class="col">
                            <div class="form-check form-check-inline ">
                                <input id="passport" type="radio" class="form-check-input" name="document_type" value="Passport" @if(old('document_type') === 'Passport') checked @elseif(!old('document_type')) {{ $guest->document_type === 'Passport' ? 'checked' : '' }} @endif required>
                                <label for="passport" class="form-check-label mr-2">Passport</label>
                                <input id="idcard" type="radio" class="form-check-input" name="document_type" value="IDCard" @if(old('document_type') === 'IDCard') checked @elseif(!old('document_type')) {{ $guest->document_type === 'IDCard' ? 'checked' : '' }} @endif>
                                <label for="idcard" class="form-check-label">IDcard</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="document">Identity Document</label>
                        <input id="document" type="text" class="form-control" name="document" title="Passport or id-card, id-number, year of issue, issuing authority, country" value="{{ old('document') ?? $guest->document }}" required>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="address">Address</label>
                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') ?? $guest->address }}" required>
                    </div>

                    <div class="w-100">
                        <div class="d-flex">
                            <h5 title="Only for travellers which are part of a family!">Fellow Travelers - Family</h5>
                            <button id="add_row" type="button" class="ml-3 btn btn-sm btn-outline-primary rounded">+</button>
                        </div>
                        <div id="base" class="d-flex-column my-2 w-100">
                            @if($fellows->count() > 0)
                                @foreach($fellows as $fellow)

                                    <div class="d-flex flex-sm-row flex-column fellow bg-light my-2">
                                        <div class="form-group col-md-4">
                                            <label for="first_name100{{ $fellow->id }}">First Name</label>
                                            <input type="text" id="first_name100{{ $fellow->id }}" class="form-control" name="fellows[100{{ $fellow->id }}][first_name]" value="{{ old('fellows')['100'.$fellow->id]['first_name'] ?? $fellow->first_name }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="last_name100{{ $fellow->id }}">Last Name</label>
                                            <input type="text" id="last_name100{{ $fellow->id }}" class="form-control" name="fellows[100{{ $fellow->id }}][last_name]" value="{{ old('fellows')['100'.$fellow->id]['last_name'] ?? $fellow->last_name }}">
                                        </div>

                                        <div class="form-group col-md-4 d-flex justify-content-between">
                                            <div class="d-flex flex-column w-75">
                                                <label for="birth_date100{{ $fellow->id }}">Birth Date</label>
                                                <div class="js-datepicker datepickerSet d-flex">
                                                    <input type="text" id="birth_date100{{ $fellow->id }}" name="fellows[100{{ $fellow->id }}][birth_date]" placeholder="Select date.." value="{{ old('fellows')['100'.$fellow->id]['birth_date'] ?? $fellow->birth_date}}" data-input>
                                                    <a class="btn" title="Clear" data-clear>
                                                        &#10539;
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center mt-4 ml-4 w-25">
                                                <button id="delete{{ $fellow->id }}" type="button" class=" btn btn-sm btn-outline-danger artificial_delete">&#10539;</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{--Here the HTML for new fellows is dropped via Javascript --}}
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="arrival_date">Arrival Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="arrival_date" type="text" name="arrival_date" placeholder="Select date.." value="{{ old('arrival_date') ?? $guest->arrival_date }}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="est_departure_date">Estimated Departure Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="est_departure_date" type="text" name="est_departure_date" placeholder="Select date.." value="{{ old('est_departure_date') ?? $guest->est_departure_date}}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    @can('manage-app')
                    <div class="form-group col-md-4">
                        <label for="act_departure_date">Actual Departure Date</label>
                        <div class="js-datetimepicker d-flex pr-0">
                            <input id="act_departure_date" type="text" name="act_departure_date" placeholder="Not checked out yet.." value="@if(old('act_departure_date')) {{ old('act_departure_date') }} @else {{ $guest->act_departure_date ?? '' }} @endif" data-input>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>
                    @endcan

                    <div class="form-group col-12">
                        <label for="notes">Notes</label>
                        <input id="notes" type="text" class="form-control" name="notes" placeholder="Put some notes here!" value="{{ old('notes') ?? $guest->notes }}">
                    </div>

                    <div class="form-group col-12 d-sm-flex">
                        <canvas id="canvass" class="border border-success" width="300" height="100">
                            This text is displayed if your browser does not support HTML5 Canvas. You cannot use
                            this form, please ask the administrator how to register guests in the event of
                            browser incompatibility.
                        </canvas>
                        <div class="ml-sm-3 d-flex flex-sm-column justify-content-around">
                            <button id="clear_signature" type="button" class="btn btn-outline-danger">Clear Signature</button>
                            <button id="save_signature" type="button" class="btn btn-outline-primary">Accept Signature</button>
                            <input id="signature" type="text" class="d-none" name="signature">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-start col-12">
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
