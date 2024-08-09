$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#uploadImg_resp").on("change", function(){
        $(this).parent('form').validate();
    });

    $('#formulaire_resp').validate({
        validClass: "success",
        rules: {
            date_emb_resp: {
                date: true,
                required:true
            },
            uploadImg_resp: {
                required: true,
            },
            adresse_resp:{
                required: true
            },
            cin_resp:{
                required: true,
                number:true,
                minlength:12,
                maxlength:12
            },
            nationalite_resp:{
                required:true
            },
        },
        messages: {
            uploadImg_resp: {
              required: "Choisissez votre photo!",
            },
            adresse_resp:"Veuillez entrer votre adresse!",
            cin_resp:{
                required:"Veuiller saisir votre numéro de CIN!",
                number:"Le numéro de CIN doit être en chiffre!",
                minlength:"Le numéro de CIN doit contenir 12 chiffres minimum",
                maxlength:"Le numéro de CIN doit contenir 12 chiffres maximum",
            },
            nationalite_resp:"Veuillez entrer votre nationalité!",
            date_emb_resp:{
                required:"La date d'embauche doit être remplir",
                date:"Veuillez entrer une date correcte!"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var formData = new FormData(form);
            $.ajax({
                url: "/config/information",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
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
            });
        }
    });

    $("#uploadImg_prof").on("change", function(){
        $(this).parent('form').validate();
    })

    $('#formulaire_prof').validate({
        validClass: "success",
        rules: {
            date_emb_prof: {
                date: true,
                required:true
            },
            uploadImg_resp: {
                required: true,
            },
            adresse_prof:{
                required: true
            },
            nationalite_prof:{
                required:true
            },
            cin_prof:{
                required: true,
                number:true,
                minlength:12,
                maxlength:12
            },
        },
        messages: {
            uploadImg_prof: {
              required: "Choisissez votre photo!",
            },
            adresse_prof:"Veuillez entrer votre adresse!",
            cin_prof:{
                required:"Veuiller saisir votre numéro de CIN!",
                number:"Le numéro de CIN doit être en chiffre!",
                minlength:"Le numéro de CIN doit contenir 12 chiffres minimum",
                maxlength:"Le numéro de CIN doit contenir 12 chiffres maximum",
            },
            nationalite_prof:"Veuillez entrer votre nationalité!",
            date_emb_prof:{
                required:"La date d'embauche doit être remplir",
                date:"Veuillez entrer une date correcte!"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var formData = new FormData(form);
            $.ajax({
                url: "/configuration/information",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
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
            });
        }
    });

    $('.update_phot_profile').on('click',function(e){
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/responsable/photo_profile",
            type:"get",
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('change','#img_resp',function(e){
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function(evt) {
            $('#img-upload-preview').attr('src', evt.target.result);
        };
        reader.readAsDataURL($('#img_resp')[0].files[0]);
    });

    $('body').on('click','#ajout_photo_resp',function(e) {
        e.preventDefault();
        if ($('#img_resp').val() == "") {
            swal("Attention!", "Choisissez une image!", {
                icon : "warning",
                buttons: false,
	            timer: 3000,
            });
        } else {
            var formdata = new FormData($('#forms-ajouts-photo')[0]);
            $.ajax({
                url:"/responsable/update/profile",
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

    $('#form_update_info_resp').validate({
        validClass: "success",
        rules: {
            update_nom_resp: {
                required:true
            },
            update_nationalite_resp: {
                required: true,
            },
            update_sexe_resp:{
                required: true
            },
            update_contact1_resp:{
                required:true,
                minlength:10,
                maxlength:14
            },
            update_cin_resp:{
                required: true,
                number:true,
                minlength:12,
                maxlength:12
            },
            update_email_resp:{
                required:true,
                email:true
            },
            update_adresse_resp:{
                required:true
            },
            update_date_emb_resp:{
                required:true,
                date:true
            }
        },
        messages: {
            update_nom_resp: {
              required: "Veuillez saisir votre nom!",
            },
            update_contact1_resp:{
                required:"Veuillez entrer votre numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
            update_adresse_resp:"Veuillez entrer votre adresse!",
            update_cin_resp:{
                required:"Veuiller saisir votre numéro de CIN!",
                number:"Le numéro de CIN doit être en chiffre!",
                minlength:"Le numéro de CIN doit contenir 12 chiffres minimum",
                maxlength:"Le numéro de CIN doit contenir 12 chiffres maximum",
            },
            update_sexe_resp:"Veuillez séléctionner votre sexe",
            update_nationalite_resp:"Veuillez entrer votre nationalité!",
            update_date_emb_resp:{
                required:"La date d'embauche doit être remplir",
                date:"Veuillez entrer une date correcte!"
            },
            update_email_resp:{
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
            var nom= $('#update_nom_resp').val();
            var prenom= $('#update_prenom_resp').val();
            var nationalite = $('#update_nationalite_resp').val();
            var sexe= $('#update_sexe_resp').val();
            var contact1= $('#update_contact1_resp').val();
            var contact2= $('#update_contact2_resp').val();
            var email= $('#update_email_resp').val();
            var adresse= $('#update_adresse_resp').val();
            var cin= $('#update_cin_resp').val();
            var date_embauche= $('#update_date_emb_resp').val();

            var donnees = {nom:nom,prenom:prenom,nationalite:nationalite,sexe:sexe,contact1:contact1,contact2:contact2,email:email,adresse:adresse,cin:cin,date_embauche:date_embauche};
            $.ajax({
                url:"/responsable/update/information",
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

    $("#uploadImg_etud").on("change", function(){
        $(this).parent('form').validate();
    })

    $('#formulaire_etud_info').validate({
        validClass: "success",
        rules: {
            lieu_naiss: {
                required:true
            },
            uploadImg_etud: {
                required: true,
            },
        },
        messages: {
            uploadImg_prof: {
              required: "Choisissez votre photo!",
            },
            lieu_naiss:"Veuillez entrer votre lieu de naisssance!",
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var formData = new FormData(form);
            $.ajax({
                url: "/profile/configuration",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
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
            });
        }
    });

    $('.update_imag_profile').on('click',function(e) {
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/profile/photo",
            type:"get",
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('change','#img_etudiant',function(e){
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function(evt) {
            $('#img-upload-preview').attr('src', evt.target.result);
        };
        reader.readAsDataURL($('#img_etudiant')[0].files[0]);
    });

    $('body').on('click','#ajout_photo_etudiant',function(e) {
        e.preventDefault();
        if ($('#img_etudiant').val() == "") {
            swal("Attention!", "Choisissez une image!", {
                icon : "warning",
                buttons: false,
	            timer: 3000,
            });
        } else {
            var formdata = new FormData($('#forms_ajout_photos')[0]);
            $.ajax({
                url:"/profile/updated",
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

    $('#form_update_info_etud').validate({
        validClass: "success",
        rules: {
            update_nom_etud: {
                required:true
            },
            update_nationalite_etud:{
                required:true
            },
            update_sexe_etud:{
                required:true
            },
            update_contact1_etud:{
                required:true,
                minlength:10,
                maxlength:14
            },
            update_email_etud:{
                required:true,
                email:true
            },
            update_adresse_etud:{
                required:true
            },
            update_datenaiss_etud:{
                required:true,
                date:true
            },
            update_lieuNaiss_etud:{
                required:true
            }
        },
        messages: {
            update_nom_etud:"Veuillez saisir votre nom!",
            update_nationalite_etud:"Veuillez entrer votre nationalité!",
            update_sexe_etud:"Veuillez séléctionner votre sexe",
            update_contact1_etud:{
                required:"Veuillez entrer votre numéro de téléphone",
                minlength:"Le numéro téléphone doit être 10 caractères minimum",
                maxlength:"Le numéro téléphone doit être 14 caractères maximum"
            },
            update_email_etud:{
                email:"Saisissez votre adresse email correcte",
                required:"On doit entrer un adresse email"
            },
            update_adresse_etud:"Veuillez entrer votre adresse!",
            update_datenaiss_etud:{
                required:"Veuillez remplir votre date de naissance",
                date:"Veuillez entrer une date correcte!"
            },
            update_lieuNaiss_etud:"Veuillez saisir votre lieu de naissance",
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form){
            var nom= $('#update_nom_etud').val();
            var prenom= $('#update_prenom_etud').val();
            var nationalite = $('#update_nationalite_etud').val();
            var sexe= $('#update_sexe_etud').val();
            var contact1= $('#update_contact1_etud').val();
            var contact2= $('#update_contact2_etud').val();
            var email= $('#update_email_etud').val();
            var adresse= $('#update_adresse_etud').val();
            var dateNaiss= $('#update_datenaiss_etud').val();
            var lieuNaiss= $('#update_lieuNaiss_etud').val();
            var datas ={nom:nom,prenom:prenom,nationalite:nationalite,sexe:sexe,contact1:contact1,contact2:contact2,email:email,adresse:adresse,dateNaiss:dateNaiss,lieuNaiss:lieuNaiss};

            $.ajax({
                url: "/profile/modifier/information",
                type: 'POST',
                data: datas,
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
