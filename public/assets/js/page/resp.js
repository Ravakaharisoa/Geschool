$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', '.suppr_resp', function (e) {
        e.preventDefault();
        var resp_id = $(this).attr('id');
        swal({
            title: 'Etes-vous sûre?',
            text: "Voulez-vous vraiement le supprimer?",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Oui',
                    className: 'btn btn-success'
                },
                cancel: {
                    text: 'Non!',
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: "/responsable/supprimer",
                    type: "post",
                    data: { resp_id: resp_id },
                    success: function (response) {
                        if (response.icon == "success") {
                            swal(response.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: 'btn btn-success'
                                    }
                                }
                            });
                            location.reload();
                        } else {
                            swal(response.message, {
                                icon: "error",
                                buttons: {
                                    confirm: {
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
    $('#form-inscription').validate({
        validClass: "success",
        rules: {
            nom_etud: {
                required: true
            },
            maladie_etud: {
                required: true
            },
            contact1_etud: {
                required: true,
                maxlength: 13,
                minlength: 13
            },
            classe_etud: {
                required: true
            },
            nom_pere: {
                required: true
            },
            contact2_etud: {
                maxlength: 13,
                minlength: 13
            },
            matricule_etud: {
                required: true
            },
            sexe_etud: {
                required: true
            },
            nationalite_etud: {
                required: true
            },
            nom_mere: {
                required: true
            },
            date_nais_etud: {
                required: true,
                date: true
            },
            adresse_etud: {
                required: true
            },
            email_etud: {
                email: true,
                required: true
            },
        },
        messages: {
            nom_etud: "Veuillez entrer le nom d'étudiant",
            maladie_etud: "Veuillez entrer la maladie d'étudiant",
            contact1_etud: {
                required: "Veuillez saisir un numéro de télephone de ses parents",
                maxlength: "Le numéro du téléphone doit être 13 chiffres maximum",
                minlength: "Le numéro du téléphone doit être 13 chiffres minimum"
            },
            matricule_etud: "Veuillez entrer le numéro de matricule",
            classe_etud: "Veuillez choisir une classe",
            nom_pere: "Veuillez entrer le nom de son père",
            contact2_etud: {
                maxlength: "Le numéro du téléphone doit être 13 chiffres maximum",
                minlength: "Le numéro du téléphone doit être 13 chiffres minimum"
            },
            sexe_etud: "Veuillez choisir le sexe d'étudiant",
            nationalite_etud: "Entrez sa nationalité",
            nom_mere: "Veuillez entrer le nom de sa mère",
            date_nais_etud: {
                date: "Veullez entrer un date correcte",
                required: "On doit entrer sa date de naissance"
            },
            adresse_etud: "Saisissez l'adresse d'étudiant",
            contact1: {
                required: "On doit entrer un numéro de téléphone",
                minlength: "Le numéro téléphone doit être 10 caractères minimum",
                maxlength: "Le numéro téléphone doit être 14 caractères maximum"
            },
            email_etud: {
                email: "Entrer une adresse email correcte",
                required: "Ce champ doit être remplir"
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function (form) {
            var nom = $('#nom_etud').val();
            var matricule = $('#matricule_etud').val();
            var maladie = $('#maladie_etud').val();
            var contact1 = $('#contact1_etud').val();
            var prenom = $('#prenom_etud').val();
            var classe = $('#classe_etud').val();
            var pere = $("#nom_pere").val();
            var contact2 = $('#contact2_etud').val();
            var sexe = $('#sexe_etud').val();
            var nationalite = $('#nationalite_etud').val();
            var mere = $('#nom_mere').val();
            var reduction = $('#reduction_etud').val();
            var date_naissance = $('#date_nais_etud').val();
            var adresse =$('#adresse_etud').val();
            var email = $('#email_etud').val();
            var info = $('#autre_info').val();
            var datas ={nom:nom,matricule:matricule,maladie:maladie,contact1:contact1,prenom:prenom,classe:classe,pere:pere,contact2:contact2,sexe:sexe,nationalite:nationalite,mere:mere,reduction:reduction,date_naissance:date_naissance,adresse:adresse,email:email,info:info};
            $.ajax({
                url:"/etudiant/add_etudiant",
                type:"post",
                data:datas,
                success:function(response) {
                    if (response.color == "success") {
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
    // $('.telephone').mask('+261 32 000 00');
    // $('#nom_etud').autocomplete({
    //     source: function( request, response ) {
    //         $.ajax({
    //             url: "/etudiant/informations",
    //             type: 'GET',
    //             dataType: "json",
    //             data: {
    //                 search: request.term
    //             },
    //             success: function( data ) {
    //                 response( data );
    //             }
    //         });
    //     },
    //     autofocus: true ,
    //     // appendTo:"#voir_devis",
    //     select: function (event, ui) {
    //         console.log(ui);
    //         // valeurInput();
    //         return false;
    //     }
    // });

    $('#choix-classe').on('change',function(e) {
        e.preventDefault();
        var classe_id = $(this).val();
        $.ajax({
            url:"/etudiant/liste/par_classe",
            type:"POST",
            data:{classe_id:classe_id},
            success:function(response) {
                $('#table-liste-eleve').empty().append(response);
            }
        })
    });
    $('#affiche_det_abs').on('click',function(e) {
        e.preventDefault();
        var date_debut = $('#date_debut').val();
        var date_fin = $("#date_fin").val();
        $.ajax({
            url:"/fiche/liste_eleve",
            type:"POST",
            data:{date_debut:date_debut,date_fin:date_fin},
            success:function(response) {
                $('#liste_abscences').empty().append(response);
                $('.motif_abs').on('click',function name(e) {
                    e.preventDefault();
                    var abs_id = $(this).attr('id');
                    $('.modalApp').modal('show');
                    $('.modal-dialog').addClass('modal-sm');
                    $('.modal-dialog').removeClass('modal-lg');
                    $.ajax({
                        url:"/fiche/form-update-abscence",
                        type:"post",
                        data:{abs_id:abs_id},
                        success:function(response) {
                            $('#modal_content').empty().append(response);
                        }
                    });
                });
            }
        });
    });

    function fiche_abscence_etudiant() {
        $.ajax({
            url:"/fiche/liste-abscence",
            type:"GET",
            success:function(response) {
                $('#liste_abscences').empty().append(response);
                $('.motif_abs').on('click',function name(e) {
                    e.preventDefault();
                    var abs_id = $(this).attr('id');
                    $('.modalApp').modal('show');
                    $('.modal-dialog').addClass('modal-sm');
                    $('.modal-dialog').removeClass('modal-lg');
                    $.ajax({
                        url:"/fiche/form-update-abscence",
                        type:"post",
                        data:{abs_id:abs_id},
                        success:function(response) {
                            $('#modal_content').empty().append(response);
                        }
                    });
                });
            }
        });
    }


    $('.motif_abs').on('click',function name(e) {
        e.preventDefault();
        var abs_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $('.modal-dialog').removeClass('modal-lg');
        $.ajax({
            url:"/fiche/form-update-abscence",
            type:"post",
            data:{abs_id:abs_id},
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('click','.ajout_motif',function(e) {
        e.preventDefault();
        var abs_id =$('#abs_id').val();
        var motif =$('#motif_abs').val();
        if(motif==""){
            $('#motif_abs').addClass('is-invalid');
        }else{
            $.ajax({
                url:"/fiche/ajout-motif",
                type:"post",
                data:{abs_id:abs_id,motif:motif},
                success:function(response) {
                    if(response.icon == "success"){
                        $('.modalApp').modal('hide');
                        swal("Succès",response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        fiche_abscence_etudiant();
                    }else{
                        swal("Attention!",response.message, {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-'+response.color
                                }
                            },
                        });
                    }

                }
            });
        }
    });

    $('#details_note_module').on('click',function(e) {
        e.preventDefault();
        var classe_id = $('.classe_etudiant').val();
        var module_id = $('.module_dispo').val();
        if (classe_id=="" || module_id=="") {
            $.notify({
                icon: 'flaticon-alarm-1',
                title: 'Erreur',
                message: "Veuillez choisir une classe et une module!",
            },{
                type: 'danger',
                placement: {
                    from: "top",
                    align: "center"
                },
                time: 1000,
            });
        }else {
            $.ajax({
                url:"/notes/liste_note_classe",
                type:"post",
                data:{classe_id:classe_id,module_id:module_id},
                success:function(response) {
                    $('#tables-listes-eleves').empty().append(response);
                }
            });
        }
    });


    $('#form-ajout-presence').validate({
        validClass: "success",
        rules: {
            professeur_name: {
                required: true
            },
            date_pres: {
                required: true
            },
            time_pres_arrive: {
                required: true,
            }
        },
        messages: {
            professeur_name: "Veuillez Séléctionner un professeur",
            date_pres: "Veuillez entrer la date de présence",
            time_pres_arrive:"Veuillez saisir l'heure d'arrivée",
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function (form) {
            var prof_id = $('#professeur_name').val();
            var date_pres = $('#date_pres').val();
            var heure_arrive = $('#time_pres_arrive').val();
            var datas ={prof_id:prof_id,date_pres:date_pres,heure_arrive:heure_arrive};
            $.ajax({
                url:"/professeur/add_fiche_presence",
                type:"post",
                data:datas,
                success:function(response) {
                    if (response.color == "success") {
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
