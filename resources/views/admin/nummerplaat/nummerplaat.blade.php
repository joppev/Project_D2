@extends('layouts.template')

@section('main')
    <div class="row justify-content-around">

    <h1>Nummerplaten</h1>

    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Nummerplaat toevoegen
        </a>
    </p>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Nummerplaat</th>
                <th>Bedrijf</th>
<th>Bewerken</th>

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
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('plaat');

                // Update the modal
                $('.modal-title').text(`Edit ${naam}`);
                $('form').attr('action', `/admin/nummerplaats/${id}`);

                $('#naam').val(naam);

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
            $.getJSON('/admin/qryNummerplaats')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value)

                        let tr = `<tr>
                               <td>${value.plaatcombinatie} </td>
                               <td>${value.bedrijfsnaam}</td>


                               <td data-id="${value.id}"
                                    data-plaat="${value.plaatcombinatie}"

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
                })
                .fail(function (e) {
                    console.log('error', e);
                })

        }
        function loadDropdown(){
            $.getJSON('/admin/qryNummerplaats2')
                .done(function (data) {
                    console.log('data', data);
                    $.each(data, function (key, value) {
                        $('#bedrijf_id').append('<option value="'+ value.id + '">' + value.bedrijfsnaam + '</option>');
                    })
                });

        }
    </script>
@endsection
