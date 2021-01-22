@extends('layouts.template')

@section('main')
    <h1>Homepage</h1>
    <br>
    <hr>
    @auth
    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)

<div class="row">
        <div class="table-responsive col-lg-9 col-12">
            <h2>Dagplanning</h2>
            <table class="table tableplanning">
                <thead>
                <tr>
                    <th>Tijdstip</th>
                    <th>Bedrijf</th>
                    <th>Chauffeur</th>
                    <th>Nummerplaat</th>
                    <th>Loscade</th>
                    <th>Opmerkingen</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>



        <div class="table-responsive col-lg-3 col-12">
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
<div class="flex-container">
    <div id="QV01" class="card-img-bottom qvplaceholder"></div>
</div>
@include('model')
    @endif
    @if(auth()->user()->isChauffeur)
        <h1>Dagplanning</h1>
        <hr>
        <div class="row">
            <label class="col-4" for="startTijd">Tijdstip: </label>
            <p id="startTijd" name="startTijd" class="col-4"></p>
        </div>
        <div class="row">
            <label class="col-4" for="stopTijd"></label>
            <p id="stopTijd" name="stopTijd" class="col-4"></p>
        </div>
            <div class="row">
                <label class="col-4" for="bedrijf">Bedrijf: </label>
                <p id="bedrijf" name="bedrijf" class="col-4"></p>
                <label class="col-4"></label>

            </div>
        <div class="row">
            <label class="col-4" for="nummerplaat">Nummerplaat: </label>
            <p id="nummerplaat" name="nummerplaat" class="col-4"></p>
            <label class="col-4"></label>

        </div>
        <div class="row">
            <label class="col-4" for="ladingDetails">Lading details: </label>
            <p id="ladingDetails" name="ladingDetails" class="col-4"></p>
            <label class="col-4"></label>

        </div>
        <div class="row">
            <label class="col-4" for="aantal">Aantal: </label>
            <p id="aantal" name="aantal" class="col-4"></p>
            <label class="col-4"></label>

        </div>
        <div class="row">
            <label class="col-4" for="proces">proces: </label>
            <p id="proces" name="proces" class="col-4"></p>
            <label class="col-4"></label>

        </div>
        <div class="row">
            <label class="col-4" for="kade">Kade: </label>
            <p id="kade" name="kade" class="col-4"></p>
            <label class="col-4"></label>
        </div>
        <div class="row">
            <label class="col-2"></label>
            <label class="col-2" for="kadeStatus">Kade status: </label>
            <p id="kadeStatus" name="kadeStatus" class="col-4"></p>
            <label class="col-2"></label>
        </div>
        <div class="row">
            <label class="col-4" for="adres">Adres: </label>
            <p id="adres" name="adres" class="col-4"></p>
            <label class="col-4"></label>

        </div>
        <div class="row">
            <label class="col-4" for="verwerkingsstatus">Verwerkingsstatus: </label>
            <p id="verwerkingsstatus" name="verwerkingsstatus" class="col-4"></p>
            <label class="col-4"></label>

        </div>


    @endif
    @endauth

@endsection


@section('script_after')
    <script>


        loadChauffeur()
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
                    var title = "extra info chauffeur: " + voornaam + ", bedrijf: " + bedrijf
                    $('.modal-title').text(title);
                    $('#startTijd').text(startTijd);
                    $('#stopTijd').text(stopTijd);
                    $('#bedrijf').text(bedrijf);
                    $('#nummerplaat').text(nummerplaat);
                    $('#kade').text(kade);
                    $('#kadeStatus').text(kadeStatus);
                    if (kadeStatus == 'Niet-vrij' && data.isBezig == 0){
                        $('#kadeStatus').addClass('table-warning');
                        $('#kadeStatus').removeClass('table-danger');
                        $('#kadeStatus').removeClass('table-success');
                    }
                    if (kadeStatus == 'Buiten gebruik'){
                        $('#kadeStatus').addClass('table-danger');
                        $('#kadeStatus').removeClass('table-warning');
                        $('#kadeStatus').removeClass('table-success');
                    }
                    if (kadeStatus == 'Vrij'){
                        $('#kadeStatus').addClass('table-success');
                        $('#kadeStatus').removeClass('table-danger');
                        $('#kadeStatus').removeClass('table-warning');
                    }

                    $('#ladingDetails').text(ladingDetails);
                    $('#status').text(status);
                    $('#aantal').text(aantal);
                    $('#voornaam').text(voornaam);
                    $('#vrachtwagenstatus').text(vrachtwagenstatus);
                    if ( data.isAanwezig== 0){
                        $('#vrachtwagenstatus').addClass('table-warning');
                        $('#vrachtwagenstatus').removeClass('table-success');
                    }

                    if (data.isAanwezig == 1){
                        $('#vrachtwagenstatus').addClass('table-success');
                        $('#vrachtwagenstatus').removeClass('table-warning');
                    }
                    $('#verwerkingsstatus').text(verwerkingsstatus);
                    if (data.isAfgewerkt== 0){
                        $('#verwerkingsstatus').addClass('table-warning');
                        $('#verwerkingsstatus').removeClass('table-success');
                    }

                    if (data.isAfgewerkt == 1){
                        $('#verwerkingsstatus').addClass('table-success');
                        $('#verwerkingsstatus').removeClass('table-warning');
                    }

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

        function loadChauffeur() {
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: 'home/getPlanningChauffeur', // This is the url we gave in the route
                // a JSON object to send back
                success: function (data) {
                        console.log(data);
                    var startTijd = data.startTijd;
                    var stopTijd = data.stopTijd;
                    var bedrijf = data.bedrijfsnaam;
                    var nummerplaat = data.plaatcombinatie;
                    var kade = data.naam;
                    var kadeStatus = data.status;
                    var ladingDetails = data.ladingDetails;
                    var aantal = data.aantal;
                    var status = data.status;
                    var voornaam = data.voornaam;
                    var proces = data.proces;
                    var adres = data.land + " - " + data.gemeente + " - " + data.adres
                    var verwerkingsstatus = '';
                    if(data.isAfgewerkt){
                        verwerkingsstatus = "afgewerkt";
                    }
                    else{
                        verwerkingsstatus = "niet-afgewerkt";
                    }

                    $('#startTijd').text(startTijd);
                    $('#stopTijd').text(stopTijd);
                    $('#bedrijf').text(bedrijf);
                    $('#nummerplaat').text(nummerplaat);
                    $('#kade').text(kade);
                    $('#kadeStatus').text(kadeStatus);
                    if (kadeStatus == 'Niet-vrij' && data.isBezig == 0){
                        $('#kadeStatus').addClass('table-warning');
                        $('#kadeStatus').removeClass('table-danger');
                        $('#kadeStatus').removeClass('table-success');
                    }
                    if (kadeStatus == 'Buiten gebruik'){
                        $('#kadeStatus').addClass('table-danger');
                        $('#kadeStatus').removeClass('table-warning');
                        $('#kadeStatus').removeClass('table-success');
                    }
                    if (kadeStatus == 'Vrij'){
                        $('#kadeStatus').addClass('table-success');
                        $('#kadeStatus').removeClass('table-danger');
                        $('#kadeStatus').removeClass('table-warning');
                    }
                    $('#ladingDetails').text(ladingDetails);
                    $('#status').text(status);
                    $('#aantal').text(aantal);
                    $('#voornaam').text(voornaam);
                    $('#proces').text(proces);
                    $('#adres').text(adres);
                    $('#verwerkingsstatus').text(verwerkingsstatus);
                    if (data.isAfgewerkt == 0){
                        $('#verwerkingsstatus').addClass('table-warning');
                        $('#verwerkingsstatus').removeClass('table-success');
                    }

                    if (data.isAfgewerkt == 1){
                        $('#verwerkingsstatus').addClass('table-success');
                        $('#verwerkingsstatus').removeClass('table-warning');
                    }






                },
                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    if ($(this).is(':checked')) {
                        $(this).prop("checked", false);
                    } else {
                        $(this).prop("checked", true);
                    }
                }
            });
        }

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
<td>${value.voornaam}</td>
                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home info"
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
<td>${value.voornaam}</td>
                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td>te laat</td>
                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home info"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;
                        }
                        if (value.isAanwezig == 1 && value.status == "Niet-vrij" && value.isBezig == 0){
                            tr = `<tr class="table-warning">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>
<td>${value.voornaam}</td>
                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td>Vorige planning nog niet afgewerkt</td>

                               <td><a data-id='${value.id}'class="btn btn-outline-info btn-info-home info"
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
<td>${value.voornaam}</td>
                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td>afgewerkt</td>

                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home info"
                                        data-toggle="tooltip"
                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                               </td>

                           </tr>`;
                        }
                        if (value.isAanwezig == 1 && value.isBezig == 1){
                            tr = `<tr class="table-info">
                               <td>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>
<td>${value.voornaam}</td>
                               <td>

                                ${value.plaatcombinatie}

                               </td>
                               <td>${value.naam}</td>
                               <td>Bezig</td>

                               <td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home info"
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
