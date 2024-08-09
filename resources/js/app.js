$(document).ready(function(){
	$.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select2_classe').select2({
        theme: "bootstrap"
    });
    $('#edit_btn_ecole').attr('disabled',true);
    $('.btn_add_ecole').attr('disabled',true);

    $('.form_update_ecole .form-control').on('change',function(e) {
        $('#edit_btn_ecole').attr('disabled',false);
    });
    $('.form_add_ecole .form-control').on('change',function(e) {
        $('.btn_add_ecole').attr('disabled',false);
    });

    $('#select_anneeSco').on('click',function(e) {
        e.preventDefault();
        $('.modalApp').modal('show');
        if ($('.modal-dialog').hasClass('modal-sm')) {
            $('.modal-dialog').removeClass('modal-sm');
        }
        $.ajax({
            url:"/liste/annee/scolaire",
            type:"get",
            async: false,
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
    }

    $(".search_table").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("body").on("keyup",".search_table",function () {
        var value = $(this).val().toLowerCase();
        $(".table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $('#add-annee-scol').on('click',function(e){
     	e.preventDefault();
     	$('.modalApp').modal('show');
     	$('.modal-dialog').addClass('modal-sm');
     	$.ajax({
     		url:"/nouveau/annee/scolaire",
     		type:"get",
     		success:function(response){
     			$('#modal_content').empty().append(response);
     		}
     	});
    });

    $('body').on('click','#btn-save-anneesco',function(e) {
        e.preventDefault();
        var anneeSco = $('#new-anneesco').val();
        if (anneeSco == "") {
            $('.label-new-anneesco').css('color','#F25961');
            $('#new-anneesco').css('border','1px solid #F25961');
        } else {
            $.ajax({
                url:'/add/new/anneescolaire',
                type:"post",
                data:{anneeSco:anneeSco},
                async: false,
                success:function(response) {
                    if (response.color == "success"){
                        $('.modalApp').modal('hide');
                        $('#new-anneesco').val('');
                        swal("", response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeAnneScol();
                    }else {
                        swal("", response.message, {
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

    listeAnneScol();
    function listeAnneScol() {
        $('.listeAnneeSco').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/anneescolaire/disponible",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'annee_sco', name: 'annee_sco'},
                {
                    data: '',
                    name: '',
                    orderable: false,
                    searchable: false
                },
            ],
            destroy: true,
            "pageLength":10,
            "language": {
                "url": "/assets/js/plugin/datatables/datatable_fr.json"
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages <= 1) {
                  pagination.hide();
                } else {
                  pagination.show();
                }
            },
            // initComplete: function() {
            //     var api = this.api();
            //     api.columns().eq(0).each(function(colIdx) {
            //         var cell = $('th').eq($(api.column(colIdx).header()).index());
            //         var title = $(cell).text();
            //         $('input', $('th').eq($(api.column(colIdx).header()).index()) )
            //             .off('keyup change')
            //             .on('keyup change', function (e) {
            //                 e.stopPropagation();
            //                 $(this).attr('title', $(this).val());
            //                 var regexr = '({search})';
            //                 var cursorPosition = this.selectionStart;
            //                 api
            //                     .column(colIdx)
            //                     .search((this.value != "") ? regexr.replace('{search}', '((('+this.value+')))') : "", this.value != "", this.value == "")
            //                     .draw();
            //                 $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
            //             });
            //     });
            // }
        });
    }

    $('body').on('click','.suppr_anneeSco',function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
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
                    url:"/supprimer/anneescolaire",
                    type:"post",
                    data:{id:id},
                    async: false,
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
                            listeAnneScol();
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

    $('body').on('click','.close',function(e) {
        e.preventDefault();
        $('.modalApp').modal('hide');
    });

    $('body').on('click','.fermer',function(e) {
        e.preventDefault();
        $('.modalApp').modal('hide');
    });

    $('body').on('click','#update_current_annee',function(e) {
        e.preventDefault();
        var id = $('#anneeSco_change').val();
        if (id=="") {
            $('#anneeSco_change').css('border','1px solid #F25961');
        } else {
            $.ajax({
                url:"/update/current/anneescolaire",
                type:"post",
                data:{id:id},
                async: false,
                success:function name(response) {
                    if (response.color=="success") {
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
                        $('.modalApp').modal('hide');
                        location.reload();
                        AnneeScoActuel();
                        listeClasse();
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

    AnneeScoActuel();
    function AnneeScoActuel() {
        $.ajax({
            url:"/get/AnneeScoActuel",
            type:"get",
            async: false,
            success:function(response) {
                $('#select_anneeSco').empty().text(response);
                $('#select_anneeScoA').empty().text(response);
            }
        });
    }

    $('#add-matiere').on('click',function(e) {
        e.preventDefault();
        $('.modalApp').modal('show');
     	$('.modal-dialog').addClass('modal-sm');
     	$.ajax({
     		url:"/nouvelle/matiere",
     		type:"get",
             async: false,
     		success:function(response){
     			$('#modal_content').empty().append(response);
     		}
     	});
    });

    $('body').on('change keyup','#new-matiere',function(e) {
        e.preventDefault();
        $(this).removeClass('is-invalid');
    });
    $('body').on('keyup','#montant_cantine',function(e) {
        e.preventDefault();
        $(this).removeClass('new-abrev');
    });

    $('body').on('click','#btn-save-matiere',function(e) {
        e.preventDefault();
        var matiere = $('#new-matiere').val();
        var abrev = $('#new-abrev').val();
        if (matiere == "") {
            $('#new-matiere').addClass('is-invalid');
        }else if(abrev == ""){
            $('#new-abrev').addClass('is-invalid');
        }else {
            $.ajax({
                url:'/add/new/matiere',
                type:"post",
                data:{matiere:matiere,abrev:abrev},
                async: false,
                success:function(response) {
                    if (response.color == "success"){
                        $('.modalApp').modal('hide');
                        $('#new-matiere').val('');
                        $('#new-abrev').val('');
                        swal("", response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeMatieres();
                    }else {
                        swal("", response.message, {
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

    listeMatieres();
    function listeMatieres() {
        $('.listeMatiere').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/matiere/disponible",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'matiere', name: 'matiere'},
                {data:'abreviation',name:'abreviation'},
                {
                    data: '',
                    name: '',
                    orderable: false,
                    searchable: false
                },
            ],
            destroy: true,
            "pageLength":10,
            "language": {
                "url": "/assets/js/plugin/datatables/datatable_fr.json"
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages <= 1) {
                  pagination.hide();
                } else {
                  pagination.show();
                }
            }
        });
    }

    $('body').on('click','.suppr_matiere',function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
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
                    url:"/supprimer/matiere",
                    type:"post",
                    data:{id:id},
                    async: false,
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
                            listeMatieres();
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

    $('body').on('click','.edit_matiere',function(e) {
        e.preventDefault();
        var matiere_id = $(this).attr('id');
     	$('.modalApp').modal('show');
     	$('.modal-dialog').addClass('modal-sm');
     	$.ajax({
     		url:"/edit/matiere/"+matiere_id,
     		type:"get",
             async: false,
     		success:function(response){
     			$('#modal_content').empty().append(response);
     		}
     	});
    });

    $('body').on('click','#btn-update-matiere',function(e) {
        e.preventDefault();
        var matiere = $('#new_matiere').val();
        var matiere_id = $('#matiere_id').val();
        var abrev = $('#new_abrev').val();
        if (matiere == "") {
            $('#new_matiere').addClass('is-invalid');
        }else if(abrev==""){
            $('#new_abrev').addClass('is-invalid');
        }else {
            $.ajax({
                url:'/update/matiere',
                type:"post",
                data:{matiere:matiere,matiere_id:matiere_id,abrev:abrev},
                async: false,
                success:function(response) {
                    if (response.icon == "success") {
                        $('.modalApp').modal('hide');
                        swal("", response.message, {
                            icon : response.icon,
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeMatieres();
                    } else if (response.icon == "warning") {
                        swal("", response.message, {
                            icon : response.icon,
                            buttons: {
                                confirm: {
                                    className : 'btn btn-warning'
                                }
                            },
                        });
                    } else {
                        swal("", response.message, {
                            icon : response.icon,
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

    $('#add-classe').on('click',function(e) {
        e.preventDefault();
        $('.modalApp').modal('show');
        $.ajax({
            url:"/nouvelle/classe",
            type:"get",
            async: false,
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('click','#ajout_classe',function(e) {
        e.preventDefault();
        var classe = $('#classe').val();
        var scolarite = $('#scolarite').val();
        if (classe == "" || scolarite == "") {
            swal("", "Tous les champs doivent être remplis!", {
                icon : "info",
                buttons: {
                    confirm: {
                        className : 'btn btn-info'
                    }
                },
            });
        } else {
            $.ajax({
                url:"/add/new/classe",
                type:"post",
                data:{classe:classe,scolarite:scolarite},
                async: false,
                success:function(response){
                    if (response.color == "success"){
                        $('.modalApp').modal('hide');
                        $('#classe').val('');
                        $('#scolarite').val('');
                        swal("", response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeClasse();
                    }else {
                        swal("", response.message, {
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

    listeClasse();
    function listeClasse() {
        $('.listeClasse').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/classe/disponible",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nom_classe', name: 'nom_classe'},
                {data: 'montant_total', name: 'montant_total',render: $.fn.dataTable.render.number(' ', '.', 0, '') },
                {
                    data: '',
                    name: '',
                    orderable: false,
                    searchable: false
                },
            ],
            destroy: true,
            "pageLength":10,
            "language": {
                "url": "/assets/js/plugin/datatables/datatable_fr.json"
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages <= 1) {
                  pagination.hide();
                } else {
                  pagination.show();
                }
            }
        });
    }

    $('body').on('click','.edit_classe',function(e) {
        e.preventDefault();
        var classe_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $.ajax({
            url:"/editer/classe",
            type:"post",
            data:{classe_id:classe_id},
            async: false,
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('click','#update_classe',function(e) {
        e.preventDefault();
        var classe_id = $('#classe_id').val();
        var classe = $('#edit_classe').val();
        var scolarite = $('#edit_scolarite').val();
        var annee_id = $('#edit_anne_sco').val();
        $.ajax({
            url:'/update/classe',
            type:"post",
            data:{classe_id:classe_id,classe:classe,scolarite:scolarite,annee_id:annee_id},
            async: false,
            success:function(response) {
                if (response.icon == "success") {
                    $('.modalApp').modal('hide');
                    swal("", response.message, {
                        icon : response.icon,
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    });
                    listeClasse();
                } else if (response.icon == "warning") {
                    swal("", response.message, {
                        icon : response.icon,
                        buttons: {
                            confirm: {
                                className : 'btn btn-warning'
                            }
                        },
                    });
                } else {
                    swal("", response.message, {
                        icon : response.icon,
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            }
        });
    });

    $('body').on('click','.suppr_classe',function(e) {
        e.preventDefault();
        var classe_id = $(this).attr('id');
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
                    url:"/delete/classe",
                    type:"post",
                    data:{classe_id:classe_id},
                    async: false,
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
                            listeClasse();
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

    $('#add-module').on('click',function(e) {
        e.preventDefault();
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $.ajax({
            url:"/nouvelle/module",
            type:"get",
            async: false,
            success:function(response){
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('click','#btn-save-module',function(e) {
        e.preventDefault();
        var modules = $('#new-module').val();
        if (modules == "") {
            $('#label-new-module').css('color','#F25961');
            $('#new-module').css('border','1px solid #F25961');
        } else {
            $.ajax({
                url:'/add/module',
                type:"post",
                data:{modules:modules},
                async: false,
                success:function(response) {
                    if (response.color == "success"){
                        $('.modalApp').modal('hide');
                        $('#new-module').val('');
                        swal("", response.message, {
                            icon : "success",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeModule();
                    }else {
                        swal("", response.message, {
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

    listeModule();
    function listeModule() {
        $('.listeModule').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/module/disponible",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'trimestre', name: 'trimestre'},
                {
                    data: '',
                    name: '',
                    orderable: false,
                    searchable: false
                },
            ],
            destroy: true,
            "pageLength":10,
            "language": {
                "url": "/assets/js/plugin/datatables/datatable_fr.json"
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages <= 1) {
                  pagination.hide();
                } else {
                  pagination.show();
                }
            }
        });
    }

    $('body').on('click','.edit_module',function(e) {
        e.preventDefault();
        var module_id = $(this).attr('id');
        $('.modalApp').modal('show');
        $('.modal-dialog').addClass('modal-sm');
        $.ajax({
            url:"/editer/module",
            type:"post",
            data:{module_id:module_id},
            async: false,
            success:function(response) {
                $('#modal_content').empty().append(response);
            }
        });
    });

    $('body').on('click','#btn-update-module',function(e) {
        e.preventDefault();
        var modules = $('#edit-module').val();
        var module_id = $('#module_id').val();
        if (modules == "") {
            $('#edit-module').css('border','1px solid #F25961');
        } else {
            $.ajax({
                url:'/update/module',
                type:"post",
                data:{modules:modules,module_id:module_id},
                async: false,
                success:function(response) {
                    if (response.icon == "success") {
                        $('.modalApp').modal('hide');
                        swal("", response.message, {
                            icon : response.icon,
                            buttons: {
                                confirm: {
                                    className : 'btn btn-success'
                                }
                            },
                        });
                        listeModule();
                    } else if (response.icon == "warning") {
                        swal("", response.message, {
                            icon : response.icon,
                            buttons: {
                                confirm: {
                                    className : 'btn btn-warning'
                                }
                            },
                        });
                    } else {
                        swal("", response.message, {
                            icon : response.icon,
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

    $('body').on('click','.suppr_module',function(e) {
        e.preventDefault();
        var module_id = $(this).attr('id');
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
                    url:"/delete/module",
                    type:"post",
                    data:{module_id:module_id},
                    async: false,
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
                            listeModule();
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
});
