<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Payer le transport scolaire de : {{$eleve->nom}}&nbsp;{{$eleve->prenom}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form-payer-transport">
    <div class="modal-body" id="modalBody">
        <input type="hidden" id="etudiant_id" name="etudiant_id" value="{{$eleve->id}}">
        <div class="row mx-1">
            <div class="col-sm-6 col-md-8 m-auto">
                <div class="form-group">
                    <label for="libelle_transp">Libelle <span class="text-danger">*</span> :</label>
                    <input type="month" class="form-control" id="libelle_transp" name="libelle_transp" required>
                </div>
                <div class="form-group">
                    <label for="montant_trans">Montant <span class="text-danger">*</span> :</label>
                    <input type="number" class="form-control" id="montant_trans" name="montant_trans" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success payer_trans_etud"><i class="fas fa-save mr-2"></i> Payer</button>
    </div>
</form>
