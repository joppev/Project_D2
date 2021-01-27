@extends('layouts.template')

@section('main')
    <div class="row justify-content-around">

        <h1>Planningen</h1>
        <p>
            <a href="#!" class="btn btn-outline-info clear" id="clear">
                <i class="fas fa-plus-circle mr-1"></i>clear filters
            </a>
        </p>
        <div class="row">
            <div class="col-sm-4 mb-2">
                <input type="text" class="form-control" name="planningzoeknaam" id="planningzoeknaam"
                       value="" placeholder="Filter planning">
            </div>

            <div class="col-sm-4 mb-2 date">

                <input type="date" id="date" name="date">
                <div class="invalid-feedback"></div>
            </div>
            <div class="col-sm-4 mb-2">
                <p>
                    <a href="#!" class="btn btn-outline-success" id="btn-create">
                        <i class="fas fa-plus-circle mr-1"></i>Planning toevoegen
                    </a>
                </p>
            </div>

        </div>

    </div>

    <div class="row">
    <div class="table-responsive col-12">
        <table class="table">
            <thead>
            <tr>
                <th>Tijdstip</th>
                <th>Bedrijf</th>
                <th>Chauffeur</th>
                <th>Proces</th>
                <th>Loskade</th>
                <th>Bewerken</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    </div>
    @include('admin.planning.model')
@endsection

@section('script_after')
    <script>



        $(function () {

            $('p').on('click', '#clear', function () {
                if(document.getElementById('planningzoeknaam').value != null || document.getElementById('planningzoeknaam').value != ''){

                    $("#planningzoeknaam").val("");
                }
                if(document.getElementById('date').value != null || document.getElementById('date').value != ''){

                    $("#date").val("");
                }
                loadTable();
            });

            jQuery('#planningzoeknaam').on('input', function() {
                loadTable();
            });
            jQuery('#date').on('input', function() {
                loadTable();
            });
            loadTable();
            loadDropdown();


            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');

                // Set some values for Noty
                let text = `<p>Wil je deze planning verwijderen?</p>`;
                let type = 'warning';
                let btnText = 'Verwijder gebruiker';
                let btnClass = 'btn-success';


                // Show Noty
                let modal = new Noty({
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {

                            deletePlanning(id);
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let aantal = $(this).closest('td').data('aantal');
                let proces = $(this).closest('td').data('proces');
                let lading = $(this).closest('td').data('lading');
                let user = $(this).closest('td').data('user');
                let kade = $(this).closest('td').data('kade');
                let status = $(this).closest('td').data('status');
                let start = $(this).closest('td').data('start');
                let stop = $(this).closest('td').data('stop');

                var datetime= '2010-10-18 10:06 AM' // Default datetime will be like this.

                var startdate =start.split(' ')[0];
                var starttime =start.split(' ')[1];
                var stopdate =stop.split(' ')[0];
                var stoptime =stop.split(' ')[1];


                // Update the modal
                $('.modal-title').text(`Edit Planning`);
                $('form').attr('action', `/admin/plannings/${id}`);

                $('#aantal').val(aantal);
                $('#proces').val(proces);
                $('#lading').val(lading);
                $('#user_id').val(user);
                $('#kade_id').val(kade);
                $('#status').val(status);
                $('#startdate').val(startdate);
                $('#starttime').val(starttime);
                $('#stopdate').val(stopdate);
                $('#stoptime').val(stoptime);


                $('input[name="_method"]').val('put');

                // Show the modal
                $('#modal-planning').modal('show');
            });

            $('#btn-create').click(function () {
                // Update the modal
                $('.modal-title').text(`Nieuwe planning`);
                $('form').attr('action', `/admin/plannings`);

                $('#aantal').val();
                $('#proces').val();
                $('#lading').val();


                $('input[name="_method"]').val('post');
                // Show the modal
                $('#modal-planning').modal('show');
            });

            $('#modal-planning form').submit(function (e) {
                // Don't submit the form
                e.preventDefault();
                // Get the action property (the URL to submit)
                let action = $(this).attr('action');
                // Serialize the form and send it as a parameter with the post
                let pars = $(this).serialize();
                // Post the data to the URL
                $.post(action, pars, 'json')
                    .done(function (data) {
                        console.log(data);
                        // show success message
                        Project2d.toast({
                            type: data.type,
                            text: data.text
                        });
                        // Hide the modal
                        $('#modal-planning').modal('hide');
                        // Rebuild the table
                        loadTable();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                        // e.responseJSON.errors contains an array of all the validation errors
                        console.log('error message', e.responseJSON.errors);
                        // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                        let msg = '<ul>';
                        $.each(e.responseJSON.errors, function (key, value) {
                            msg += `<li>${value}</li>`;
                        });
                        msg += '</ul>';
                        // show the errors
                        Project2d.toast({
                            type: 'error',
                            text: msg
                        });
                    });

            });

            function deletePlanning(id) {

                let pars = {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'delete'
                };
                $.post(`/admin/plannings/${id}`, pars, 'json')
                    .done(function (data) {

                        Project2d.toast({
                            type: data.type,    // optional because the default type is 'success'
                            text: data.text
                        });
                        // Rebuild the table
                        loadTable();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                    });
            }

            function loadTable() {
                let text = '';
                if(document.getElementById('planningzoeknaam').value != null || document.getElementById('planningzoeknaam').value != ''){

                    text = document.getElementById('planningzoeknaam').value;
                }
                let text2 = '';
                if(document.getElementById('date').value != null || document.getElementById('date').value != ''){

                    text2 = document.getElementById('date').value;
                    console.log(text2)
                }

                $.ajax({
                    method: 'GET', // Type of response and matches what we said in the route
                    url: '/admin/qryPlannings', // This is the url we gave in the route
                    data: {'text': text,'text2': text2, _token: '{{csrf_token()}}'},
                    // a JSON object to send back
                    success: function (data) {
                        console.log(data)
                        // Clear tbody tag
                        $('tbody').empty();
                        // Loop over each item in the array
                        $.each(data, function (key, value) {

            console.log(value);
                            var status = "";
                            if(value.isAanwezig){
                                status = "1"
                            } else if(value.isBezig){
                                status = "2"
                            } else if(value.isAfgewerkt){
                                status = "3"
                            } else {
                                status = "4"
                            }

                            let tr = `<tr>

                               <td>${value.startTijd} - ${value.stopTijd}</td>
                                <td>${value.bedrijfsnaam}</td>
                               <td>${value.voornaam} ${value.naam}</td>
                                <td>${value.proces}</td>
                                <td>${value.kadenaam}</td>
                               <td data-id="${value.id}"
                                    data-aantal="${value.aantal}"
                                    data-lading="${value.ladingDetails}"
                                    data-proces="${value.proces}"
                                    data-user="${value.gebruikerID}"
                                    data-kade="${value.kadeID}"
                                    data-status="${status}"
                                    data-start="${value.startTijd}"
                                    data-stop="${value.stopTijd}"
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
        });

        function loadDropdown() {
            $.getJSON('/admin/qryPlanningsUsers')
                .done(function (data) {
                    $.each(data, function (key, value) {
                        $('#user_id').append('<option value="' + value.id + '">' + value.voornaam + ' ' + value.naam + '</option>');
                    })
                });

            $.getJSON('/admin/qryPlanningsKades')
                .done(function (data) {
                    $.each(data, function (key, value) {
                        $('#kade_id').append('<option value="' + value.id + '">' + value.kadenaam + '</option>');
                    })
                });

        }




    </script>

@endsection
