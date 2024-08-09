<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">AJOUT DE NOUVELLE CLASSE</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="modalBody">
    <div class="col-md-9 m-auto">
        <div class="form-group">
            <label>Nom de la classe <span class="text-danger">*</span></label>
            <input type="text" name="classe" id="classe" class="form-control">
        </div>
        <div class="form-group">
            <label>Scolarité de la classe <span class="text-danger">*</span></label>
            <input type="number" name="scolarite" id="scolarite" class="form-control">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
    <button type="button" class="btn btn-sm btn-success" id="ajout_classe"><i class="fas fa-save mr-2"></i> Ajouter</button>
</div>
