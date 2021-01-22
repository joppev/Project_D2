@extends('layouts.template')

@section('main')
    <h1>Alle Planningen</h1>

    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Planning aanmaken
        </a>
    </p>


    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Chauffeur</th>
                <th>Kade</th>
                <th>tijd</th>
                <th>proces</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.planning.model')
@endsection

@section('script_after')
    <script>

        $(function () {
            loadTable();





        function loadTable() {
            $.getJSON('/admin/qryPlannings')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value)

                        let tr = `<tr>
                               <td>${value.voornaam} ${value.naam} </td>
                               <td>${value.startTijd}</td>

                               <td>${value.kadenaam}</td>
                               <td data-id="${value.id}"

                                   data-naam="${value.naam}"
                                   >
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                               </td>
                           </tr>`;
                        // Append row to tbody
                        $('tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);
                })

        }});

    </script>
@endsection
