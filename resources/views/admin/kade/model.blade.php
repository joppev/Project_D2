<div class="modal" id="modal-kade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">modal-kade-title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @method('')
                    @csrf

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
                        <label for="land">Land</label>
                        <input type="text" name="land" id="land"
                               class="form-control"
                               placeholder="Land"
                               minlength="3"
                               required
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="gemeente">Gemeente</label>
                        <input type="text" name="gemeente" id="gemeente"
                               class="form-control"
                               placeholder="Gemeente"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="adres">Adres</label>
                        <input type="text" name="adres" id="adres"
                               class="form-control"
                               placeholder="Adres"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude"
                               class="form-control"
                               placeholder="Latitude"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude"
                               class="form-control"
                               placeholder="Longitude"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="%">alle Statussen</option>
                            <option value="1">Vrij</option>
                            <option value="2">Niet-vrij</option>
                            <option value="3">Buiten gebruik</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success">Kade opslaan</button>
                </form>
            </div>
        </div>
    </div>
</div>
