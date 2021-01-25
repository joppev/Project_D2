<div class="modal" id="modal-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">modal-user-title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @method('')
                    @csrf

                    <div class="form-group">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" name="voornaam" id="voornaam"
                               class="form-control"
                               placeholder="Voornaam"
                               minlength="3"
                               required
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="naam">Naam</label>
                        <input type="text" name="naam" id="naam"
                               class="form-control"
                               placeholder="Naam"
                               minlength="3"
                               required
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control"
                               placeholder="Email"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Bedrijf</label>
                        <select class="form-control " name="bedrijf_id" id="bedrijf_id">
                            <option value="%">alle bedrijven</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Rol</label>
                        <select class="form-control" name="rol" id="exampleFormControlSelect1">
                            <option value="%">alle rollen</option>
                            <option value="1">Chauffeur</option>
                            <option value="2">Logistiek</option>
                            <option value="3">Receptionist</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success">Gebruiker opslaan</button>
                </form>
            </div>
        </div>
    </div>
</div>


