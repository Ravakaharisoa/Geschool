@extends('layouts.app_page')
@section('contents')
	<div class="align-items-left d-flex justify-content-between align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold">Nouvelle Année Scolaire</h2>
		</div>
		<div>
			<button type="button" id="add-annee-scol" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i> Nouvelle Année Scolaire</button>
		</div>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped listeAnneeSco">
                <thead class="text-center bg-primary text-white">
                    <tr>
                        <th>N°</th>
                        <th>Année Scolaire</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center"></tbody>
            </table>
        </div>
	</div>
@endsection
