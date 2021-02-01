<div class="modal" id="modal-nummerplaat">
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
                        <label for="naam">Plaatcombinatie</label>
                        <input type="text" name="plaatcombinatie" id="naam"
                               class="form-control"
                               placeholder="Plaatcombinatie"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="rol">Afkomst nummerplaat</label>
                        <select required class="form-control" name="land" id="land">
                            <option value="%">alle Landen</option>
                            <option value="België">België</option>
                            <option value="Nederland">Nederland</option>
                            <option value="Frankrijk">Frankrijk</option>
                            <option value="Duitsland">Duitsland</option>
                            <option value="Gepersonaliseerd">Gepersonaliseerd</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Bedrijf</label>
                        <select class="form-control " name="bedrijf_id" id="bedrijf_id">
                            <option value="%">alle bedrijven</option>
                        </select>

                    </div>




                    <button type="submit" class="btn btn-success">Nummerplaat opslaan</button>
                </form>
            </div>
        </div>
    </div>
</div>


