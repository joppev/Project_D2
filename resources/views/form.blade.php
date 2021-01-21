@csrf
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <p>Bij: <span class="name_recruiter"></span> <span class="id_recruiter"></span></p>
        </div>
        <div class="form-group">
            <p>Om: <span class="begin_time"></span></p>
        </div>
        <div class="form-group">
            <label for="cvBrief">CV:</label>
            <input type="file" class="form-control" name="cvBrief" id="cvBrief"/>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="motivatieBrief">Motivatie brief:</label>
            <input type="file" class="form-control" name="motivatieBrief" id="motivatieBrief"/>
            <div class="invalid-feedback"></div>
        </div>
        <input type="hidden" name="timeslot_id" id="timeslot_id">
        <input type="hidden" name="recruiter_id" id="recruiter_id">
        <input type="hidden" name="name_recruiter" id="name_recruiter">
        <input type="hidden" name="begin_time" id="begin_time">
    </div>
</div>
