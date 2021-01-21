@extends('layouts.template')

@section('main')
    <h1>Homepage</h1>
    @auth
    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)

        <h2>Dagplanning</h2>
        <div class="table-responsive">
            <table class="table1">
                <thead>
                <tr>
                    <th>Tijdstip</th>
                    <th>Bedrijf</th>
                    <th>Nummerplaat</th>
                    <th>loscade</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


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
    @endauth

@endsection

@section('script_after')
    <script>
        $(function () {
            loadTable();
            loadTable2();
        });
        // Load genres with AJAX
        function loadTable() {
            $.getJSON('home/kade')
                .done(function (data) {
                    // Clear tbody tag
                    $('.table tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                    let tr = ''

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
                        $('.table tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);
                })


        }
        function loadTable2() {
            $.getJSON('home/dagplanning')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('.table1 tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {

                        let tr = `<tr class="table-success">
                               <td>${value.startTijd} - {value.stopTijd}</td>
                               <td>${value.bedrijf}</td>
                               <td>${value.nummerplaar}</td>
                               <td>${value.loskadeID}</td>
                           </tr>`;

                        // Append row to tbody
                        $('.table1 tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);

                });
        }









    </script>
@endsection
