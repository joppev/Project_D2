@extends('layouts.template')

@section('main')
    <div class="row justify-content-around">

        <h1>Planningen</h1>

        <p>
            <a href="#!" class="btn btn-outline-success" id="btn-create">
                <i class="fas fa-plus-circle mr-1"></i>Planning toevoegen
            </a>
        </p>
    </div>


    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Tijdstip</th>
                <th>Bedrijf</th>
                <th>Chauffeur</th>
                <th>Nummerplaat</th>
                <th>Loskade</th>
                <th>Bewerken</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.planning.model')
@endsection

@section('script_after')
    <script>
        $(function () {
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


                // Update the modal
                $('.modal-title').text(`Edit Planning`);
                $('form').attr('action', `/admin/plannings/${id}`);

                $('#aantal').val(aantal);
                $('#proces').val(proces);
                $('#lading').val(lading);

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
                console.log(pars);
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
                        console.log('data', data);

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
                $.getJSON('/admin/qryPlannings')
                    .done(function (data) {
                        console.log('data', data);
                        // Clear tbody tag
                        $('tbody').empty();
                        // Loop over each item in the array
                        $.each(data, function (key, value) {
                            console.log(value)

                            let tr = `<tr>

                               <td>${value.startTijd} - ${value.stopTijd}</td>
                                <td>${value.bedrijfsnaam}</td>
                               <td>${value.voornaam} ${value.naam}</td>
                                <td>${value.plaatcombinatie}</td>
                                <td>${value.kadenaam}</td>
                               <td data-id="${value.id}"
                                    data-aantal="${value.aantal}"
                                    data-lading="${value.ladingDetails}"
                                    data-proces="${value.proces}"
                                    data-naam="${value.naam}"
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
                    })
                    .fail(function (e) {
                        console.log('error', e);
                    })

            }
        });

        function loadDropdown() {
            $.getJSON('/admin/qryPlanningsUsers')
                .done(function (data) {
                    console.log('data', data);
                    $.each(data, function (key, value) {
                        $('#user_id').append('<option value="' + value.id + '">' + value.voornaam + ' ' + value.naam + '</option>');
                    })
                });

            $.getJSON('/admin/qryPlanningsKades')
                .done(function (data) {
                    console.log('data', data);
                    $.each(data, function (key, value) {
                        $('#kade_id').append('<option value="' + value.id + '">' + value.kadenaam + '</option>');
                    })
                });

        }




    </script>

@endsection
