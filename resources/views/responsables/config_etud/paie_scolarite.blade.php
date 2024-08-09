<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Paiement de la scolarité</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form-ajout-scolarite">
    <div class="modal-body" id="modalBody">
        <input type="hidden" id="eleve_id" name="eleve_id" value="{{$eleve_id}}">
        <div class="row justify-content-center">
            <div class="form-group form-show-validation">
                <label class="fw-bold">Montant à payer :<span class="required-label">*</span></label>
                <input type="number" name="montant_paie" id="montant_paie" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success" id="paie_scolarite_etud"><i class="fas fa-save mr-2"></i> Payer</button>
    </div>
</form>
