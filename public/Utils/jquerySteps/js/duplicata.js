function initFormStep(form, title, bodyTag, transitionEffect)
{    
    
    var form = form.show();
    title = title || "h3";
    bodyTag = bodyTag || "section";
    transitionEffect = transitionEffect || "slideLeft";
    
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
        onStepChanging: function (event, currentIndex, newIndex) {
            
            // second step
            // if (currentIndex == 1 && newIndex == 2) {
            //     return checkSecondStep();
            // }
            // Allways allow previous action even if the current form is not valid!
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
        onStepChanged: function (event, currentIndex, priorIndex) {
            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 2) {
                let data = $('#example-advanced-form').serializeArray();
                let resum = $('#resum');
                let html = "";
                let typeTitulaire = "";
                let motifsDemande = "";
                let otherTitulaireArray = [
                    "demande_duplicata[duplicata][motifDemande]",
                    "demande_duplicata[duplicata][numeroFormule]",
                    "demande_duplicata[duplicata][adresse][numero]",
                    "demande_duplicata[duplicata][adresse][extension]",
                    "demande_duplicata[duplicata][adresse][typevoie]",
                    "demande_duplicata[duplicata][adresse][nom]",
                    "demande_duplicata[duplicata][adresse][complement]",
                    "demande_duplicata[duplicata][adresse][codepostal]",
                    "demande_duplicata[duplicata][adresse][ville]",
                    "demande_duplicata[duplicata][adresse][isHosted]",
                ];
                let societyTitulaireArray = [
                    "demande_duplicata[duplicata][titulaire][type]",
                    "demande_duplicata[duplicata][titulaire][raisonsociale]",
                ];
                let physicTitulaireArray = [
                    "demande_duplicata[duplicata][titulaire][type]",
                    "demande_duplicata[duplicata][titulaire][nomprenom]",
                ];
                let motifDemandePerteArray = [
                    "demande_duplicata[duplicata][datePerte]",
                ];
                data.forEach(element => {
                    if (element.name === "demande_duplicata[duplicata][titulaire][type]"){
                        typeTitulaire = element.value;
                    } else if (element.name === "demande_duplicata[duplicata][motifDemande]"){
                        motifsDemande = element.value;
                    }
                    let name = element.name;
                    let value = element.value;

                    let label = {
                        "demande_duplicata[duplicata][motifDemande]": "Motif de la demande",
                        "demande_duplicata[duplicata][numeroFormule]": "Numéro de formule",
                        "demande_duplicata[duplicata][datePerte]": "Date de la perte",
                        "demande_duplicata[duplicata][titulaire][type]": "Titulaire",
                        "demande_duplicata[duplicata][titulaire][raisonsociale]": "Raison Sociale",
                        "demande_duplicata[duplicata][titulaire][nomprenom]": "Nom et prénom(s)",
                        "demande_duplicata[duplicata][adresse][numero]" : "Numéro de la rue",
                        "demande_duplicata[duplicata][adresse][extension]" : "Extension",
                        "demande_duplicata[duplicata][adresse][typevoie]" : "Type de la voie",
                        "demande_duplicata[duplicata][adresse][nom]" : "Nom de la voie",
                        "demande_duplicata[duplicata][adresse][complement]" : "Complément",
                        "demande_duplicata[duplicata][adresse][codepostal]" : "Code postal",
                        "demande_duplicata[duplicata][adresse][ville]" : "Ville",
                        "demande_duplicata[duplicata][adresse][isHosted]" : "Etes-vous hébergé(e)?",
                    };

                    if(value === "1"){
                        value = "Oui";
                    }else if(value === "0"){
                        value = "Non";
                    }else if(value === ""){
                        value = "Non renseigné";
                    }else if(value === "mor"){
                        value = "Société";
                    }else if(value === "phy"){
                        value = "Personne physique";
                    }else if(value === "PERT"){
                        value = "Perte";
                    }else if(value === "VOL"){
                        value = "Vol";
                    }else if(value === "DET"){
                        value = "Détérioration";
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
                    
                    if (typeTitulaire === "mor" && 0 <= $.inArray(name, societyTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + "<span>" + value + "</span>" + "</div>");
                    } else if (typeTitulaire === "phy" && 0 <= $.inArray(name, physicTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + "<span>" + value + "</span>" + "</div>");
                    } else if (motifsDemande === "PERT" && 0 <= $.inArray(name, motifDemandePerteArray )) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + "<span>" + value + "</span>" + "</div>");
                    } else if (0 <= $.inArray(name, otherTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + "<span>" + value + "</span>" + "</div>");
                    }   
                });
                resum.html(html.concat("<div><strong> Démarche: </strong> <span>Duplicata</span> </div>"));
            }
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            form.submit();
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            "demande_duplicata[duplicata][titulaire][nomprenom]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_duplicata_duplicata_titulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_duplicata[duplicata][titulaire][raisonsociale]": {
                required: {
                    depends: function () {
                        let check = $('#demande_duplicata_duplicata_titulaire_type').val();

                        if (check == 'mor') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_duplicata[duplicata][datePerte]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_duplicata_duplicata_motifDemande').val();

                        if (persone == 'PERT') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_duplicata[duplicata][numeroFormule]": {
                required: true,
                minlength: 11,
                maxlength: 11,
            },
            "demande_duplicata[duplicata][adresse][numero]": {
                required: true
            },
            "demande_duplicata[duplicata][adresse][typevoie]": {
                required: true
            },
            "demande_duplicata[duplicata][adresse][nom]": {
                required: true
            },
            "demande_duplicata[duplicata][adresse][codepostal]": {
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5,
            },
            "demande_duplicata[duplicata][adresse][ville]": {
                required: true
            }
        },
        messages:{
            "demande_duplicata[duplicata][titulaire][nomprenom]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][titulaire][raisonsociale]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][datePerte]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][numeroFormule]": {
                required: 'Champs obligatoire',
                minlength: 'Le numéro doit comporter à 11 caractères',
                maxlength: 'Le numéro doit comporter à 11 caractères'
            },
            "demande_duplicata[duplicata][adresse][typevoie]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][adresse][nom]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][adresse][codepostal]": {
                required: 'Champs obligatoire',
                minlength: 'Le code postal doit être à 5 chiffres',
                maxlength: 'Le code postal doit être à 5 chiffres'
            },
            "demande_duplicata[duplicata][adresse][ville]": {
                required: 'Champs obligatoire',
            },
            "demande_duplicata[duplicata][adresse][numero]": {
                required: 'Champs obligatoire',
            },
        }
    });    
};

function showElement(element){
    element.on('change', function(e) {
        $(e.target).parent('.form-group').siblings().toggle();
        console.log(element);
    });
}

function datePickerFunction(element){
    element.datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
}

function showDatePerte(element){
    element.on('change', function(e){
        var Value = $(".motifDemande").find(":selected").text();
        console.log(Value);
        if (Value === "Perte") {
            $(e.target).parent().siblings().show();
        } else {
            $(e.target).parent().siblings().hide();
        }
    });
}