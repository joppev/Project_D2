@extends('layouts.template')

@section('main')
    <div class="row justify-content-around mt-5 mb-2">

        <div class="col-sm-6 mb-2">
            <h1 class="ml-2">Bedrijven</h1>
        </div>



            <div class="col-sm-3 mb-2">
                <input type="text" class="form-control" name="bedrijfzoeknaam" id="bedrijfzoeknaam"
                       value="" placeholder="Filter bedrijven">
            </div>
            <div class="col-sm-3 mb-2">
                <p>
                    <a href="#!" class="btn btn-outline-success" id="btn-create">
                        <i class="fas fa-plus-circle mr-1"></i>Bedrijf toevoegen</a>
                </p>
            </div>
        </div>



    <div class="row">
        <div class="table-responsive col-12">
            <table class="table table-striped" id="bedrijventable">
                <thead>
                <tr>
                    <th width="37.5%">Bedrijf</th>
                    <th width="37.5%">Standaard wachtwoord</th>
                    <th width="25%">Bewerken</th>
                </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
        @include('admin.bedrijven.modal')
        @endsection





        @section('script_after')

            <script>
                jQuery('#bedrijfzoeknaam').on('input', function() {
                    loadTable();
                });

          /*     $(document).ready(function () {
                    $('#bedrijventable').DataTable({
                        serverSide: true,
                        ajax: '/bedrijven/admin',
                        language: {
                            "sProcessing": "Bezig...",
                            "sLengthMenu": "_MENU_ resultaten weergeven",
                            "sZeroRecords": "Geen resultaten gevonden",
                            "sInfo": "_START_ tot _END_ van _TOTAL_ resultaten",
                            "sInfoEmpty": "Geen resultaten om weer te geven",
                            "sInfoFiltered": " (gefilterd uit _MAX_ resultaten)",
                            "sInfoPostFix": "",
                            "sSearch": "Zoeken:",
                            "sEmptyTable": "Geen resultaten aanwezig in de tabel",
                            "sInfoThousands": ".",
                            "sLoadingRecords": "Een moment geduld aub - bezig met laden...",
                            "oPaginate": {
                                "sFirst": "Eerste",
                                "sLast": "Laatste",
                                "sNext": "Volgende",
                                "sPrevious": "Vorige"
                            },
                            "oAria": {
                                "sSortAscending": ": activeer om kolom oplopend te sorteren",
                                "sSortDescending": ": activeer om kolom aflopend te sorteren"
                            }
                        }
                    });
                });*/






                $(function () {
                    loadTable();
                   /* $('#bedrijventable').DataTable({
                        serverSide: true,
                        ajax: '/admin/qryBedrijven',
                        language: {
                            "sProcessing": "Bezig...",
                            "sLengthMenu": "_MENU_ resultaten weergeven",
                            "sZeroRecords": "Geen resultaten gevonden",
                            "sInfo": "_START_ tot _END_ van _TOTAL_ resultaten",
                            "sInfoEmpty": "Geen resultaten om weer te geven",
                            "sInfoFiltered": " (gefilterd uit _MAX_ resultaten)",
                            "sInfoPostFix": "",
                            "sSearch": "Zoeken:",
                            "sEmptyTable": "Geen resultaten aanwezig in de tabel",
                            "sInfoThousands": ".",
                            "sLoadingRecords": "Een moment geduld aub - bezig met laden...",
                            "oPaginate": {
                                "sFirst": "Eerste",
                                "sLast": "Laatste",
                                "sNext": "Volgende",
                                "sPrevious": "Vorige"
                            },
                            "oAria": {
                                "sSortAscending": ": activeer om kolom oplopend te sorteren",
                                "sSortDescending": ": activeer om kolom aflopend te sorteren"
                            }
                        }
                    });*/

                    //Bedrijf verwijderen

                    $('tbody').on('click', '.btn-delete', function () {
                        // Get data attributes from td tag
                        let id = $(this).closest('td').data('id');
                        let bedrijfsnaam = $(this).closest('td').data('bedrijfsnaam');

                        // Set some values for Noty
                        let text = `<p>Wil je het bedrijf <b>${bedrijfsnaam}</b> verwijderen?</p>`;
                        let type = 'warning';
                        let btnText = 'Verwijder bedrijf';
                        let btnClass = 'btn-success';

                        // Show Noty
                        let modal = new Noty({
                            type: type,
                            text: text,
                            buttons: [
                                Noty.button(btnText, `btn ${btnClass}`, function () {
                                    deleteBedrijf(id);
                                    modal.close();
                                }),
                                Noty.button('Annuleer', 'btn btn-secondary ml-2', function () {
                                    modal.close();
                                })
                            ]
                        }).show();
                    });

                    //Bedrijf bewerken

                    $('tbody').on('click', '.btn-edit', function () {
                        // Get data attributes from td tag
                        let id = $(this).closest('td').data('id');
                        let bedrijfsnaam = $(this).closest('td').data('bedrijfsnaam');
                        let standaardWachtwoord = $(this).closest('td').data('standaardWachtwoord');
                        // Update the modal
                        $('.modal-title').text(`${bedrijfsnaam} bewerken`);
                        $('form').attr('action', `/admin/bedrijven/${id}`);

                        $('#bedrijfsnaam').val(bedrijfsnaam);
                        $('#standaardWachtwoord').val(standaardWachtwoord);
                        $('input[name="_method"]').val('put');

                        // Show the modal
                        $('#modal-bedrijven').modal('show');
                    });

                    //Bedrijf toevoegen
                    $('#btn-create').click(function () {
                        // Update the modal
                        $('.modal-title').text(`Nieuw bedrijf`);
                        $('form').attr('action', `/admin/bedrijven`);

                        $('#bedrijfsnaam').val('');
                        $('#standaardWachtwoord').val('');

                        $('input[name="_method"]').val('post');
                        // Show the modal
                        $('#modal-bedrijven').modal('show');
                    });

                    $('#modal-bedrijven form').submit(function (e) {
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
                                $('#modal-bedrijven').modal('hide');
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
                                }).show();

                            });
                    });
                });

                //functie Bedrijf verwijderen
                function deleteBedrijf(id) {
                    let pars = {
                        '_token': '{{ csrf_token() }}',
                        '_method': 'delete'
                    };
                    $.post(`/admin/bedrijven/${id}`, pars, 'json')
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

                //Laad bedrijven met AJAX
                function loadTable() {


                    let text = '';
                    if(document.getElementById('bedrijfzoeknaam').value != null || document.getElementById('bedrijfzoeknaam').value != ''){

                        text = document.getElementById('bedrijfzoeknaam').value;
                    }


                    $.ajax({
                        method: 'GET', // Type of response and matches what we said in the route
                        url: '/admin/qryBedrijven', // This is the url we gave in the route
                        data: {'text': text, _token: '{{csrf_token()}}'},
                        // a JSON object to send back
                        success: function (data) {
                            // Clear tbody tag
                            $('tbody').empty();

                            // Loop over each item in the array
                            $.each(data, function (key, value) {
                                let tr = `<tr class="">
                                   <td>${value.bedrijfsnaam}</td>
                                   <td>${value.standaardWachtwoord}</td>

                                  <td data-id="${value.id}"
                                       data-bedrijfsnaam="${value.bedrijfsnaam}"
                                       data-standaardWachtwoord="${value.standaardWachtwoord}">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#!" class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Bewerk ${value.bedrijfsnaam}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#!" class="btn btn-outline-danger btn-delete" data-toggle="tooltip" title="Verwijder ${value.bedrijfsnaam}">
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
