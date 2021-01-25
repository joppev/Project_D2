<div class="modal" id="modal-bedrijven">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">modal-bedrijf-title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @method('')
                    @csrf

                    <div class="form-group">
                        <label for="bedrijfsnaam">Naam bedrijf</label>
                        <input type="text" name="bedrijfsnaam" id="bedrijfsnaam"
                               class="form-control"
                               placeholder="Bedrijfsnaam"
                               minlength="3"
                               required
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="standaardWachtwoord">Standaard wachtwoord</label>
                        <input type="text" name="standaardWachtwoord" id="standaardWachtwoord"
                               class="form-control"
                               placeholder="Standaard wachtwoord"
                               minlength="8"
                               required
                               value="">
                    </div>

                <button type="submit" class="btn btn-success">Bedrijf opslaan</button>
                </form>
            </div>
        </div>
    </div>
</div>


