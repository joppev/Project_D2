<div class="modal" id="modal-planning">
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
                        <label for="startdate">Startdatum: </label>
                        <input type="date" id="startdate" name="startdate">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="starttime">Starttijdstip: </label>
                        <input type="time" id="starttime" name="starttime">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="stoptime">Eindtijdstip: </label>
                        <input type="time" id="stoptime" name="stoptime">
                        <div class="invalid-feedback"></div>
                    </div>


                          {{-- <div class="form-group">
                                 <label for="exampleFormControlSelect1">starten</label>
                                 <input type="text" name="starttijd" id="starttijd"
                                        class="form-control date"
                                        placeholder="Datum & tijdstip"
                                        required
                                        value="">
                             </div>

                             <div class="form-group">
                                 <label for="exampleFormControlSelect1">stop</label>
                                 <input type="text" name="stoptijd" id="stoptijd"
                                        class="form-control date"
                                        placeholder="Datum & tijdstip"
                                        required
                                        value="">
                             </div>--}}
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Chauffeur</label>
                        <select class="form-control " name="user_id" id="user_id">
                            <option value="%">alle chauffeurs</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kade</label>
                        <select class="form-control " name="kade_id" id="kade_id">
                            <option value="%">alle kades</option>
                        </select>
                    </div>




                    <div class="form-group">
                        <label for="proces">Proces</label>
                        <input type="text" name="proces" id="proces"
                               class="form-control"
                               placeholder="Proces"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="lading">Lading details</label>
                        <input type="text" name="lading" id="lading"
                               class="form-control"
                               placeholder="Lading details"
                               minlength="3"
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="lading">Aantal goederen</label>
                        <input type="text" name="aantal" id="aantal"
                               class="form-control"
                               placeholder="Aantal goederen "
                               required
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Status</label>
                        <select class="form-control" name="status" id="exampleFormControlSelect1">
{{--                            <option value="%">alle statusen</option>--}}
                            <option value="1">Afgewerkt</option>
                            <option value="2">Bezig</option>
                            <option value="3">Aanwezig</option>
                            <option value="4">Niet afgewerkt</option>
                        </select>
                    </div>





                    <button type="submit" class="btn btn-success">Planning opslaan</button>
                </form>
            </div>
        </div>
    </div>
</div>

