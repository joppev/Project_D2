@extends('layouts.template')

@section('main')
    <h1>Alle gebruikers</h1>

    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Gebruiker aanmaken
        </a>
    </p>


    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Bedrijf</th>
                <th>Rol</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @include('admin.user.model')
@endsection

@section('script_after')
    <script>

        $(function () {
            loadTable();
            loadDropdown();

            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('naam');
                let voornaam = $(this).closest('td').data('voornaam');

                // Set some values for Noty
                let text = `<p>Wil je gebruiker <b>${voornaam} ${naam}</b> verwijderen?</p>`;
                let type = 'warning';
                let btnText = 'Verwijderen';
                let btnClass = 'btn-danger';


                // Show Noty
                let modal = new Noty({
                    type: 'error',
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {

                            deleteUser(id);
                            modal.close();
                        }),
                        Noty.button('Terug', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            $('tbody').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let naam = $(this).closest('td').data('naam');
                let voornaam = $(this).closest('td').data('voornaam');
                let email = $(this).closest('td').data('email');
                let bid = $(this).closest('td').data('bedrijf');
                let rol = $(this).closest('td').data('rol');
                console.log(bid)
                console.log(rol)
                // Update the modal
                $('.modal-title').text(`Edit ${naam}`);
                $('form').attr('action', `/admin/users/${id}`);

                $('#naam').val(naam);
                $('#voornaam').val(voornaam);
                $('#email').val(email);
                $('#bedrijf_id').val(bid)
                $('#rol').val(rol)

                $('input[name="_method"]').val('put');

                // Show the modal
                $('#modal-user').modal('show');
            });

            $('#btn-create').click(function () {
                // Update the modal
                $('.modal-title').text(`Nieuwe gebruiker`);
                $('form').attr('action', `/admin/users`);

                $('#naam').val();
                $('#voornaam').val();
                $('#email').val();


                $('input[name="_method"]').val('post');
                // Show the modal
                $('#modal-user').modal('show');
            });

            $('#modal-user form').submit(function (e) {
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
                        $('#modal-user').modal('hide');
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

        function deleteUser(id) {

            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users/${id}`, pars, 'json')
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
            $.getJSON('/admin/qryUsers')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        console.log(value)
                        var rol = "";
                        if(value.isAdmin == true){
                            rol = "1"
                        } else if(value.isChauffeur){
                            rol = "2"
                        } else if(value.isReceptionist){
                            rol = "3"
                        } else if(value.isLogistiek){
                            rol = "4"
                        }
                        var functie = ""
                        if (rol == "1"){
                            functie = "Admin"
                        } else if(rol == "2"){
                            functie = "Chauffeur"
                        } else if (rol == "3"){
                            functie = "Receptionist"
                        }else{
                            functie = "Logistiek"
                        }
                        let tr = `<tr>
                               <td>${value.voornaam} ${value.naam} </td>
                               <td>${value.bedrijfsnaam}</td>

                               <td>${functie}</td>
                               <td data-id="${value.id}"
                                   data-voornaam="${value.voornaam}"
                                   data-naam="${value.naam}"
                                   data-email="${value.email}"
                                   data-bedrijf="${value.bedrijfsID}"
                                   data-rol="${rol}">

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
        function loadDropdown(){
            $.getJSON('/admin/qryUsers2')
                .done(function (data) {
                    console.log('data', data);
                    $.each(data, function (key, value) {
                        $('#bedrijf_id').append('<option value="'+ value.id + '">' + value.bedrijfsnaam + '</option>');
                    })
                });

        }
    </script>
@endsection
