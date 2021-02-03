@extends('layouts.template')


@section('main')
    <h1 class="mt-5">Nieuw wachtwoord</h1>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>{!! session()->get('success') !!}</p>
        </div>
    @endif
    @if (session()->has('danger'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>{!! session()->get('danger') !!}</p>
        </div>
    @endif

    <form action="/user/password" method="post">
        @csrf
        <div class="form-group ">
            <label for="current_password">Huidig wachtwoord</label>
            <input type="password" name="current_password" id="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   placeholder="Huidig wachtwoord"
                   value="{{ old('current_password') }}"
                   required>
            @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Nieuw wachtwoord</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Nieuw wachtwoord"
                   value="{{ old('password') }}"
                   minlength="8"
                   required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Herhaal nieuw wachtwoord</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control"
                   placeholder="Herhaal nieuw wachtwoord"
                   value="{{ old('password_confirmation') }}"
                   minlength="8"
                   required>
        </div>
        <button type="submit" class="btn btn-success">Wachtwoord aanpassen</button>
    </form>
@endsection
