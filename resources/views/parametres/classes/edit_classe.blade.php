<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">MODIFIER UNE CLASSE</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="modalBody">
    <div class="col-md-9 m-auto">
        <input type="hidden" id="classe_id" value="{{$classe->id}}">
        <div class="form-group">
            <label>Nom de la classe <span class="text-danger">*</span></label>
            <input type="text" name="classe" id="edit_classe" class="form-control" value="{{$classe->nom_classe}}" required>
        </div>
        <div class="form-group">
            <label>Scolarité de la classe <span class="text-danger">*</span></label>
            <input type="number" name="scolarite" id="edit_scolarite" class="form-control" value="{{ nombre_format($classe->montant_total) }}" required>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
    <button type="button" class="btn btn-sm btn-success" id="update_classe"><i class="fas fa-save mr-2"></i> Modifier</button>
</div>
