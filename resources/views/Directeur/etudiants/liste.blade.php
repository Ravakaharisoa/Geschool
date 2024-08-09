@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-users-cog"></i>&nbsp;&nbsp; Listes des éléves de la classe</h2>
	</div>
    <hr>
</div>
<div class="row mx-4 my-1">
    <div class="alert alert-info alert-dismissible w-100" role="alert">
        <strong>Pour trouver la liste des élèves, vous devez spécifier la classe</strong>
        <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
    </div>
</div>
<div class="row mx-1">
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control select2_classe" id="choix-classe">
                <option hidden selected>Choisissez la classe</option>
                @if (count($classes)>0)
                    @foreach ($classes as $classe)
                        <option value="{{$classe->id}}">{{$classe->nom_classe}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row mx-1 my-3" id="table-liste-eleve">

</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/main.js')}}"></script>
@endpush
