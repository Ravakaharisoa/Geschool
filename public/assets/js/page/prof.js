$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#choix-classe').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $.ajax({
            url:"/eleves/liste/par_classe",
            type:"POST",
            data:{classe_id:classe_id},
            success:function(response) {
                $('#table-liste-eleve').empty().append(response);
            }
        })
    });
    $('body').on('click','.notif_abs',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').removeClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/eleves/abscence",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('keyup','#date_abs',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('keyup','#cours',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('keyup','#note_etud',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('change','#coefficient',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('change','#matiere_id',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('change','#module_id',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#date_eval',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('change','#type_exam',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('click','#note_abscence_etud',function(e) {
        e.preventDefault();
        var etud_id = $('#eleve_id').val();
        if ($('#date_abs').val()=="") {
            $('#date_abs').addClass('is-invalid');
        }else if($('#cours').val()==""){
            $('#cours').addClass('is-invalid');
        } else {
            var date_abs = $('#date_abs').val();
            var cour_id = $('#cours').val();
            $.ajax({
                url:"/eleves/enregistrer_abscence",
                type:"post",
                data:{etud_id:etud_id,date_abs:date_abs,cour_id:cour_id},
                success:function(response) {
                    if(response.type=="success"){
                        $('.modalApp').modal('hide');
                        swal("Succès",response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                    }else{
                        swal("Attention!",response.message, {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
                }
            });
        }
    });

    $('body').on('click','.ajouter_note',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').removeClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/eleves/form_add_note",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });
    $('body').on('click','#ajouter_note_etud',function(e) {
        e.preventDefault();
        if ($('#note_etud').val()=="") {
            $('#note_etud').addClass('is-invalid');
        }else if($('#coefficient').val()==""){
            $('#coefficient').addClass('is-invalid');
        }else if($('#matiere_id').val()==""){
            $('#matiere_id').addClass('is-invalid');
        }else if($('#module_id').val()==""){
            $('#module_id').addClass('is-invalid');
        }else if($('#date_eval').val()==""){
            $('#date_eval').addClass('is-invalid');
        }else if($('#type_exam').val()==""){
            $('#type_exam').addClass('is-invalid');
        }else{
            var etud = $('#etudiant_id').val();
            var note = $('#note_etud').val();
            var matiere = $('#matiere_id').val();
            var date_eval =$('#date_eval').val();
            var coefficient = $('#coefficient').val();
            var module = $('#module_id').val();
            var type_exam = $('#type_exam').val();
            var datas = {etud:etud,note:note,matiere:matiere,date_eval:date_eval,coefficient:coefficient,module:module,type_exam:type_exam};
            $.ajax({
                url:"/eleves/add_note",
                type:"post",
                data:datas,
                success:function(response) {
                    if(response.type=="success"){
                        $('.modalApp').modal('hide');
                        swal("Succès",response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                    }else{
                        swal("Attention!",response.message, {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
                }
            });
        }
    });

    $('#choix_classe').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $('#matricule_eleve').removeClass('fade');
        $.ajax({
            url:"/notes/select_matricule",
            type:"post",
            data:{classe_id:classe_id},
            success:function(response) {
                var data ='<option hidden selected>Choix</option>';
                $.each(response,function(key,value) {
                    data = data+'<option value="'+value.id+'">'+value.matricule+'</option>';
                });
                $('#choix_matricule').empty().append(data);
            }
        });
    });
    $('#choix_matricule').on('change',function(e) {
        e.preventDefault();
        var etud_id = $(this).val();
        $.ajax({
            url:"/notes/details",
            type:"post",
            data:{etud_id:etud_id},
            success:function(response) {
                $('#table_liste_eleve').empty().append(response);
            }
        });
    });

    $('.update_phot_profile').on('click',function(e){
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/profile/photo_profile",
            type:"get",
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('change','#img_professeur',function(e){
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function(evt) {
            $('#img-upload-preview').attr('src', evt.target.result);
        };
        reader.readAsDataURL($('#img_professeur')[0].files[0]);
    });

    $('body').on('click','#ajout_photo_prof',function(e) {
        e.preventDefault();
        if ($('#img_professeur').val() == "") {
            swal("Attention!", "Choisissez une image!", {
                icon : "warning",
                buttons: false,
	            timer: 3000,
            });
        } else {
            var formdata = new FormData($('#forms_ajout_photo')[0]);
            $.ajax({
                url:"/profile/update",
                type:"post",
                data:formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    if (response.color=="success") {
                        $('.modalApp').modal('hide');
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Succès',
                            message: response.message,
                        },{
                            type: 'success',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                            time: 1000,
                        });
                        location.reload();
                    } else {
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Information',
                            message: response.message,
                        },{
                            type: 'danger',
                            placement: {
                                from: "top",
                                align: "center"
                            },
                            time: 1000,
                        });
                    }
                }
            });
        }

    });

    $('#form_update_info_prof').validate({
        validClass: "success",
        rules: {
            nom_prof: {
                required:true
            },
            nationalite_prof: {
                required: true,
            },
            sex:{
                required: true
            },
            contact1_prof:{
                required:true,
                minlength:10,
                maxlength:14
            },
            cin_prof:{
                required: true,
                number:true,
                minlength:12,
                maxlength:12
            },
            email_prof:{
                required:true,
                email:true
            },
            adresse_prof:{
                required:true
            },
            date_emb_prof:{
                required:true,
                date:true
            }
        },
        messages: {
            nom_prof: {
              required: "Veuillez saisir votre nom!",
            },
            contact1_prof:{
                required:"Veuillez entrer votre numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
            adresse_prof:"Veuillez entrer votre adresse!",
            cin_prof:{
                required:"Veuiller saisir votre numéro de CIN!",
                number:"Le numéro de CIN doit être en chiffre!",
                minlength:"Le numéro de CIN doit contenir 12 chiffres minimum",
                maxlength:"Le numéro de CIN doit contenir 12 chiffres maximum",
            },
            sex:"Veuillez séléctionner votre sexe",
            nationalite_prof:"Veuillez entrer votre nationalité!",
            date_emb_prof:{
                required:"La date d'embauche doit être remplir",
                date:"Veuillez entrer une date correcte!"
            },
            email_prof:{
                email:"Saisissez votre adresse email correcte",
                required:"On doit entrer un adresse email"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var nom= $('#nom_prof').val();
            var prenom= $('#prenom_prof').val();
            var nationalite = $('#nationalite_prof').val();
            var sexe= $('#sex').val();
            var contact1= $('#contact1_prof').val();
            var contact2= $('#contact2_prof').val();
            var email= $('#email_prof').val();
            var adresse= $('#adresse_prof').val();
            var cin= $('#cin_prof').val();
            var date_embauche= $('#date_emb_prof').val();

            var donnees = {nom:nom,prenom:prenom,nationalite:nationalite,sexe:sexe,contact1:contact1,contact2:contact2,email:email,adresse:adresse,cin:cin,date_embauche:date_embauche};
            $.ajax({
                url:"/profile/update/information",
                type:"post",
                data:donnees,
                success:function(response) {
                    if (response.icone =="success") {
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
                        location.reload();
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

    $('#update_pwd_prof').validate({
        validClass:"success",
        rules:{
            mdp_prof:{
                required:true,
                minlength:4
            },
            mdp_conf_prof:{
                equalTo: "#mdp_prof"
            }
        },
        messages:{
            mdp_prof:{
                required: "Veuillez saisir votre nouveau mot de passe!",
                minlength:"Le mot de passe doit être au moins 4 caractères",
            },
            mdp_conf_prof:{
                required:"Veuillez confirmer votre mot de passe !",
                equalTo: "Le mot de passe confirmé doit être égal au nouveau mot de passe !"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var pwd = $('#mdp_prof').val();
            $.ajax({
                url:"/configuration/update_password",
                type:"post",
                data:{ pwd:pwd },
                success:function(response) {
                    if (response.icon =="success") {
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
                        location.reload();
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
            })
        }
    });
});
