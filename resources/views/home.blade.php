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
@include('model')

@section('script_after')
    <script>



        loadTable();
        loadTable2();
        setInterval(function(){
            loadTable();
            loadTable2();
        }, 10000);

        $('tbody').on('click', '.btn-info-home', function () {

            // Update the modal
            let id = $(this).closest('a').data('id');
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: 'home/getinfo', // This is the url we gave in the route
                data: {'id' : id, _token: '{{csrf_token()}}'}, // a JSON object to send back

                success: function(data){ // What to do if we succeed
                    console.log(data)
                    var startTijd = data.startTijd;
                    var stopTijd = data.stopTijd;
                    var bedrijf = data.bedrijfsnaam;
                    var nummerplaat = data.plaatcombinatie;
                    var kade = data.naam;
                    var kadeStatus = data.status;
                    var ladingDetails = data.ladingDetails;
                    var aantal = data.aantal;
                    var vrachtwagenstatus = ""
                    if(data.isAanwezig){
                        vrachtwagenstatus = "aanwezig";
                    }
                    else{
                        vrachtwagenstatus = "niet-aanwezig";
                    }
                    var verwerkingsstatus = ""
                    if(data.isAfgewerkt){
                        verwerkingsstatus = "afgewerkt";
                    }
                    else{
                        verwerkingsstatus = "niet-afgewerkt";
                    }


                    var proces = data.proces;
                    var voornaam = data.voornaam;

                    $('.modal-title').text('extra info');
                    $('#startTijd').text(startTijd);
                    $('#stopTijd').text(stopTijd);
                    $('#bedrijf').text(bedrijf);
                    $('#nummerplaat').text(nummerplaat);
                    $('#kade').text(kade);
                    $('#kadeStatus').text(kadeStatus);
                    $('#ladingDetails').text(ladingDetails);
                    $('#aantal').text(aantal);
                    $('#vrachtwagenstatus').text(vrachtwagenstatus);
                    $('#verwerkingsstatus').text(verwerkingsstatus);
                    $('#voornaam').text(voornaam);

                    // Show the modal
                    $('#model-home').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    if($(this).is(':checked')) {
                        $(this).prop( "checked", false );
                    }else {
                        $(this).prop( "checked", true );
                    }
                }
            })

        });

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

                    // Clear tbody tag
                    $('.tableplanning tbody').empty();

                    // Loop over each item in the array
                    $.each(data, function (key, value) {


                        let tr = `<tr class="">
                               <td class=>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;
                        if (value.isAfgewerkt == 0 && data[0].dt2 >= value.startTijd){
                            tr = `<tr class="table-danger">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;
                        }
                        if (value.isAanwezig == 0 && value.status == "Niet-vrij"){
                            tr = `<tr class="table-warning">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a data-id='${value.id}'class="btn btn-outline-info btn-info-home"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>

                                        </a>

                               </td>

                           </tr>`;
                        }
                        if (value.isAfgewerkt == 1 ){
                            tr = `<tr class="table-success">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;
                        }
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
