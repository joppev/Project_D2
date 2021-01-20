@extends('layouts.template')

@section('main')
    <h1>Alle gebruikers</h1>


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
@endsection

@section('script_after')
    <script>

        $(function () {
            loadTable();
            console.log('hallo')
        });

        // Load genres with AJAX
        function loadTable() {
            $.getJSON('/admin/qryUsers')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value)
                        var rol = "";
                        if(value.isAdmin == true){
                            rol = "Admin"
                        } else if(value.isChauffeur){
                            rol = "Chauffeur"
                        } else if(value.isReceptionist){
                            rol = "Receptionist"
                        } else if(value.isLogistiek){
                            rol = "Logistiek"
                        }
                        let tr = `<tr>
                               <td>${value.naam}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>${rol}</td>
                               <td data-id="${value.id}"
                                   data-records="${value.records_count}"
                                   data-name="${value.naam}">
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
        }
    </script>
@endsection
