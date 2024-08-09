@extends('layouts.app_page')
@section('contents')
	<div class="align-items-left d-flex justify-content-between align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold">Nouvelle matière</h2>
		</div>
		<div>
			<button type="button" id="add-matiere" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i> Nouvelle matière</button>
		</div>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped listeMatiere">
                <thead class="text-center bg-primary text-white">
                    <tr>
                        <th>N°</th>
                        <th>Matières</th>
                        <th>Abréviations</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>
        </div>
	</div>
@endsection

