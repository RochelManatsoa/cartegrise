function initFormStep(form, title, bodyTag, transitionEffect) {
    var form = form.show();
    title = title || "h3";
    bodyTag = bodyTag || "fieldset";
    transitionEffect = transitionEffect || "slideLeft";
    isFinishing = false;

    form.steps({
            headerTag: title,
            bodyTag: bodyTag,
            transitionEffect: transitionEffect,
            labels: {
                current: "current step:",
                pagination: "Pagination",
                finish: "Terminer",
                next: "Suivant",
                previous: "Précédent",
                loading: "Chargement ..."
            },
            onStepChanging: function(event, currentIndex, newIndex) {
                //if (currentIndex === 0 && newIndex === 1) {}
                if (currentIndex > newIndex) {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex) {
                // Used to skip the "Warning" step if the user is old enough.
                if (currentIndex === 3) {
                    let data = $('#example-advanced-form').serializeArray();
                    let resum = $('#resum');
                    let html = "";
                    let typeNewTitulaire = "";
                    let otherOldTitulaireArray = [
                        "demande_changement_adresse[changementAdresse][ancienAdresse][numero]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][extension",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][typevoie]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][nom]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][complement]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][ville]",
                        "demande_changement_adresse[changementAdresse][ancienAdresse][isHosted]",
                        "demande_changement_adresse[changementAdresse][numeroFormule]",
                    ];
                    let otherNewTitulaireArray = [
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][typevoie]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][isHosted]",
                        "demande_changement_adresse[changementAdresse][numeroFormule]",
                    ];
                    let societyNewTitulaireArray = [
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][type]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][raisonSociale]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][siren]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][societeCommerciale]"
                    ];
                    let physicNewTitulaireArray = [
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][type]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][departementN]",
                        "demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]",
                    ];
                    data.forEach(element => {
                        if (element.name === "demande_changement_adresse[changementAdresse][nouveauxTitulaire][type]")
                            typeNewTitulaire = element.value;
                        let name = element.name;

                        let value = element.value;

                        let label = {
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][type]" : "Titulaire",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][raisonSociale]" : "Raison sociale",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][siren]" : "SIREN",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][societeCommerciale]" : "Société commerciale",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]" : "Nom de naissance",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]" : "Prénom(s)",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]" : "Nom ",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]" : "Date de naissance",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]" : "Lieu de naissance",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][departementN]" : "Département de naissance",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]" : "Pays de naissance",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]" : "Numéro de rue",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]" : "Extension",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][typevoie]" : "Type de la voie",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]" : "Nom de la voie",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]" : "Complément",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]" : "Code postal",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]" : "Ville",
                            "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][isHosted]" : "Hébergé(e)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][numero]" : "Numéro de rue (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][extension]" : " Extension (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][typevoie]" : " Type de la voie (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][nom]" : " Nom de la voie (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][complement]" : " Complément (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]" : " Code postal (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][ville]" : " Ville (Ancienne adresse)",
                            "demande_changement_adresse[changementAdresse][ancienAdresse][isHosted]" : "Hébergé(e)",
                            "demande_changement_adresse[changementAdresse][numeroFormule]" : "Numéro de Formule",
                        };

                        if(value === "1"){
                            value = "Oui";
                        }else if(value === "0"){
                            value = "Non";
                        }else if(value === ""){
                            value = "Non renseigné";
                        }else if(value === "M"){
                            value = "Monsieur";
                        }else if(value === "F"){
                            value = "Madame";
                        }else if(value === "mor"){
                            value = "Société";
                        }else if(value === "phy"){
                            value = "Personne physique";
                        }else if(value === "RUE"){
                            value = "Rue";
                        }else if(value === "BLVD"){
                            value = "Boulevard";
                        }else if(value === "AVN"){
                            value = "Avenue";
                        }else if(value === "ALL"){
                            value = "Allée";
                        }else if(value === "PLC"){
                            value = "Place";
                        }else if(value === "IMP"){
                            value = "Impasse";
                        }else if(value === "CHM"){
                            value = "Chemin";
                        }else if(value === "QUAI"){
                            value = "Quai";
                        }else if(value === "FORT"){
                            value = "Fort";
                        }else if(value === "RTE"){
                            value = "Route";
                        }else if(value === "PASS"){
                            value = "Passage";
                        }else if(value === "COUR"){
                            value = "Cour";
                        }else if(value === "CHAU"){
                            value = "Chaussée";
                        }else if(value === "PARC"){
                            value = "Parc";
                        }else if(value === "FBG"){
                            value = "Faubourg";
                        }else if(value === "LDIT"){
                            value = "Lieu-dit";
                        }else if(value === "SQUA"){
                            value = "Square";
                        }else if(value === "SENT"){
                            value = "Sente";
                        }else{
                            value;
                        };

                        if (typeNewTitulaire == 'mor' && 0 <= $.inArray(name, societyNewTitulaireArray)) {
                            html = html.concat("<strong>" + label[element.name] + "</strong>" + " : " + value + "<br>");
                        } else if (typeNewTitulaire == 'phy' && 0 <= $.inArray(name, physicNewTitulaireArray)) {
                            html = html.concat("<strong>" + label[element.name] + "</strong>" + " : " + value + "<br>");
                        } else if (0 <= $.inArray(name, otherOldTitulaireArray)) {
                            html = html.concat("<strong>" + label[element.name] + "</strong>" + " : " + value + "<br>");
                        } else if (0 <= $.inArray(name, otherNewTitulaireArray)) {
                            html = html.concat("<strong>" + label[element.name] + "</strong>" + " : " + value + "<br>");
                        }
                    });
                    resum.html(html.concat("<strong> Démarche </strong> : Changement d'Adresse <br>"));
                    //console.log(data);
                }
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                form.submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                /**PARTIE 01 TITULAIRE*/
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][type]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]': {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }                    
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'phy') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                /**SOCIETE*/
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][raisonSociale]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'mor') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    }
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][siren]": {
                    required: {
                        depends: function () {
                            let persone = $('#demande_changement_adresse_changementAdresse_nouveauxTitulaire_type').val();

                            if (persone == 'mor') {
                                return true;
                            }
                            else {
                                return false;
                            }

                        }
                    },
                    digits: true,
                    minlength: 9,
                    maxlength: 9,
                },
                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][ville]": {
                    required: true,
                },
                /**PARTIE 03 NOUVELLE ADRESSE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
                    required: true,
                },
                //PARTIE 04 NUMERO DE FORMULE PRESENT SUR LA CARTE GRISE
                "demande_changement_adresse[changementAdresse][numeroFormule]": {
                    required: true,
                }
            },
            messages: {
                /**PARTIE 01 TITULAIRE*/
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]': {
                    required: "Champs obligatoire"
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]': {
                    required: "Champs obligatoire",
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]': {
                    required: "Champs obligatoire",
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]': {
                    required: "Champs obligatoire",
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]': {
                    required: "Champs obligatoire",
                },
                'demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]': {
                    required: "Champs obligatoire",
                },
                /**SOCIETE*/
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][raisonSociale]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][siren]": {
                    required: "Champs obligatoire",
                    minlength: 'Le numéro doit être à 9 chiffres',
                    maxlength: 'Le numéro doit être à 9 chiffres',
                },
                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][ville]": {
                    required: "Champs obligatoire",
                },
                /**PARTIE 03 NOUVELLE ADRESSE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
                    required: "Champs obligatoire",
                },
                //PARTIE 04 NUMERO DE FORMULE PRESENT SUR LA CARTE GRISE
                "demande_changement_adresse[changementAdresse][numeroFormule]": {
                    required: "Champs obligatoire",
                }
            }
        });
};
function showElement(element){
    element.on('change', function(e) {
        $(e.target).parent('.form-group').siblings().toggle();
        console.log(element);
    });
};
function datePickerFunction(element){
    element.datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
}