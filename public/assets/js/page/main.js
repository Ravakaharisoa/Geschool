$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#formulaire_prof').validate({
        validClass : "success",
        rules:{
            nom:"required",
            adresse:"required",
            sexe:"required",
            matricule:"required",
            date_embauche:{
                date:true,
                required:true
            },
            contrat:"required",
            email:{
                email:true,
                required:true
            },
            contact1:{
                required:true,
                minlength:10,
                maxlength:14
            },
        },
        messages:{
            nom:"Veuillez entrer le nom du professeur",
            adresse:"Saisissez son adresse",
            sexe:"Choisissez son sexe",
            matricule:"Veuillez entrer son matricule",
            email:{
                email:"Saisissez un adresse email correcte",
                required:"On doit entrer un adresse email"
            },
            contrat:"Veuillez entrer son type de contrat",
            date_embauche:{
                date:"Veullez entrer un date correcte",
                required:"On doit entrer une date"
            },
            contact1:{
                required:"On doit entrer un numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            var nom= $('#nom_prof').val();
            var prenom= $('#prenom_prof').val();
            var adresse= $('#adresse_prof').val();
            var sexe= $('#sexe_prof').val();
            var matricule= $('#matricule_prof').val();
            var date_embauche= $('#date_embauche_prof').val();
            var email= $('#email_prof').val();
            var contact1= $('#contact1_prof').val();
            var contact2= $('#contact2_prof').val();
            var contrat = $('#contrat').val();

            var datas = {nom:nom,prenom:prenom,adresse:adresse,sexe:sexe,matricule:matricule,date_embauche:date_embauche,email:email,contact1:contact1,contact2:contact2,contrat:contrat};
            $.ajax({
                url:"/professeur/ajouter/professeurs",
                type:"POST",
                data:datas,
                success:function(response){
                    if (response.color == "success") {
                        window.location.href ="/professeur/liste";
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
                    } else {
                        swal("Erreur", response.message, {
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

    $('.restaure_professeur').on('click',function(e) {
        e.preventDefault();
        var prof_id = $(this).attr('id');
        swal({
            title: 'Etes-vous sûre?',
            text: "Voulez-vous vraiement le restaurer?",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Oui',
                    className : 'btn btn-success'
                },
                cancel: {
                    text : 'Non!',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url:"/professeur/restaurer",
                    type:"post",
                    data:{prof_id:prof_id},
                    success:function(response) {
                        if (response.icon =="success") {
                            swal(response.message, {
                                icon: "success",
                                buttons : {
                                    confirm : {
                                        className: 'btn btn-success'
                                    }
                                }
                            });
                            location.reload();
                        } else {
                            swal(response.message, {
                                icon: "error",
                                buttons : {
                                    confirm : {
                                        className: 'btn btn-danger'
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                swal.close();
            }
        });
    });
    $('.delete_professeur').on('click',function(e) {
        e.preventDefault();
        var prof_id = $(this).attr('id');
        swal({
            title: 'Etes-vous sûre?',
            text: "Voulez-vous vraiement le supprimer?",
            type: 'warning',
            buttons:{
                confirm: {
                    text : 'Oui',
                    className : 'btn btn-success'
                },
                cancel: {
                    text : 'Non!',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url:"/professeur/supprimer",
                    type:"post",
                    data:{prof_id:prof_id},
                    success:function(response) {
                        if (response.icon =="success") {
                            swal(response.message, {
                                icon: "success",
                                buttons : {
                                    confirm : {
                                        className: 'btn btn-success'
                                    }
                                }
                            });
                            location.reload();
                        } else {
                            swal(response.message, {
                                icon: "error",
                                buttons : {
                                    confirm : {
                                        className: 'btn btn-danger'
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                swal.close();
            }
        });
    });

    $('#form_responsable').validate({
        validClass : "success",
        rules:{
            nom_resp:"required",
            adresse_resp:"required",
            sexe_resp:"required",
            matricule_resp:"required",
            fonction_resp:"required",
            date_embauche_resp:{
                date:true,
                required:true
            },
            contrat_resp:"required",
            email_resp:{
                email:true,
                required:true
            },
            contact1_resp:{
                required:true,
                minlength:10,
                maxlength:14
            },
        },
        messages:{
            nom_resp:"Veuillez entrer le nom du responsable",
            adresse_resp:"Saisissez son adresse",
            sexe_resp:"Choisissez son sexe",
            matricule_resp:"Veuillez entrer son matricule",
            email_resp:{
                email:"Saisissez un adresse email correcte",
                required:"On doit entrer un adresse email"
            },
            contrat_resp:"Veuillez entrer son type de contrat",
            date_embauche_resp:{
                date:"Veullez entrer un date correcte",
                required:"On doit entrer une date"
            },
            fonction_resp:"Veuillez entrer sa fonction",
            contact1_resp:{
                required:"On doit entrer un numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            var nom= $('#nom_resp').val();
            var prenom= $('#prenom_resp').val();
            var adresse= $('#adresse_resp').val();
            var sexe= $('#sexe_resp').val();
            var matricule= $('#matricule_resp').val();
            var fonction =$('#fonction_resp').val();
            var date_embauche= $('#date_embauche_resp').val();
            var email= $('#email_resp').val();
            var contact1= $('#contact1_resp').val();
            var contact2= $('#contact2_resp').val();
            var contrat = $('#contrat_resp').val();

            var datas = {nom:nom,prenom:prenom,adresse:adresse,sexe:sexe,matricule:matricule,date_embauche:date_embauche,fonction:fonction,email:email,contact1:contact1,contact2:contact2,contrat:contrat};
            $.ajax({
                url:"/responsable/ajouter",
                type:"POST",
                data:datas,
                success:function(response){
                    if (response.color == "success") {
                        window.location.href ="/responsable/liste";
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
                    } else {
                        swal("Erreur", response.message, {
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

    $('#choix-classe').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $.ajax({
            url:"/eleves/listes/par_classes",
            type:"POST",
            data:{classe_id:classe_id},
            success:function(response) {
                $('#table-liste-eleve').empty().append(response);
            }
        })
    });

    $('.update_phot_profile').on('click',function(e) {
        e.preventDefault();
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/directeur/photo_profile",
            type:"get",
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('change','#img_directeur',function(e){
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function(evt) {
            $('#img-upload-preview').attr('src', evt.target.result);
        };
        reader.readAsDataURL($('#img_directeur')[0].files[0]);
    });

    $('body').on('click','#ajout_photo_directeur',function(e) {
        e.preventDefault();
        if ($('#img_directeur').val() == "") {
            swal("Attention!", "Choisissez une image!", {
                icon : "warning",
                buttons: false,
	            timer: 3000,
            });
        } else {
            var formdata = new FormData($('#forms_ajout_photo')[0]);
            $.ajax({
                url:"/directeur/update/profile",
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

    $('#form_update_password').validate({
        validClass:"success",
        rules:{
            mdp_resp:{
                required:true,
                minlength:4
            },
            mdp_conf_resp:{
                equalTo: "#mdp_resp"
            }
        },
        messages:{
            mdp_resp:{
                required: "Veuillez saisir votre nouveau mot de passe!",
                minlength:"Le mot de passe doit être au moins 4 caractères",
            },
            mdp_conf_resp:{
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
            var pwd = $('#mdp_resp').val();
            $.ajax({
                url:"/directeur/update_password",
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

    

    $('#form_update_info_dir').validate({
        validClass: "success",
        rules: {
            nom_directeur: {
                required:true
            },
            contact_directeur:{
                required:true,
                minlength:10,
                maxlength:14
            },
            email_directeur:{
                required:true,
                email:true
            },
        },
        messages: {
            nom_directeur: {
              required: "Veuillez saisir votre nom!",
            },
            contact_directeur:{
                required:"Veuillez entrer votre numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
            email_directeur:{
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
            var nom= $('#nom_directeur').val();
            var contact= $('#contact_directeur').val();
            var email= $('#email_directeur').val();

            var donnees = {nom:nom,contact:contact,email:email};
            $.ajax({
                url:"/directeur/update/information",
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
});
