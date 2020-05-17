@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register Accommodation</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.accommodations.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?? 'TestAccommodation' }}" required autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="capacity" class="col-md-4 col-form-label text-md-right">Guest Capacity</label>

                                <div class="col-md-6">
                                    <input id="capacity" type="number" class="form-control" name="capacity" value="{{ old('capacity') ?? 2 }}" required autocomplete="capacity">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
