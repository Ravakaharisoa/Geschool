$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.change-photo').on('click',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/etudiant/photo",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });


    $('body').on('change','#img_etud',function(e){
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function(evt) {
            $('#img-upload-preview').attr('src', evt.target.result);
        };
        reader.readAsDataURL($('#img_etud')[0].files[0]);
    });

    $('body').on('click','#ajout_photo_etud',function(e) {
        e.preventDefault();
        if ($('#img_etud').val() == "") {
            swal("Attention!", "Choisissez une image!", {
                icon : "warning",
                buttons: false,
	            timer: 3000,
            });
        } else {
            var formdata = new FormData($('#form-ajout-photo')[0]);
            $.ajax({
                url:"/etudiant/update/photo",
                type:"post",
                data:formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    if (response.color=="success") {
                        $('.modalApp').modal('hide');
                        $('#profile_photo').attr('src','http://localhost:8000/assets/img/users/'+response.photo);
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
    $('.update_info').on('click',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-lg');
        $('.modal-dialog').removeClass('modal-sm');
        $.ajax({
            url:"/etudiant/editer_information",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        })
    });
    $('body').on('keyup','#nom_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#matricule_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#nom_peres',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#adresse_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#maladie_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#date_nais_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#nationalite_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#email_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#contact1_etuds',function(e) {
        $(this).removeClass('is-invalid');
    });

    $('body').on('click','.ajout_info_etud',function(e) {
        e.preventDefault();
        if($('#nom_etuds').val()=="" || $('#matricule_etuds').val()=="" || $('#nom_peres').val()=="" || $('#classe_etuds').val()=="" || $('#maladie_etuds').val()=="" || $('#sexe_etuds').val()=="" || $('#nationalite_etuds').val()=="" || $('#adresse_etuds').val()=="" || $('#date_nais_etuds').val()=="" || $('#email_etuds').val()=="" || $('#contact1_etuds').val()=="" || $('#lieu_nais_etuds').val()=="" || $('#nom_meres').val()==""){
            swal("Tous les champs continent un astérisque doivent être remplir!!", {
                buttons: false,
                timer: 5000,
            });
        }else{
            var nom = $('#nom_etuds').val();
            var matricule = $('#matricule_etuds').val();
            var pere = $('#nom_peres').val();
            var classe = $('#classe_etuds').val();
            var maladie = $('#maladie_etuds').val();
            var sexe = $('#sexe_etuds').val();
            var nationalite = $('#nationalite_etuds').val();
            var adresse = $('#adresse_etuds').val();
            var date_naiss = $('#date_nais_etuds').val();
            var email = $('#email_etuds').val();
            var contact1 = $('#contact1_etuds').val();
            var lieu_naiss = $('#lieu_nais_etuds').val();
            var mere = $('#nom_meres').val();
            var eleves_id = $('#eleves_id').val();
            var contact2 =$('#contact2_etuds').val();
            var prenom =$('#prenom_etuds').val();
            var information = $('#autre_infos').val();
            var datas = {eleves_id:eleves_id,nom:nom,matricule:matricule,pere:pere,classe:classe,maladie:maladie,sexe:sexe,nationalite:nationalite,adresse:adresse,date_naiss:date_naiss,email:email,contact1:contact1,contact2:contact2, prenom:prenom,information:information,lieu_naiss:lieu_naiss,mere:mere};
            $.ajax({
                url:"/etudiant/update_info",
                type:"post",
                data:datas,
                success:function(response) {
                    if (response.icon =="success") {
                        $('.modalApp').modal('hide');
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Succès',
                            message: response.message,
                        },{
                            type: response.icon,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                        location.reload(true);
                    } else {
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Oups!',
                            message: response.message,
                        },{
                            type: response.icon,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                }
            });
        }
    });
    $('.paye_scolarite').on('click',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/etudiant/payement/scolarite",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });
    $('.payer_cantine').on('click',function(e) {
        e.preventDefault();
        var eleve_id =$(this).attr('id');
        $('.modalApp').modal('show');
        $.ajax({
            url:"/cantines/form-payer",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });
    $('body').on('click','#paie_scolarite_etud',function(e) {
        e.preventDefault();
        var eleve_id = $('#eleve_id').val();
        var montant = $('#montant_paie').val();
        if (montant=="") {
            $('#montant_paie').addClass('is-invalid');
        } else {
            var datas={montant:montant,eleve_id:eleve_id};
            $.ajax({
                url:"/etudiant/payement_scolarite",
                type:"post",
                data:datas,
                success:function(response) {
                    if(response.icon=="success"){
                        $('.modalApp').modal('hide');
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Succès',
                            message: response.message,
                        },{
                            type: response.icon,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                        location.reload(true);
                    }else{
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Oups!',
                            message: response.message,
                        },{
                            type: response.icon,
                            placement: {
                                from: "top",
                                align: "center"
                            },
                        });
                    }
                }
            });
        }
    });

    $('body').on('change keyup','#date_cantine',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#montant_cantine',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });

    $('body').on('click','.payer_cantine_etud',function(e) {
        e.preventDefault();
        var etud_id =$('#etudiant_id').val();
        if ($('#date_cantine').val()=="") {
            $('#date_cantine').addClass('is-invalid');
        }else{
            if($('#montant_cantine').val()==""){
                $('#montant_cantine').addClass('is-invalid');
            }else{
                var date = $('#date_cantine').val();
                var montant =$('#montant_cantine').val();
                $.ajax({
                    url:"/cantines/enregitrer_payement",
                    type:"post",
                    data:{etud_id:etud_id,date:date,montant:montant},
                    success:function(response) {
                        if (response.icon=="success") {
                            $('.modalApp').modal('hide');
                            swal("Succès",response.message, {
                                icon : "success",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-success'
                                    }
                                },
                            });
                            location.reload();
                        } else {
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
        }
    });

    $('.payer_transport').on('click',function(e) {
        e.preventDefault();
        var eleve_id =$(this).attr('id');
        $('.modalApp').modal('show');
        $.ajax({
            url:"/transport/form-payer",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('keyup','#montant_trans',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });

    $('body').on('change keyup','#libelle_transp',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });

    $('body').on('click','.payer_trans_etud',function(e) {
        e.preventDefault();
        var etud_id =$('#etudiant_id').val();
        if ($('#libelle_transp').val()=="") {
            $('#libelle_transp').addClass('is-invalid');
        }else{
            if($('#montant_trans').val()==""){
                $('#montant_trans').addClass('is-invalid');
            }else{
                var mois = $('#libelle_transp').val();
                var montant =$('#montant_trans').val();
                $.ajax({
                    url:"/transport/enregitrer_transport",
                    type:"post",
                    data:{etud_id:etud_id,mois:mois,montant:montant},
                    success:function(response) {
                        if (response.icon=="success") {
                            $('.modalApp').modal('hide');
                            swal("Succès",response.message, {
                                icon : "success",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-success'
                                    }
                                },
                            });
                            location.reload();
                        } else {
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
        }
    });

});
