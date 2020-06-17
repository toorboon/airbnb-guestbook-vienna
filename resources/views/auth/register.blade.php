@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }} User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>



                        <div id="accommodation_box" class="form-group row mb-0">
                            <label for="accommodation" class="col-md-4 col-form-label text-md-right">{{ __('Accommodation') }}</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select" name="accommodation_id">
                                    @foreach($accommodations as $accommodation)
                                        <option value="{{ $accommodation->id }}">{{ $accommodation->name }}</option>
                                    @endforeach
                                    <option disabled selected>Please choose an accommodation</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-12  d-flex justify-content-between">
                                <div class="d-flex">
                                    <label for="role" class="col-form-label">{{ __('Role') }}</label>

                                    <div class="ml-2">
                                        <select id="role_selector" class="custom-select" name="role">
                                            <option value="Admin">Admin</option>
                                            <option value="Guest" selected>Guest</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="invite_checkbox">
                                    <div class="d-flex">
                                        <label for="invite_checkbox" class="col-form-label" title="Check this box if you want the user to get an one time login link">{{ __('Invite User') }}</label>

                                        <div class="ml-2">
                                            <input type="checkbox" class="form-control" name="invite">
                                        </div>
                                    </div>
                                </div>

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
