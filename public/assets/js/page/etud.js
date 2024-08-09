$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#choix_module').on('change',function(e) {
        e.preventDefault();
        var module_id = $(this).val();
        $('#matricule_eleve').removeClass('fade');
        $.ajax({
            url:"/classes/detils/note",
            type:"post",
            data:{module_id:module_id},
            success:function(response) {
                $('#table_liste_eleve').empty().append(response);
            }
        });
    });
});
