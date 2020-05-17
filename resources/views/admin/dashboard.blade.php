@extends('layouts.app')

@section('content')

    <div class="w-100">
        <div class="col-lg-10 col-md-12 offset-lg-1 ">
            <h2 class="text-center bg-secondary text-white">Dashboard</h2>
            <div class="col-md-12 offset-md-0 mt-4 text-center">
                <h4>Actions</h4>
                <div class="d-flex flex-column flex-sm-row justify-content-around">
                    @if (Route::has('register'))
                        <a class="btn btn-primary my-sm-0 my-1" href="{{ route('register') }}" title="Register a new user">Register User</a>
                    @endif
                    <a class="btn btn-primary my-sm-0 my-1" href="{{ route('admin.accommodations.create') }}" title="If you have more than one accommodation, you can register it here">Register Accommodation</a>
                    <a class="btn btn-primary my-sm-0 my-1" href="{{ route('guests.export') }}" title="If you need to hand out the guest list to the authorities, use this export, but be aware to keep the GDPR regulations intact when handing the exported document out.">Export Guests</a>
                </div>

                <div class="w-100 mt-3 ">
                    <form action="{{ route('admin.dashboard') }}" method="GET">
                        <div class="d-flex flex-nowrap">
                            <input id="search" class="form-control text-center" type="text" name="search" value="{{ old('search') }}" placeholder="Full Text Search" title="This field searches all Users and Accommodations for your keyword you are entering!">
                            <button id="clear_search" type="button" class="btn">&#10539;</button>
                            <button id="reset_search" type="button" class="btn btn-outline-secondary btn-sm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr>

            <h4 class="mb-3 mt-5 text-center text-md-left">User Overview</h4>
            <table class="table table-striped  table-sm  table_card">
                <thead class="table-info">
                <tr>
                    <th>id</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Role</th>
                    <th>Accomm.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if (count($users) > 0)
                    @foreach($users as $user)
                        <tr>
                            <td data-label="User Id">{{ $user->id }}</td>
                            <td data-label="User Name">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" class="input_change" name="user_name" value="{{ $user->name }}" required>
                                </form>
                            </td>
                            <td data-label="User Email">
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="email" class="input_change" name="user_email" value="{{ $user->email }}" required>
                                </form>
                            </td>
                            <td data-label="User Role">
                                <form action="{{ route('admin.users.assignRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="role_id_select" name="role">
                                        <option value="Admin" {{ $user->role->name === 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Guest" {{ $user->role->name === 'Guest' ? 'selected' : '' }}>Guest</option>
                                    </select>
                                </form>
                            </td>
                            @if ($user->role->name === 'Guest')
                                <td data-label="Accommodation" id="select_minifier">
                                    <form action="{{ route('admin.users.assignAccommodation', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <select class="accommodation_id_select" name="accommodation_id" title="Please choose an accommodation a guest is allowed to book!">
                                            @foreach($accommodations as $accommodation)
                                                <option value="{{ $accommodation->id }}" {{ $accommodation->id === $user->accommodation_id ? 'selected' : '' }}>{{ $accommodation->name }}</option>
                                            @endforeach
                                            @if (!$user->accommodation)
                                                <option selected disabled>Please choose</option>
                                            @endif
                                        </select>
                                    </form>
                                </td>
                            @else
                                <td data-label="Accommodation"><span class="ml-4">n.a.</span></td>
                            @endif
                            <td class="d-flex">
                                @if($user->role->name === 'Guest')
                                    <form action="{{ action('Auth\RegisterController@invite', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-warning mr-2" title="Send an Email to the user email address with a login token!">Reinvite</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No Users found!</td>
                    </tr>
                @endif
                </tbody>
            </table>

            <h4>Accommodation Overview</h4>
            <table class="table table-striped table-sm  table-responsive-lg">
                <thead class="table-info">
                <tr>
                    <th class="w-auto">id</th>
                    <th class="col-9">Name</th>
                    <th class="col-1">Capacity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if (count($accommodations) > 0)
                @foreach($accommodations as $accommodation)
                    <tr>
                        <td class="w-auto">{{ $accommodation->id }}</td>
                        <td class="col-9 w-100">
                            <form action="{{ route('admin.accommodations.update', $accommodation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" class="w-100 input_change" name="name" value="{{ $accommodation->name }}" required>
                            </form>
                        </td>
                        <td class="col-1 ">
                            <form action="{{ route('admin.accommodations.update', $accommodation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" class="w-100 input_change_capacity" name="capacity" value="{{ $accommodation->capacity }}" required>
                            </form>
                        </td>
                        <td class="col-auto offset-1">
                            <form action="{{ route('admin.accommodations.destroy', $accommodation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" value="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No Accommodations found!</td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div>

@endsection
