<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">CHANGEMENT D'ANNEE SCOLAIRE</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="modalBody">
    <div class="alert alert-danger" role="alert">
        <span><b class="text-danger">Attention!!!</b> Si vous changez l'année scolaire, seules les informations enregistrées à cette année en question seront disponibles.</span>
    </div>
    <div class="col-md-8 m-auto">
        <div class="form-group">
            <label>Année scolaire <span class="text-danger">*</span></label>
            <select class="form-control" id="anneeSco_change">
                <option hidden selected></option>
                @if (count($annees)>0)
                    @foreach ($annees as $anne)
                        <option value="{{$anne->id}}" {{$anne->id == $anneeActuel->annee_scolaire_id?"selected":""}}>{{$anne->annee_sco}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
    <button type="button" class="btn btn-sm btn-success" id="update_current_annee"><i class="fas fa-save mr-2"></i>  Changer</button>
</div>
