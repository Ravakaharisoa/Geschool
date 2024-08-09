<div class="p-1 my-3">
	<h3 class="text-center">Modification Année Matière!</h3>
	<div class="form-group mx-2">
        <input type="hidden" id="matiere_id" value="{{$matiere->id}}">
		<label class="text-muted" id="label_new_matiere">Entrez la matière</label>
		<input type="text" id="new_matiere" class="form-control" value="{{$matiere->matiere}}">
	</div>
    <div class="form-group mx-2">
		<label class="text-muted" id="label-abrev-matiere">Entrez la matière</label>
		<input type="text" id="new_abrev" class="form-control" value="{{$matiere->abreviation}}">
	</div>
	<div class="mx-2 mt-2 text-center">
		<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times mr-2"></i> Annuler</button>
        <button type="button" id="btn-update-matiere" class="btn btn-sm btn-success btn-save ml-2"><i class="fas fa-save mr-2"></i>Modifier</button>
	</div>
</div>
