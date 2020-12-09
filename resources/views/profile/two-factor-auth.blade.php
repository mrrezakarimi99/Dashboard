@extends('profile.layout')

@section('main')

    <h5>Two Factor Auth</h5>
    <hr>
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{route('profile.twofactor')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="">type</label>
            <select name="type" id="" class="form-control">
                @foreach(config('twofactor.types') as $key => $name)
                    <option value="{{$key}}" {{old('type')==$key || auth()->user()->hasTwoFactor($key) ? 'selected' : "" }}>{{$name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phone">phone</label>
            <input type="text" name="phone" id="name" class="form-control" placeholder="please add phone number " value="{{old('phone') ?? auth()->user()->phone_number}}">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">
                update
            </button>
        </div>
    </form>

@endsection


