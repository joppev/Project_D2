@extends('layouts.template')

@section('main')
    <h1>Homepage</h1>
    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)
        <h2>Kade status</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Kade naam</th>
                    <th>Kade status</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    @endif



@endsection

@section('script_after')
    <script>
        $(function () {
            loadTable();
        });
        // Load genres with AJAX
        function loadTable() {
            $.getJSON('home/kade')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                    let tr = ''

                        console.log(value.status)
                        if (value.status === "Vrij"){
                            tr = `<tr class="table-success">
                               <td>${value.naam}</td>
                               <td>${value.status}</td>
                           </tr>`;


                        }
                        if (value.status == "Niet-vrij"){
                            tr = `<tr class="table-danger">
                               <td>${value.naam}</td>
                               <td>${value.status}</td>
                           </tr>`;


                        }
                        if (value.status === "Buiten gebruik"){
                            tr = `<tr class="table-warning">
                               <td>${value.naam}</td>
                               <td>${value.status}</td>
                           </tr>`;


                        }
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
