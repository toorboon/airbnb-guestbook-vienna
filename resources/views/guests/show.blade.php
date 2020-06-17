@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">{{$guest->first_name}} {{$guest->last_name}}</h3>
                        <h4 class="text-center">Arrival: {{ \Carbon\Carbon::parse($guest->arrival_date)->format('d.m.Y') }}</h4>
                        <h6 class="text-center">Booked for accommodation: @if($guest->accommodation) {{ $guest->accommodation->name }} @endif </h6>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{route('guests.index')}}" class="btn btn-sm btn-secondary">Go Back</a>
                            <div class="d-flex">
                                <a href='{{route('guests.edit',$guest->id)}}' class="btn btn-sm btn-success mr-2">Edit</a>
                                <form action="{{ action('GuestController@destroy', $guest->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-sm btn-danger" type="submit" value="Delete">
                                </form>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Column</th>
                                    <th>Value</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ucwords($guest->gender)}}</td>
                                </tr>
                                <tr>
                                    <td>Birth Date</td>
                                    <td>{{\Carbon\Carbon::parse($guest->birth_date)->format('d.m.Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Citizenship</td>
                                    <td>{!! $guest->flag !!} {{ucwords($guest->citizenship)}}</td>
                                </tr>
                                <tr>
                                    <td>{{$guest->document_type}}</td>
                                    <td>{{ucwords($guest->document)}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ucwords($guest->address)}}</td>
                                </tr>
                                @foreach($fellows as $fellow)
                                    <tr >
                                        <td class="pl-4">{{$loop->iteration}}. Family Member</td>
                                        <td>{{$fellow->first_name}} {{$fellow->last_name}} born on {{\Carbon\Carbon::parse($fellow->birth_date)->format('d. M Y')}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Arrival Date</td>
                                    <td>{{\Carbon\Carbon::parse($guest->arrival_date)->format('d.m.Y H:i')}}</td>
                                </tr>
                                <tr>
                                    <td>Estimated Departure Date</td>
                                    <td>{{\Carbon\Carbon::parse($guest->est_departure_date)->format('d.m.Y H:i')}}</td>
                                </tr>
                                <tr>
                                    <td>Actual Departure Date</td>
                                    <td>{{$guest->act_departure_date != NULL ? \Carbon\Carbon::parse($guest->act_departure_date)->format('d.m.Y H:i') : 'No checkout yet!'}}</td>
                                </tr>
                                <tr>
                                    <td>Signature</td>
                                    <td><img class="img-fluid" src="{{$guest->signature}}" ></td>
                                </tr>
                                <tr>
                                    <td>Notes</td>
                                    <td>{{ucfirst($guest->notes)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-muted text-center">
                        <small class="text-muted">created {{$guest->created_at}}</small>
                        <small class="text-muted d-block">by {{$guest->user->name}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
