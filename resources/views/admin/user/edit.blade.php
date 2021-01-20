@extends('layouts.template')

@section('title', 'Edit genre')

@section('main')
    <h1>Edit genre: {{ $genre->name }}</h1>
    <form action="/admin/genres/{{ $genre->id }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   minlength="3"
                   required
                   value="{{ old('name', $genre->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Save genre</button>
    </form>
@endsection
