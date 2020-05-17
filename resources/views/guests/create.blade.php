@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8 offset-2">
            <div>
                <h3>Register Guests here!</h3>

                @if (auth()->user()->role->name === 'Guest')
                    <h5 class="text-center">Booking for accommodation: <strong>{{ auth()->user()->accommodation->name }}</strong></h5>
                @endif
            </div>
            <form action="{{ action('GuestController@store')}}" method="POST">
				@csrf
			    <div class="row">
                    @can('manage-app')
                        <div class="form-group col-lg-12 col-md-8">
                            <label for=accommodation" class="">Accommodation</label>
                            <select class="form-control" name="accommodation_id" required>
                                @foreach($accommodations as $accommodation)
                                    <option value="{{ $accommodation->id }}">{{ $accommodation->name }}</option>
                                @endforeach
                                <option disabled selected>Please choose an accommodation you want to book a guest for</option>
                            </select>
                        </div>
                    @endcan

				    <div class="form-group col-lg-4 col-md-8">
						<label for="first_name" class="">First Name</label>
				  		<input id="first_name" type="text" class="form-control" name="first_name" required>
				    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="last_name" class="">Last Name</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" required autofocus>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label for="citizenship" class="">Citizenship</label>
                        <select class="form-control" name="citizenship" required>
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                            <option disabled selected>Please choose a country</option>
                        </select>
                    </div>

					<div class="form-group col-lg-4 col-md-8">
					  	<label class="col-2">Gender:</label>
					  	<div class="col-4">
					  		<div class="form-check form-check-inline">
					  			<input id="male" type="radio" class="form-check-input" name="gender" value="male" required>
					  			<label for="male" class="form-check-label mr-2">Male</label>
					  			<input id="female" type="radio" class="form-check-input" name="gender" value="female">
					  			<label for="female" class="form-check-label">Female</label>
					  		</div>
					  	</div>
					</div>

					<div class="form-group col-lg-4 col-md-8">
						<label for="birth_date">Birth Date</label>
				  		<div class="js-datepicker d-flex">
                            <input id="birth_date" type="text" name="birth_date" placeholder="Select date.." data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

                    <div class="form-group col-lg-4 col-md-8">
                        <label class="col-2">IDtype:</label>
                        <div class="col-4">
                            <div class="form-check form-check-inline">
                                <input id="passport" type="radio" class="form-check-input" name="document_type" value="Passport" required>
                                <label for="passport" class="form-check-label mr-2">Passport</label>
                                <input id="idcard" type="radio" class="form-check-input" name="document_type" value="IDCard">
                                <label for="idcard" class="form-check-label">IDcard</label>
                            </div>
                        </div>
                    </div>

				    <div class="form-group col-lg-6 col-md-8">
						<label for="document" class="">Identity Document</label>
				  		<input id="document" type="text" class="form-control" name="document" title="Passport or id-card: id-number, year of issue, issuing authority, country" required>
				    </div>

				    <div class="form-group col-lg-6 col-md-8">
						<label for="address" class="">Address</label>
				  		<input id="address" type="text" class="form-control" name="address" title="Street, ZIP, City, Country" required>
				    </div>

                    <div class="w-100">
                        <div class="d-flex">
                            <h5 title="Only for travellers which are part of a family!">Fellow Travelers - Family</h5>
                            <button id="add_row" type="button" class="ml-3 btn btn-sm btn-outline-primary rounded"><strong>&#43;</strong></button>
                        </div>
                        <div id="base" class="d-flex-column mb-3">
                            {{--Here the HTML for new fellows is dropped via Javascript signature.js --}}
                        </div>
                    </div>

				    <div class="form-group col-lg-4 col-md-8">
						<label for="arrival_date">Arrival Date</label>
                        <div class="js-datetimepicker d-flex">
                            <input id="arrival_date" type="text" class="form-control" name="arrival_date" placeholder="Select date.." data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

				    <div class="form-group col-lg-4 col-md-8">
						<label for="est_departure_date">Estimated Departure Date</label>
                        <div class="js-datetimepicker d-flex">
				  		    <input id="est_departure_date" type="text" class="form-control" name="est_departure_date" placeholder="Select date.." data-input required>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

				    <div class="form-group col-lg-4 col-md-8">
						<label for="act_departure_date">Actual Departure Date</label>
                        <div class="js-datetimepicker d-flex">
				  		    <input id="act_departure_date" type="text" class="form-control" name="act_departure_date" placeholder="Select date.." data-input>
                            <a class="btn" title="Clear" data-clear>
                                &#10539;
                            </a>
                        </div>
                    </div>

				    <div class="form-group col-12">
						<label for="notes">Notes</label>
				  		<input id="notes" type="text" class="form-control" name="notes" placeholder="Put some notes here!">
				  	</div>

				  	<div class="form-group col-12 d-flex">
					    <canvas class="border border-success" width="400" height="100">
					  		This text is displayed if your browser does not support HTML5 Canvas. You cannot use
                            this form, please ask the administrator how to register guests in the event of
                            browser incompatibility.
				    	</canvas>
                        <div class="ml-3 btn-group-vertical">
                            <button id="clear_signature" type="button" class="btn btn-outline-danger">Try Again</button>
                            <button id="save_signature" type="button" class="btn btn-outline-primary">Accept Signature</button>
                            <input id="signature" type="text" class="d-none" name="signature">
                        </div>
				  	</div>
                    <div class="d-flex">
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
