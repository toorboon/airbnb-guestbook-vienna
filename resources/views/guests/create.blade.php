@extends('layouts.app')

@section('content')
    <div class="row mx-2">
        <div class="col-12 col-lg-8 offset-lg-2">
            <div>
                <h3 class="text-center">Register Guests here!</h3>

                @if (auth()->user()->role->name === 'Guest')
                    <h5 class="text-center">
                        Booking for accommodation:
                        <strong>
                            @if (auth()->user()->accommodation)
                                {{ auth()->user()->accommodation->name }}
                            @else
                                No accommodation selected! Please contact your Admin!
                            @endif
                        </strong>
                    </h5>
                @endif
            </div>
            <form action="{{ action('GuestController@store')}}" method="POST">
				@csrf
			    <div class="row">
                    @can('manage-app')
                        <div class="form-group col-12">
                            <label for="accommodation" class="">Accommodation</label>
                            <select class="form-control custom-select" name="accommodation_id" required>
                                @foreach($accommodations as $accommodation)
                                    @if ($accommodation)
                                        <option value="{{ $accommodation->id }}">{{ $accommodation->name }}</option>
                                    @endif
                                @endforeach
                                <option disabled >Please choose an accommodation</option>
                            </select>
                        </div>
                    @endcan

				    <div class="form-group col-md-4">
						<label for="first_name" class="">First Name</label>
				  		<input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
				    </div>

                    <div class="form-group col-md-4">
                        <label for="last_name" class="">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="citizenship">Citizenship</label>
                        <select class="form-control custom-select" name="citizenship" required>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ old('citizenship') === $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                            <option disabled {{ old('citizenship') ? '' : 'selected' }}>Please choose country</option>
                        </select>
                    </div>

					<div class="form-group col-md-4">
					  	<label>Gender:</label>
					  	<div class="col">
					  		<div class="form-check form-check-inline">
					  			<input id="male" type="radio" class="form-check-input" name="gender" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
					  			<label for="male" class="form-check-label mr-2">Male</label>
					  			<input id="female" type="radio" class="form-check-input" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }}>
					  			<label for="female" class="form-check-label">Female</label>
					  		</div>
					  	</div>
					</div>

					<div class="form-group col-md-4">
						<label for="birth_date">Birth Date</label>
				  		<div class="js-datepicker d-flex">
                            <input id="birth_date" type="text" name="birth_date" placeholder="Select date.." value="{{ old('birth_date') ?? (new \Carbon\Carbon())->subYears(18) }}" data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>IDtype:</label>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input id="passport" type="radio" class="form-check-input" name="document_type" value="Passport" {{ old('document_type') === 'Passport' ? 'checked' : '' }} required>
                                <label for="passport" class="form-check-label mr-2">Passport</label>
                                <input id="idcard" type="radio" class="form-check-input" name="document_type" value="IDCard" {{ old('document_type') === 'IDCard' ? 'checked' : '' }}>
                                <label for="idcard" class="form-check-label">IDcard</label>
                            </div>
                        </div>
                    </div>

				    <div class="form-group col-md-4">
						<label for="document" class="">Identity Document</label>
				  		<input id="document" type="text" class="form-control" name="document" value="{{ old('document') }}" title="Passport or id-card: id-number, year of issue, issuing authority, country" required>
				    </div>

				    <div class="form-group col-md-8">
						<label for="address" class="">Address</label>
				  		<input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" title="Street, ZIP, City, Country" required>
				    </div>

                    <div class="col-12">
                        <div class="d-flex">
                            <h5 title="Only for travellers which are part of a family!">Fellow Travelers - Family</h5>
                            <button id="add_row" type="button" class="ml-3 btn btn-sm btn-outline-primary rounded"><strong>&#43;</strong></button>
                        </div>
                        <div id="base" class="d-flex-column my-2 w-100">
                            {{--Here the HTML for new fellows is dropped via Javascript signature.js --}}
                        </div>
                    </div>

				    <div class="form-group col-md-4">
						<label for="arrival_date">Arrival Date</label>
                        <div class="js-datetimepicker d-flex">
                            <input id="arrival_date" type="text" class="form-control" name="arrival_date" value="{{ old('arrival_date') }}" placeholder="Select date.." data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

				    <div class="form-group col-md-4">
						<label for="est_departure_date">Estimated Departure Date</label>
                        <div class="js-datetimepicker d-flex">
				  		    <input id="est_departure_date" type="text" class="form-control" name="est_departure_date" value="{{ old('est_departure_date') }}" placeholder="Select date.." data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    @can('manage-app')
				    <div class="form-group col-md-4">
						<label for="act_departure_date">Actual Departure Date</label>
                        <div class="js-datetimepicker d-flex">
				  		    <input id="act_departure_date" type="text" class="form-control" name="act_departure_date" value="{{ old('act_departure_date') }}" placeholder="Select date.." data-input>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>
                    @endcan

				    <div class="form-group col-12">
						<label for="notes">Notes</label>
				  		<input id="notes" type="text" class="form-control" name="notes" value="{{ old('notes') }}" placeholder="Put some notes here!">
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
				        <a href="{{ route( 'guests.index' ) }}" class="btn btn-sm btn-secondary mr-2">Go Back</a>
				        <input class="btn btn-sm btn-primary mr-2" type="submit" value="Save">
                        <input class="btn btn-sm btn-primary" type="submit" name="save_back" value="Save and New">
                    </div>
				</div>
			</form>
		</div>
    </div>
@endsection

@section('pagespecificscripts_signature')
    <script defer src="{{asset( 'js/signature.js' )}}" type="text/javascript" charset="utf-8"></script>
@endsection
