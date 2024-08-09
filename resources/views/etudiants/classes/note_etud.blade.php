@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-2 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-tasks"></i>&nbsp;&nbsp;Liste notes</h2>
	</div>
    <hr>
</div>
<div class="row my-1 mx-3">
    <div class="alert alert-info alert-dismissible w-100" role="alert">
        <strong>Pour afficher les détails de note des étudiants, vous devez choisir une module</strong>
        <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
    </div>
</div>
<div class="row mx-1">
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Module :</label>
            <select class="form-control select2_classe" id="choix_module">
                <option hidden selected>Choisissez une module</option>
                @if (count($modules)>0)
                    @foreach ($modules as $module)
                        <option value="{{$module->id}}">{{$module->trimestre}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row mx-1 my-3" id="table_liste_eleve">

</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/etud.js')}}"></script>
@endpush
