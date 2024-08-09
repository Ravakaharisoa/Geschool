<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Modifier Photo de profile</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="forms-ajouts-photo" enctype="multipart/form-data">
    <div class="modal-body" id="modalBody">
        <div class="row justify-content-center">
            <div class="form-group form-show-validation row">
                <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 fw-bold text-right">Photo :<span class="required-label">*</span></label>
                <div class="col-lg-7 col-md-9 col-sm-8">
                    <div class="input-file input-file-image">
                        <img class="img-upload-preview img-circle" id="img-upload-preview" width="100" height="100" src="{{asset('assets/img/defaultuser.png')}}" alt="preview">
                        <input type="file" class="form-control form-control-file" id="img_resp" name="img_resp" accept="image/*" required >
                        <label for="img_resp" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success" id="ajout_photo_resp"><i class="fas fa-save mr-2"></i> Ajouter</button>
    </div>
</form>
