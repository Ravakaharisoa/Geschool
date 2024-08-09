<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Notification d'abscence</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form-ajout-scolarite">
    <div class="modal-body" id="modalBody">
        <input type="hidden" id="eleve_id" name="eleve_id" value="{{$eleve_id}}">
        <div class="justify-content-center col-9 m-auto">
            <div class="form-group">
                <label for="">Date d'abscence</label>
                <input type="date" name="date_abs" id="date_abs" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Cours</label>
                <select name="cours" id="cours" class="form-control">
                    <option hidden selected>Choix</option>
                    @if (count($cours)>0)
                        @foreach ($cours as $cour)
                            <option value="{{$cour->id}}">{{$cour->matiere->matiere}} | {{$cour->jour}}
                                ( {{heure_format($cour->heure_debut,'H').'h'.heure_format($cour->heure_debut,'i')}}&nbsp;à &nbsp;{{heure_format($cour->heure_fin,'H').'h'.heure_format($cour->heure_fin,'i')}} )</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success" id="note_abscence_etud"><i class="fas fa-save mr-2"></i> Enregistrer</button>
    </div>
</form>
