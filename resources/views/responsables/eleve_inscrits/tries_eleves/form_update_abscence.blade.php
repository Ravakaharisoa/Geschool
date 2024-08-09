<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Ajouter le motif d'abscence de : {{$eleve->nom}}&nbsp;{{$eleve->prenom}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body mx-1" id="modalBody">
    <input type="hidden" id="abs_id" name="abs_id" value="{{$abs_id}}">
    <div class="row mx-1 justify-content-center">
        <div class="form-group">
            <label for="motif_abs">Motif <span class="text-danger">*</span> :</label>
            <input type="text" class="form-control" id="motif_abs" name="motif_abs">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
    <button type="button" class="btn btn-sm btn-success ajout_motif"><i class="fas fa-save mr-2"></i> Ajouter</button>
</div>
