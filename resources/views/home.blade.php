@extends('layouts.template')

@section('main')

    @auth
    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)
        <div class="row mt-5">
        <div class="table-responsive col-lg-9 col-12">

            <h2>Dagplanning</h2>
            <div class="row">
                <h2 id="info" name="info" class="col-12"></h2>
            </div>
                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <input type="text" class="form-control" name="planningzoeknaam" id="planningzoeknaam"
                               value="" placeholder="Filter planning">
                    </div>


                </div>
            <table class="table tableplanning">
                <thead>
                <tr>
                    <th>Tijdstip</th>
                    <th>Bedrijf</th>
                    <th>Chauffeur</th>
                    <th>Proces</th>
                    <th>Loskade</th>
                    <th>Opmerkingen</th>
                    <th>Nummerplaat</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>



        <div class=" col-lg-3 col-12">
            <h2>Kadestatus</h2>
                <div class="row">

                    <div class="col-sm-12 mb-2">
                        <input type="text" class="form-control" name="kadezoeknaam" id="kadezoeknaam"
                               value="" placeholder="Filter kades">
                    </div>


                </div>
            <table class="table tablekade" id="tablekade">
                <thead>
                <tr>
                    <th>Kadenaam</th>
                    <th>Kadestatus</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        </div>
            <div class="row">
                <div class="col-3 offset-9">
                    <div class="flex-container ">
                        <div id="QV01" class="qvobject qvplaceholder"></div>
                    </div>
                </div>

            </div>


        @include('modelNummerplaat')
        @include('model')
    @endif
    @if(auth()->user()->isChauffeur)
        <h1>Dagplanning</h1>
        <hr>

        <div class="row">
            <div class="col-12">
                <div class="card mb-3">

                    <div id="QV02" class="qvobject2 qvplaceholder2"></div>
                    <div  class="card-body">

                    </div>
                </div>
            </div>

        </div>






    @endif

    @if(auth()->user()->isLogistiek)
    <div id="logistiekKleur" >
        <br>
        <div class="row">
        <form class="col-4" method="get" action="/kadeID" id="searchForm">

        <select class="form-control" name="kade_id" id="kade_id">
            <option value="%" data-id="%" >Alle kades</option>
            @foreach($kades as $kade)
                <option value="{{ $kade->id }}"
                    {{ (request()->kade_id ==  $kade->id ? 'selected' : '') }} data-id="{{ $kade->id }}" class="{{ (request()->kade_id ==  $kade->id ? 'selected' : '') }} select-color">{{ $kade->kadenaam }}</option>
            @endforeach
        </select>
        </form>
        </div>
        <br>

        <div class="row">
            <div class="col-12">
                <div class="card mb-3">

                    <div class="card-body logistiek">
                        <h3>Kies een kade!</h3>
                    </div>
                </div>
            </div>

        </div>



    @endif

    @endauth
@endsection



@section('script_after')

    <script>



@auth
        @if(auth()->user()->isChauffeur){
            loadChauffeur2();
        }
            @endif
        @if(auth()->user()->isAdmin or auth()->user()->isReceptionist){


                jQuery('#planningzoeknaam').on('input', function() {
                    loadTable2();
                });
                jQuery('#kadezoeknaam').on('input', function() {
                    loadTable();
                });


                loadTable();
            loadTable2();
        }
        @endif
        @if(auth()->user()->isLogistiek){

            $('#kade_id').change(function () {
                $('#searchForm').submit();
                loadLogistiek2()

            });

            loadLogistiek2()
        }

        @endif


            @if(auth()->user()->isChauffeur)
            setInterval(function(){
                loadChauffeur2();
            }, 10000);

            @endif
                @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)
               setInterval(function(){
                loadTable();
                loadTable2();
            }, 10000);

            @endif
            @if(auth()->user()->isLogistiek)
                setInterval(function(){
                loadLogistiek2()
            }, 10000);

        @endif

@endauth
$('p').on('click', '#btn-begin', function () {


    let id2 = $(`div#logistiekKleur`).data('id');
    let id = $(`option.selected`).data('id');
    if(id2 != 'geenProcess') {
        $.ajax({
            method: 'GET', // Type of response and matches what we said in the route
            url: 'home/begin', // This is the url we gave in the route
            data: {'id': id2, 'idKade': id, _token: '{{csrf_token()}}'}, // a JSON object to send back

            success: function (data) { // What to do if we succeed
                new Noty({
                    type: data.type,
                    text: data.text,
                    layout: 'topRight',
                    timeout: 3000,
                }).show();
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
        loadLogistiek2;
    }
});
$('p').on('click', '#btn-afgewerkt', function () {

    let id2 = $(`div#logistiekKleur`).data('id');
    let id = $(`option.selected`).data('id');
    if(id2 != 'geenProcess') {
        $.ajax({
            method: 'GET', // Type of response and matches what we said in the route
            url: 'home/afgewerkt', // This is the url we gave in the route
            data: {'id': id2, 'idKade': id, _token: '{{csrf_token()}}'}, // a JSON object to send back

            success: function (data) { // What to do if we succeed
                new Noty({
                    type: data.type,
                    text: data.text,
                    layout: 'topRight',
                    timeout: 3000,
                }).show();
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
    loadLogistiek2();

});
        $('tbody').on('click', '.btn-info-nummerplaten', function () {

            // Update the modal
            let id = $(this).closest('a').data('id');
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: 'home/getnummerplaten', // This is the url we gave in the route
                data: {'id': id, _token: '{{csrf_token()}}'}, // a JSON object to send back

                success: function (data) { // What to do if we succeed
                    var nummerplaten = '';
                    $.each(data, function (key, value) {
                        if(key == 0){
                            nummerplaten += (value.plaatcombinatie);
                        }else
                        {
                            nummerplaten += ("/" + value.plaatcombinatie);
                        }

                    });
                    $('.modal-title').text('nummerplaten');
                    $('#nummerplaat').text(nummerplaten);
                    $('#model-home-nummerplaten').modal('show');
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
        });
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
                    var kade = data.kadenaam;
                    var kadeStatus = data.status;
                    var ladingDetails = data.ladingDetails;
                    var aantal = data.aantal;
                    var vrachtwagenstatus = ""
                    if(data.isAanwezig){
                        vrachtwagenstatus = "Aanwezig";
                    }
                    else{
                        vrachtwagenstatus = "Niet-aanwezig";
                    }
                    var verwerkingsstatus = ""
                    if(data.isAfgewerkt){
                        verwerkingsstatus = "Afgewerkt";
                    }
                    else{
                        verwerkingsstatus = "Niet-afgewerkt";
                    }


                    var proces = data.soortNaam;
                    var voornaam = data.voornaam;
                    var title = "Extra info chauffeur: " + voornaam + " " + data.naam + ", bedrijf: " + bedrijf
                    $('.modal-title').text(title);
                    $('#startTijd').text(startTijd);
                    $('#stopTijd').text(stopTijd);
                    $('#bedrijf').text(bedrijf);
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
                    $('#voornaam').text(voornaam + " " + data.naam);
                    $('#proces').text(proces);



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



function loadChauffeur2() {
    $.getJSON('/home/getPlanningChauffeur')
        .done(function (data) {
            console.log('data', data);
            // Clear tbody tag
            $('.card-body').empty();
            // Loop over each item in the array
            var bg2 = ""
            if (data.isAfgewerkt) {
                verwerkingsstatus = "afgewerkt";
                bg2 ="bg-groen"
            } else {
                verwerkingsstatus = "niet-afgewerkt";
                bg2 ="bg-oranje"
            }
            var bg = ""
            if (data.status == "Vrij") {

                bg ="bg-groen"
            } else if (data.status == "Niet-vrij") {

                bg ="bg-rood"
            } else {

                bg ="bg-oranje"
            }



                let tr = `
                           <div class="row">
                            <div class="col-6 col-md-10">
                            <h3 class="card-title">Proces: ${data.soortNaam} </h3>
                            </div>
                              <div class="col-6 col-md-2">
                            <div class="kadestatus float-right float-md-left mr-2 ${bg2} ">${verwerkingsstatus} </div>
                            </div>
                            <div class="col-12 col-md-12 mt-2">
                                <div>
                                    <p class="card-title  ">${data.startTijd} - ${data.stopTijd}</p>
                                </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p >Adres: ${data.adres} - ${data.gemeente} - ${data.land}</p>
                                <p >Product: ${data.aantal} ${data.ladingDetails}</p>
                                <p >Kade: ${data.kadenaam}</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                <div class="planningstatus ${bg}">${data.status}</div>
                                </div>
                            </div>
                           </div>


                      `;
                // Append row to tbody
                $('.card-body').append(tr);

        })
        .fail(function (e) {
            console.log('error', e);
        })
}





        function loadTable() {
            let text = '';
            if(document.getElementById('kadezoeknaam').value != null || document.getElementById('kadezoeknaam').value != ''){

                text = document.getElementById('kadezoeknaam').value;
            }


            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: 'home/kade', // This is the url we gave in the route
                data: {'text':text, _token: '{{csrf_token()}}'},
                // a JSON object to send back
                success: function (data) {
                    // Clear tbody tag
                    $('.tablekade tbody').empty();
                        // Loop over each item in the array
                        $.each(data, function (key, value) {

                            if (value.status === "Vrij") {
                                bg ="table-success";



                            }
                            if (value.status == "Niet-vrij") {
                                bg ="table-danger";



                            }
                            if (value.status === "Buiten gebruik") {
                                bg ="table-warning";

                            }
                            var tr = `<tr class="${bg}">
                               <td>${value.kadenaam}</td>
                               <td>${value.status}</td>
                           </tr>`;
                            // Append row to tbody
                            $('.tablekade tbody').append(tr);
                        });
                    }

                ,
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
        function loadTable2() {
            let text = '';
            if(document.getElementById('planningzoeknaam').value != null || document.getElementById('planningzoeknaam').value != ''){

                text = document.getElementById('planningzoeknaam').value;
            }


            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: 'home/dagplanning', // This is the url we gave in the route
                data: {'text': text, _token: '{{csrf_token()}}'},
                // a JSON object to send back
                success: function (data) {

                    // Clear tbody tag
                    $('.tableplanning tbody').empty();

                    // Loop over each item in the array
                    $.each(data, function (key, value) {



                        if (data[0].dt2 > value.startTijd && value.isAanwezig == 0) {
                            bg ="table-danger";
                            info = "te laat"
                        }
                        if (value.isAanwezig == 1 && value.status == "Niet-vrij" && value.isBezig == 0) {
                            bg ="table-warning";
                            info = "Vorige planning nog niet afgewerkt"
                        }
                        if (value.isAfgewerkt == 1) {
                            bg = "table-success";
                            info = "afgewerkt"
                        }
                        if (value.isAanwezig == 1 && value.isBezig == 1) {
                            bg = "table-info";
                            info = "bezig"
                        }
                        if (value.isAanwezig == 1 && value.isBezig == 0) {
                            bg = "table-info";
                            info = "aanwezig"
                        }
                        if(info == ''){
                            info = 'geen info';
                        }
                        let tr = `<tr class="${bg}">
                               <td class=>${value.startTijd} - ${value.stopTijd}</td>
                               <td>${value.bedrijfsnaam}</td>
<td>${value.voornaam} ${value.naam}</td>
                               <td>

                                ${value.soortNaam}

                               </td>
                               <td>${value.kadenaam}</td>
<td>${info}</td>
                               <td>
                                    <a data-id='${value.bedrijfsID}' class="btn btn-outline-info btn-info-nummerplaten info"

                                        title="nummerplaten">
                                            <i class="fas fa-list-ul"></i>
                                        </a>

                               </td>
<td><a data-id='${value.id}' class="btn btn-outline-info btn-info-home info"

                                        title="info">
                                            <i class="fas fa-info-circle"></i>
                                        </a></td>

                           </tr>`;
                        bg = '';
                        info = '';


                        // Append row to tbody
                        $('.tableplanning tbody').append(tr);

                    });

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


function loadLogistiek2() {
    let id = $(`option.selected`).data('id');

    if(id != null){
        $.ajax({
            method: 'GET', // Type of response and matches what we said in the route
            url: 'home/getPlanninglogistiek', // This is the url we gave in the route
            data: {'id' : id, _token: '{{csrf_token()}}'}, // a JSON object to send back

            // a JSON object to send back
            success: function (data) {
            console.log('data', data);
            // Clear tbody tag
            $('div.logistiek').empty();
            // Loop over each item in the array

                let tr2 = `
                           <div class="row">
                            <div class="col-12">
                            <h3 class="card-title">Geen planning gepland in de nabije toekomst voor deze kade.</h3>
                            </div>
                        </div>

                      `;

            let tr = `
                           <div class="row">
                            <div class="col-12">
                            <h3 class="card-title"> ${data.startTijd} - ${data.stopTijd}  </h3>
                            </div>

                            <div class="col-12 ">
                            <h5 class="card-title mt-2">Chauffeur: ${data.voornaam} ${data.naam} </h5>
                            </div>
                            <div class="col-12 mt-1 ">
                                <h5>Proces: ${data.soortNaam} </h5>
                            </div>
                              <div class="col-12 mt-1 mb-2">
                                <h5>Goederen: ${data.aantal} ${data.ladingDetails}</h5>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="#!" class="btn btn-outline-success" id="btn-begin">
                                        <i class="fas fa-play"></i> Begin proces
                                    </a>

                                        <a href="#!" class="btn float-right mr-5 btn-outline-danger" id="btn-afgewerkt">
                                         <i class="fas fa-stop"></i> Proces afgewerkt
                                        </a>
                                </div>
                            </div>
                           </div>


                      `;
            // Append row to tbody
                if(data.startTijd == null){
                    $('.logistiek').append(tr2);
                } else{
                    $('.logistiek').append(tr);
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
}}


    </script>
@endsection
