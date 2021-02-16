@extends('layouts.template')

@section('main')
    <div class="row justify-content-around mt-5 mb-2">

        <div class="col-sm-3 mb-2">
            <h1 class="ml-2">Kades</h1>
        </div>



            <div class="col-sm-3 mb-2">
                <input type="text" class="form-control" name="kadezoeknaam" id="kadezoeknaam"
                       value="" placeholder="Filter kades">
            </div>
            <div class="col-sm-3 mb-2">
                <select required class="form-control" name="kadezoekrol" id="kadezoekrol">
                    <option value="%">alle statussen</option>
                    <option value="Vrij">Vrij</option>
                    <option value="Niet-vrij">Niet-vrij</option>
                    <option value="Buiten gebruik">Buiten gebruik</option>

                </select>
            </div>
            <div class="col-sm-3 mb-2">
            <p>
                <a href="#!" class="btn btn-outline-success" id="btn-create">
                    <i class="fas fa-plus-circle mr-1"></i>Kade toevoegen
                </a>
            </p>
            </div>
        </div>



    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="20%">Naam</th>
                <th width="20%">Land</th>
                <th width="20%">Gemeente</th>
                <th width="20%">Status</th>
                <th width="20%">Bewerken</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    @include('admin.kade.model')
@endsection

@section('script_after')
    <script>
        $( "#kadezoekrol" ).change(function() {
            loadTable();
        });

        jQuery('#kadezoeknaam').on('input', function() {
            loadTable();
        });

        $(function () {
            loadTable();


            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('naam');


                // Set some values for Noty
                let text = `<p>Wil je <b>${naam}</b> verwijderen?</p>`;
                let type = 'warning';
                let btnText = 'Verwijder kade';
                let btnClass = 'btn-success';


                // Show Noty
                let modal = new Noty({
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {

                            deleteKade(id);
                            modal.close();
                        }),
                        Noty.button('Annuleren', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('naam');
                let gemeente = $(this).closest('td').data('gemeente');
                let adres = $(this).closest('td').data('adres');
                let land = $(this).closest('td').data('land');
                let lat = $(this).closest('td').data('lat');
                let lon = $(this).closest('td').data('lon');
                let status = $(this).closest('td').data('status');
                // Update the modal
                $('.modal-title').text(`Bewerk ${naam}`);
                $('form').attr('action', `/admin/kades/${id}`);
                $('#naam').val(naam);
                $('#gemeente').val(gemeente);
                $('#land').val(land);
                $('#adres').val(adres);
                $('#longitude').val(lon);
                $('#latitude').val(lat);
                $('#status').val(status);
                $('input[name="_method"]').val('put');

                // Show the modal
                $('#modal-kade').modal('show');
            });

            $('#btn-create').click(function () {
                // Update the modal
                $('.modal-title').text(`Nieuwe kade`);
                $('form').attr('action', `/admin/kades`);

                $('#naam').val();
                $('#gemeente').val();
                $('#land').val();
                $('#adres').val();
                $('#longitude').val();
                $('#latitude').val();
                $('#status').val();


                $('input[name="_method"]').val('post');
                // Show the modal
                $('#modal-kade').modal('show');
            });

            $('#modal-kade form').submit(function (e) {
                // Don't submit the form
                e.preventDefault();
                // Get the action property (the URL to submit)
                let action = $(this).attr('action');
                // Serialize the form and send it as a parameter with the post
                let pars = $(this).serialize();
                // Post the data to the URL
                $.post(action, pars, 'json')
                    .done(function (data) {
                        // show success message
                        Project2d.toast({
                            type: data.type,
                            text: data.text
                        });
                        // Hide the modal
                        $('#modal-kade').modal('hide');
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
        });

        function deleteKade(id) {

            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/kades/${id}`, pars, 'json')
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
            let id = '';
            if(document.getElementById('kadezoeknaam').value != null || document.getElementById('kadezoeknaam').value != ''){

                text = document.getElementById('kadezoeknaam').value;
            }

            if(document.getElementById('kadezoekrol').value != null || document.getElementById('kadezoekrol').value != ''){

                id = document.getElementById('kadezoekrol').value;
            }

            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: '/admin/qryKades', // This is the url we gave in the route
                data: {'text': text,'id':id, _token: '{{csrf_token()}}'},
                // a JSON object to send back
                success: function (data) {


                    // Clear tbody tag
                    $('tbody').empty();

                        // Loop over each item in the array
                        $.each(data, function (key, value) {
                            console.log(value);
                            var statusid = 0;
                            var bg = ""
                            if (value.status == "Vrij") {
                                statusid = 1;
                                bg ="bg-groen"
                            } else if (value.status == "Niet-vrij") {
                                statusid = 2;
                                bg ="bg-rood"
                            } else {
                                statusid = 3;
                                bg ="bg-oranje"
                            }
                            let tr = ''



                                tr = `<tr >
                               <td> ${value.kadenaam} </td>
                               <td>${value.land}</td>
                               <td>${value.gemeente}</td>
                               <td class="pl-0"><div class="kadestatus ${bg}">${value.status}</div></td>

                               <td data-id="${value.id}"
                                    data-naam="${value.kadenaam}"
                                   data-land="${value.land}"
                                   data-gemeente="${value.gemeente}"
                                   data-adres="${value.adres}"
                                   data-lat="${value.latitude}"
                                    data-lon="${value.longitude}"
                                    data-status="${statusid}">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Bewerk ${value.kadenaam}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete" data-toggle="tooltip" title="Verwijder ${value.kadenaam}">
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

    </script>
@endsection
