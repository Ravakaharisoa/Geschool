<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Ajouter les notes de : <b>{{$etudiant->nom}}&nbsp;{{$etudiant->prenom}}</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form-ajout-scolarite">
    <div class="modal-body" id="modalBody">
        <input type="hidden" id="etudiant_id" name="etudiant_id" value="{{$etudiant->id}}">
        <div class="row col-12 mx-1">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Note</label>
                    <input type="number" name="note_etud" id="note_etud" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Matière</label>
                    <select name="matiere_id" id="matiere_id" class="form-control">
                        <option hidden selected>----</option>
                        @if (count($matieres)>0)
                            @foreach ($matieres as $matiere)
                                <option value="{{$matiere->id}}">{{$matiere->matiere}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Date d'évaluation</label>
                    <input type="date" name="date_eval" id="date_eval" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Coefficient</label>
                    <select name="coefficient" id="coefficient" class="form-control">
                        <option hidden selected>----</option>
                        @for ($i=1;$i<=10;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Module</label>
                    <select name="module_id" id="module_id" class="form-control">
                        <option hidden selected>----</option>
                        @if (count($modules)>0)
                            @foreach ($modules as $module)
                                <option value="{{$module->id}}">{{$module->trimestre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Type Examen</label>
                    <select name="type_exam" id="type_exam" class="form-control">
                        <option hidden selected>----</option>
                        @if (count($types)>0)
                            @foreach ($types as $type)
                                <option value="{{$type->id}}">{{$type->type}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success" id="ajouter_note_etud"><i class="fas fa-save mr-2"></i> Enregistrer</button>
    </div>
</form>
