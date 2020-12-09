@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a href="{{route('profile.index')}}" class="nav-link {{request()->is('profile') ? 'active' : ''}}"> index </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('profile.twofactor')}}" class="nav-link {{request()->is('profile/twofactor') ? 'active' : ''}}"> TwoFactorAuth</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                       @yield('main')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
