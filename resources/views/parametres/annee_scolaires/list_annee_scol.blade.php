@if(count($annees)>0)
	@foreach($annees as $scol)
		<tr>
			<td>{{$indice++}}</td>
			<td>{{$scol->annee_sco}}</td>
			@canany(['isDirecteur','isRespsonsable'])
				<td>
					<a class="text-danger suppr_anneeSco" title="Supprimer une année scolaire" href="#" id="{{$scol->id}}"><i class="fas fa-trash-alt"></i></a>
				</td>
			@endcanany
		</tr>
	@endforeach
@else
	<tr><td colspan="3" class="text-center">Aucune année scolaire disponible</td></tr>
@endif

@if(method_exists($annees,'links'))
<div class="row col-md-12 justify-content-end">
  <div class="col-md-4 ml-auto">
    {!! $annees->links() !!}
  </div>
</div>
@endif