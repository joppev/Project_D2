@extends('layouts.template')

@section('main')
    <div class="row justify-content-around">

    <h1>Kades</h1>

    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Kade toevoegen
        </a>
    </p>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Land</th>
                <th>Gemeente</th>
                <th>Status</th>
                <th>Bewerken</th>

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
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
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
                $('.modal-title').text(`Edit ${naam}`);
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
            $.getJSON('/admin/qryKades')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value)

                        let tr = `<tr>
                               <td> ${value.kadenaam} </td>
                               <td>${value.land}</td>
                               <td>${value.gemeente}</td>
                               <td>${value.status}</td>

                               <td data-id="${value.id}"
                                    data-naam="${value.kadenaam}"
                                   data-land="${value.land}"
                                   data-gemeente="${value.gemeente}"
                                   data-adres="${value.adres}"
                                   data-lat="${value.latitude}"
                                    data-lon="${value.longitude}"
                                    data-status="${value.status}">
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
                })
                .fail(function (e) {
                    console.log('error', e);
                })

        }

    </script>
@endsection
