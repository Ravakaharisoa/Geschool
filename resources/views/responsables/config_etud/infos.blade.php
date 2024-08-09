<div class="modal-header">
    <h5 class="modal-title fw-bold" id="modalAppTitle">Modifier les informations d'étudiant</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form-update-info">
    <div class="modal-body" id="modalBody">
        <input type="hidden" id="eleves_id" name="eleve_id" value="{{$eleve_id}}">
        <div class="row mx-1">
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="nom_etuds">Nom <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_etuds" name="nom_etuds" value="{{$eleve->nom !=null?$eleve->nom:""}}" required>
                </div>
                <div class="form-group">
                    <label for="matricule_etuds">N° Matricule <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="matricule_etuds" name="matricule_etuds" value="{{$eleve->matricule?$eleve->matricule:""}}" required>
                </div>
                <div class="form-group">
                    <label for="nom_peres">Nom du Père <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_peres" name="nom_peres" value="{{$eleve->nom_pere !=null?$eleve->nom_pere:""}}" required>
                </div>
                <div class="form-group">
                    <label for="contact2_etuds">Contact Sécondaire :</label>
                    <input type="tel" class="form-control telephone" id="contact2_etuds" name="contact2_etuds" value="{{$eleve->contact_seco!=null?$eleve->contact_seco:""}}">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="prenom_etuds">Prénom(s) :</label>
                    <input type="text" class="form-control" id="prenom_etuds" name="prenom_etuds" value="{{$eleve->prenom !=null?$eleve->prenom:""}}">
                </div>
                <div class="form-group">
                    <label for="classe_etuds">Classe <span class="text-danger">*</span> :</label>
                    <select class="form-control" id="classe_etuds" name="classe_etuds" required>
                        @if (count($classes)>0)
                            @foreach ($classes as $classe)
                                <option value="{{$classe->id}}"{{$eleve->classe_id==$classe->id?"checked":""}}>{{$classe->nom_classe}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom_meres">Nom de la Mère <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_meres" name="nom_meres" value="{{$eleve->nom_mere !=null?$eleve->nom_mere:""}}" required>
                </div>
                <div class="form-group">
                    <label for="maladie_etuds">Maladie particulier <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="maladie_etuds" name="maladie_etuds" value="{{$eleve->maladie!=null?$eleve->maladie:""}}" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="sexe_etuds">Sexe <span class="text-danger">*</span> :</label>
                    <select class="form-control" id="sexe_etuds" name="sexe_etuds" required>
                        <option value="garcon" {{$eleve->sexe=='garcon'?"checked":""}}>Garçon</option>
                        <option value="fille" {{$eleve->sexe=='fille'?"checked":""}}>Fille</option>
                        <option value="autre" {{$eleve->sexe=='autre'?"checked":""}}>Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nationalite_etuds">Nationalité <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nationalite_etuds" name="nationalite_etuds" value="{{$eleve->nationalite !=null?$eleve->nationalite :""}}" required>
                </div>

                <div class="form-group">
                    <label for="adresse_etuds">Adresse <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="adresse_etuds" name="adresse_etuds" value="{{$eleve->adresse !=null?$eleve->adresse:""}}" required>
                </div>
                <div class="form-group">
                    <label for="autre_infos">Autres informations :</label>
                    <textarea class="form-control" id="autre_infos" name="autre_infos" rows="1"></textarea>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="date_nais_etuds">Date de naissance <span class="text-danger">*</span> :</label>
                    <input type="date" class="form-control" id="date_nais_etuds" name="date_nais_etuds" value="{{$eleve->date_naissance !=null?$eleve->date_naissance:""}}" required>
                </div>
                <div class="form-group">
                    <label for="lieu_nais_etuds">Lieu de naissance <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="lieu_nais_etuds" name="lieu_nais_etuds" value="{{$eleve->lieu_naissance !=null?$eleve->lieu_naissance:""}}" required>
                </div>
                <div class="form-group">
                    <label for="email_etuds">Adresse Email <span class="text-danger">*</span> :</label>
                    <input type="email" class="form-control" id="email_etuds" name="email_etuds" value="{{$eleve->email!=null?$eleve->email:""}}" required>
                </div>
                <div class="form-group">
                    <label for="contact1_etuds">Contact Primaire <span class="text-danger">*</span> :</label>
                    <input type="tel" class="form-control telephone" id="contact1_etuds" name="contact1_etuds" value="{{$eleve->contact_prim!=null?$eleve->contact_prim:""}}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger fermer" data-dismiss="modal"><i class="fas fa-times mr-2"></i>  Fermer</button>
        <button type="button" class="btn btn-sm btn-success ajout_info_etud"><i class="fas fa-save mr-2"></i> Ajouter</button>
    </div>
</form>
