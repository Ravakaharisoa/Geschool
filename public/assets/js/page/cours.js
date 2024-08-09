$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#form_save_cours').validate({
        validClass: "success",
        rules: {
            heure_debut: {
                required:true
            },
            heure_fin: {
                required: true,
            },
            jour:{
                required: true
            },
            classe_id:{
                required: true,
            },
            matiere_id:{
                required:true
            },
        },
        messages: {
            heure_debut: {
              required: "Entrez l'heure début du cour!",
            },
            heure_fin:{
                required:"Entrez l'heure fin du cour!",
            },
            jour:"Veuillez séléctionner un jour!",
            classe_id:"Veuillez séléctionner une classe",
            matiere_id:"Veuillez séléctionner une matière"
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var heure_debut =$('#heure_debut').val();
            var heure_fin =$('#heure_fin').val();
            var jour= $('#jour').val();
            var classe_id= $('#classe_id').val();
            var matiere_id=$('#matiere_id').val();
            var datas={heure_debut:heure_debut,heure_fin:heure_fin,jour:jour,classe_id:classe_id,matiere_id:matiere_id};
            $.ajax({
                url:"/cour/enregistrer",
                type:"post",
                data:datas,
                success:function(response) {
                    if (response.type =="success") {
                        $(form)[0].reset();
                        $('.form-control').closest('.form-group').removeClass('has-error').removeClass('has-success');
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Succès',
                            message: response.message,
                        },{
                            type: 'success',
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            time: 1000,
                        });
                        listeCoursDisponible();
                    } else {
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Information',
                            message: response.message,
                        },{
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            time: 1000,
                        });
                    }
                }
            });
        }
    });
    listeCoursDisponible();
    function listeCoursDisponible() {
        $.ajax({
            url:"/cour/liste/disponible",
            type:"get",
            async: false,
            success:function(response){
                $('#liste_cours').empty().append(response);
            }
        });
    }
    
});
