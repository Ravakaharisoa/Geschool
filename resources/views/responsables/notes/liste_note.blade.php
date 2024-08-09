@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-users-cog"></i>&nbsp;&nbsp; Listes de note de chacque éléve de la classe</h2>
	</div>
    <hr>
</div>
<div class="row mx-4 my-1">
    <div class="alert alert-info alert-dismissible w-100" role="alert">
        <strong>Pour trouver la liste de note des élèves, vous devez spécifier la classe</strong>
        <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
    </div>
</div>
<div class="row mx-1">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control select2_classe classe_etudiant">
                <option value="" hidden selected>Choisissez la classe</option>
                @if (count($classes)>0)
                    @foreach ($classes as $classe)
                        <option value="{{$classe->id}}">{{$classe->nom_classe}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control select2_classe module_dispo">
                <option value="" hidden selected>Choisissez une module</option>
                @if (count($modules)>0)
                    @foreach ($modules as $module)
                        <option value="{{$module->id}}">{{$module->trimestre}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-success mt-2" id="details_note_module">Aficher les détails</button>
    </div>
</div>
<div class="row mx-1 my-3" id="tables-listes-eleves">

</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/resp.js')}}"></script>
@endpush
