@extends('layouts.template')



@section('main')
    <h1>Processen</h1>
    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Proces toevoegen
        </a>
    </p>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>

                <th>Naam</th>

                <th>Bewerken</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.proces.model')
@endsection
@section('script_after')
    <script>
        $(function () {
            loadTable();
        });

        $('tbody').on('click', '.btn-delete', function () {
            // Get data attributes from td tag
            let id = $(this).closest('td').data('id');
            let naam = $(this).closest('td').data('soort');

            // Set some values for Noty
            let text = `<p>Wil je het proces <b>${naam}</b> verwijderen?</p>`;
            let type = 'warning';
            let btnText = 'Verwijder proces';
            let btnClass = 'btn-success';
            // If records not 0, overwrite values for Noty

            // Show Noty
            let modal = new Noty({
                type: type,
                text: text,
                buttons: [
                    Noty.button(btnText, `btn ${btnClass}`, function () {
                        // Delete genre and close modal
                        deleteSoort(id);
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
            let naam = $(this).closest('td').data('soort');
            // Update the modal
            $('.modal-title').text(`Edit ${naam}`);
            $('form').attr('action', `/admin/soorts/${id}`);
            $('#naam').val(naam);
            $('input[name="_method"]').val('put');
            // Show the modal
            $('#modal-soort').modal('show');
        });
        $('#modal-soort form').submit(function (e) {
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
                    $('#modal-soort').modal('hide');
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
        $('#btn-create').click(function () {
            // Update the modal
            $('.modal-title').text(`Nieuw proces`);
            $('form').attr('action', `/admin/soorts`);
            $('#naam').val('');
            $('input[name="_method"]').val('post');
            // Show the modal
            $('#modal-soort').modal('show');
        });
        function deleteSoort(id) {
            // Delete the genre from the database
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/soorts/${id}`, pars, 'json')
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
            $.getJSON('/admin/qrySoorts')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value);
                        let tr = `<tr>

                               <td>${value.soortNaam}</td>

                               <td data-id="${value.id}"
                                   data-soort="${value.soortNaam}"
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
    </script>
@endsection
