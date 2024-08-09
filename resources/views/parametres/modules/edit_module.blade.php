<div class="p-1 my-3">
	<h3 class="text-center">Modification de la module !</h3>
	<div class="form-group mx-2">
		<input type="hidden" id="module_id" value="{{$module->id}}">
		<label class="text-muted" id="label-update-module">Module</label>
		<input type="text" id="edit-module" class="form-control" value="{{$module->trimestre}}">
	</div>
	<div class="mx-2 mt-2 text-center">
		<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-times mr-2"></i> Annuler</button>
        <button type="button" id="btn-update-module" class="btn btn-sm btn-success btn-save ml-2"><i class="fas fa-save mr-2"></i>Modifier</button>
	</div>
</div>