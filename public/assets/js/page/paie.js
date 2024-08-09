$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#choix_classes').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $('#matricules_eleve').removeClass('fade');
        $.ajax({
            url:"/transport/select_matricule",
            type:"post",
            data:{classe_id:classe_id},
            success:function(response) {
                var data ='<option value="null">Choix</option>';
                $.each(response,function(key,value) {
                    data = data+'<option value="'+value.id+'">'+value.matricule+'</option>';
                });
                $('#choix_matricules').empty().append(data);
            }
        });
    });
    $('#choix_classe_etud').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $('#matricule_etud').removeClass('fade');
        $.ajax({
            url:"/scolarite/select_matricule",
            type:"post",
            data:{classe_id:classe_id},
            success:function(response) {
                var data ='<option value="null">Choix</option>';
                $.each(response,function(key,value) {
                    data = data+'<option value="'+value.id+'">'+value.matricule+'</option>';
                });
                $('#choix_matricule_etud').empty().append(data);
            }
        });
    });
    $('#choix_classe').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $('#matricule_eleve').removeClass('fade');
        $.ajax({
            url:"/cantines/select_matricule",
            type:"post",
            data:{classe_id:classe_id},
            success:function(response) {
                var data ='<option value="null">Choix</option>';
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
        getListePayement(etud_id);
    });
    $('#choix_matricule_etud').on('change',function(e) {
        e.preventDefault();
        var etud_id = $(this).val();
        getListeScolarite(etud_id);
    });
    $('#choix_matricules').on('change',function(e) {
        e.preventDefault();
        var etud_id = $(this).val();
        getListePayementTransport(etud_id);
    });
    $('body').on('click','.payer_cantine',function(e) {
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
    $('body').on('click','.payer_transport',function(e) {
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
    $('body').on('click','.payer_scolarite',function(e) {
        e.preventDefault();
        var eleve_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/scolarite/form-payer",
            type:"post",
            data:{eleve_id:eleve_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });
    $('body').on('change keyup','#date_cantine',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#montant_cantine',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('change keyup','#libelle_transp',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('change keyup','#montant_paie',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#montant_trans',function(e) {
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
                            getListePayement(etud_id);
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
                            getListePayementTransport(etud_id);
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

    $('body').on('click','#paie_scolarite_etud',function(e) {
        e.preventDefault();
        var eleve_id = $('#eleve_id').val();
        var montant = $('#montant_paie').val();
        if (montant=="") {
            $('#montant_paie').addClass('is-invalid');
        } else {
            var datas={montant:montant,eleve_id:eleve_id};
            $.ajax({
                url:"/scolarite/payement_scolarite",
                type:"post",
                data:datas,
                success:function(response) {
                    if(response.icon=="success"){
                        $('.modalApp').modal('hide');
                        swal("Succès",response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        getListeScolarite(eleve_id);
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
    function getListePayementTransport(etud_id) {
        $.ajax({
            url:"/transport/afficher_eleves",
            type:"post",
            data:{etud_id:etud_id},
            success:function(response) {
                $('#table_listes_eleves').empty().append(response);
            }
        });
    }

    function getListeScolarite(etud_id){
        $.ajax({
            url:"/scolarite/afficher_eleves",
            type:"post",
            data:{etud_id:etud_id},
            success:function(response) {
                $('#tables_liste_eleve').empty().append(response);
            }
        });
    }

    function getListePayement(etud_id) {
        $.ajax({
            url:"/cantines/afficher_eleves",
            type:"post",
            data:{etud_id:etud_id},
            success:function(response) {
                $('#table_liste_eleve').empty().append(response);
            }
        });
    }
    $('#affiche_det').on('click',function(e) {
        e.preventDefault();
        var date_debut = $('#date_debut').val();
        var date_fin = $('#date_fin').val();
        var classes =$('#classes').val();
        $.ajax({
            url:"/cantines/details",
            type:"post",
            data:{date_debut:date_debut,date_fin:date_fin,classes:classes},
            success:function(response){
                $('#liste_details_cantine').empty().append(response);
            }
        });
    });
    $('#affiche_details').on('click',function(e) {
        e.preventDefault();
        var mois_debut = $('#mois_debuts').val();
        var classes =$('#classe').val();
        $.ajax({
            url:"/transport/details",
            type:"post",
            data:{mois_debut:mois_debut,classes:classes},
            success:function(response){
                $('#liste_details_transport').empty().append(response);
            }
        });
    });
});
