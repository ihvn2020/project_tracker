@extends('template2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col m8 offset-m2">
            
                <div class="card-header">Update User</div>

                
                    <form method="POST" action="{{ route('updateUser') }}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="input-field">
                            
                            
                                <input id="name" type="text" class="validate @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        </div>

                        <div class="input-field">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="input-field">
                                <input id="phone_number" type="text" class="validate" name="phone_number" value="{{$user->phone_number}}">                               
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                        </div>

                        <div class="input-field">
                            <select name="state" id="state" materialize="material_select">
                                <option value="{{$user->state}}" selected>{{$user->state}}</option>
                                @php
                                 $states = \App\tracker::select('state')->distinct()->get();
                                @endphp
                                @foreach ($states as $state)                                            
                                <option value="{{$state->state}}">{{$state->state}}</option>
                                @endforeach
                            </select>
                            <label for="state">Select State</label>
                        </div>

                        <div class="input-field">
                            <select name="lga" id="lga" materialize="material_select">
                                <option value="{{$user->lga}}" selected>{{$user->lga}}</option>

                                @php
                                $lgas = \App\tracker::select('lga')->distinct()->get();
                               @endphp
                                @foreach ($lgas as $lga)                                            
                                <option value="{{$lga->lga}}">{{$lga->lga}}</option>
                                @endforeach
                            </select>
                            <label for="lga">Select LGA</label>
                        </div>

                        <div class="input-field">
                            <select name="health_facility" id="health_facility" materialize="material_select">
                                <option value="{{$user->health_facility}}" selected>{{$user->health_facility}}</option>
                                @php
                                $health_facilities = \App\tracker::select('health_facility')->distinct()->get();
                               @endphp

                                @foreach ($health_facilities as $health_facility)                                            
                                <option value="{{$health_facility->health_facility}}">{{$health_facility->health_facility}}</option>
                                @endforeach
                            </select>
                            <label for="health_facility">Select Health Facility</label>
                        </div>


                        <div class="input-field">
                            <select name="role" id="role">
                                <option value="{{$user->role}}" selected>{{$user->role}}</option>
                                <option value="Admin">System Admin</option>
                                <option value="State Manager">State Manager</option>
                                <option value="Facility Manager" selected>Facility Manager</option>
                            </select>
                            <label for="role">Select Role</label>
                        </div>

                      
                        <div class="input-field" style="text-align:right; margin-bottom: 20px;">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>
                
            
        </div>
    </div>
</div>
@endsection
