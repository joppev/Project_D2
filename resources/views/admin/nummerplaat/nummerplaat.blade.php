@extends('layouts.template')

@section('main')
    <div class="row justify-content-around mt-5 mb-2">

        <div class="col-sm-6 mb-2">
            <h1 class="ml-2">Nummerplaten</h1>
        </div>





            <div class="col-sm-3 mb-2">
                <input type="text" class="form-control" name="nummerplaatzoeknaam" id="nummerplaatzoeknaam"
                       value="" placeholder="Filter nummerplaten">
            </div>
            <div class="col-sm-3 mb-2">
                <p>
                    <a href="#!" class="btn btn-outline-success" id="btn-create">
                        <i class="fas fa-plus-circle mr-1"></i>Nummerplaat toevoegen
                    </a>
                </p>
            </div>
        </div>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="25%">Nummerplaat</th>
                <th width="25%">Land</th>
                <th width="25%">Bedrijf</th>
                <th width="25%">Bewerken</th>

            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.nummerplaat.model')
@endsection

@section('script_after')
    <script>
        jQuery('#nummerplaatzoeknaam').on('input', function() {
            loadTable();
        });

        $(function () {
            loadTable();
            loadDropdown()

            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('plaat');


                // Set some values for Noty
                let text = `<p>Wil je nummerplaat <b>${naam}</b> verwijderen?</p>`;
                let type = 'warning';
                let btnText = 'Verwijder nummerplaat';
                let btnClass = 'btn-success';


                // Show Noty
                let modal = new Noty({
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {

                            deleteNummerplaat(id);
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
                let naam = $(this).closest('td').data('plaat');
                let bedrijf = $(this).closest('td').data('bedrijf');
                let land = $(this).closest('td').data('land');
                // Update the modal
                $('.modal-title').text(`Bewerk ${naam}`);
                $('form').attr('action', `/admin/nummerplaats/${id}`);



                $('#naam').val(naam);
                $('#bedrijf_id').val(bedrijf);
                $('#land').val(land);

                $('input[name="_method"]').val('put');

                // Show the modal
                $('#modal-nummerplaat').modal('show');
            });

            $('#btn-create').click(function () {
                // Update the modal
                $('.modal-title').text(`Nieuwe nummerplaat`);
                $('form').attr('action', `/admin/nummerplaats`);

                $('#naam').val();



                $('input[name="_method"]').val('post');
                // Show the modal
                $('#modal-nummerplaat').modal('show');
            });

            $('#modal-nummerplaat form').submit(function (e) {
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
                        $('#modal-nummerplaat').modal('hide');
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

        function deleteNummerplaat(id) {

            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/nummerplaats/${id}`, pars, 'json')
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
            if(document.getElementById('nummerplaatzoeknaam').value != null || document.getElementById('nummerplaatzoeknaam').value != ''){

                text = document.getElementById('nummerplaatzoeknaam').value;
            }


            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: '/admin/qryNummerplaats', // This is the url we gave in the route
                data: {'text': text, _token: '{{csrf_token()}}'},
                // a JSON object to send back
                success: function (data) {

                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {

                        console.log(value)
                        let tr = `<tr>
                               <td>${value.plaatcombinatie} </td>
                                <td>${value.land} </td>
                               <td>${value.bedrijfsnaam}</td>


                               <td data-id="${value.id}"
                                    data-plaat="${value.plaatcombinatie}"
                                    data-bedrijf="${value.bedrijfID}"
                                    data-land="${value.land}"
                                   >
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Bewerk ${value.plaatcombinatie}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete" data-toggle="tooltip" title="Verwijder ${value.plaatcombinatie}">
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
        function loadDropdown(){
            $.getJSON('/admin/qryNummerplaats2')
                .done(function (data) {
                    $.each(data, function (key, value) {
                        $('#bedrijf_id').append('<option value="'+ value.id + '">' + value.bedrijfsnaam + '</option>');
                    })
                });

        }
    </script>
@endsection
