@extends('layouts.template')

@section('main')
    <h1>Homepage</h1>
    @auth
    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)

<div class="row">
        <div class="table-responsive col-8">
            <h2>Dagplanning</h2>
            <table class="table tableplanning">
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



        <div class="table-responsive col-4 ">
            <h2>kade status</h2>
            <table class="table tablekade">
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
                    $('.tablekade tbody').empty();
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
                        $('.tablekade tbody').append(tr);
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
                    $('.tablplanning tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {

                        let tr = `<tr class="">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a href="#!" class="btn btn-outline-info btn-info"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;

                        // Append row to tbody
                        $('.tableplanning tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);

                });
        }









    </script>
@endsection
