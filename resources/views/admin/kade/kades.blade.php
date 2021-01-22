@extends('layouts.template')

@section('main')
    <h1>Alle Kades</h1>

    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Kade aanmaken
        </a>
    </p>


    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Bedrijf</th>
                <th>Rol</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.kade.model')
@endsection
