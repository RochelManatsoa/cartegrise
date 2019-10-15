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
            previous: "Précédant",
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
                let typeAncienTitulaire = "";
                let typeNewTitulaire = "";
                let otherNewTitulaireArray = [
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][numero]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][extension]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][typevoie]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][nom]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][complement]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][codepostal]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][ville]",
                    "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][isHosted]",
                ];
                let societyNouveauxTitulaireArray = [
                    "demande_ctvo[ctvo][acquerreur][type]",
                    "demande_ctvo[ctvo][acquerreur][raisonSociale]",
                    "demande_ctvo[ctvo][acquerreur][siren]",
                    "demande_ctvo[ctvo][acquerreur][societeCommerciale]",
                ];
                let physicNouveauxTitulaireArray = [
                    "demande_ctvo[ctvo][acquerreur][type]",
                    "demande_ctvo[ctvo][acquerreur][nomPrenomTitulaire]",
                    "demande_ctvo[ctvo][acquerreur][prenomTitulaire]",
                    "demande_ctvo[ctvo][acquerreur][genre]",
                    "demande_ctvo[ctvo][acquerreur][dateN]",
                    "demande_ctvo[ctvo][acquerreur][lieuN]",
                    "demande_ctvo[ctvo][acquerreur][departementN]",
                    "demande_ctvo[ctvo][acquerreur][paysN]",
                    "demande_ctvo[ctvo][acquerreur][droitOpposition]",
                ];
                let societyAncienTitulaireArray = [
                    "demande_ctvo[ctvo][ancienTitulaire][type]",
                    "demande_ctvo[ctvo][ancienTitulaire][raisonsociale]",
                    "demande_ctvo[ctvo][ciPresent]",
                    "demande_ctvo[ctvo][numeroFormule]",
                ];
                let physicAncientitulaireArray = [
                    "demande_ctvo[ctvo][ancienTitulaire][type]",
                    "demande_ctvo[ctvo][ancienTitulaire][nomprenom]",
                    "demande_ctvo[ctvo][ciPresent]",
                    "demande_ctvo[ctvo][numeroFormule]",
                ];
                data.forEach(element => {
                    if (element.name === "demande_ctvo[ctvo][ancienTitulaire][type]")
                    {
                        typeAncienTitulaire = element.value;
                    } else if (element.name === "demande_ctvo[ctvo][acquerreur][type]"){
                        typeNewTitulaire = element.value;
                    }
                    let name = element.name;
                    
                    if (typeAncienTitulaire === "mor" && 0 <= $.inArray(name, societyAncienTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (typeAncienTitulaire === "phy" && 0 <= $.inArray(name, physicAncientitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (typeNewTitulaire === "mor" && 0 <= $.inArray(name, societyNouveauxTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (typeNewTitulaire === "phy" && 0 <= $.inArray(name, physicNouveauxTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (0 <= $.inArray(name, otherNewTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    }   
                });
                resum.html(html);
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
            "demande_ctvo[ctvo][ancienTitulaire][nomprenom]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][numeroFormule]": {
                required: {
                    depends: function () {
                        let check = $('#demande_ctvo_ctvo_ciPresent').val();

                        if (check == "0") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][prenomTitulaire]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][lieuN]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][departementN]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][paysN]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][nomPrenomTitulaire]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_acquerreur_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][raisonSociale]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_acquerreur_type').val();

                        if (persone == 'mor') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_ctvo[ctvo][acquerreur][siren]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_ctvo_ctvo_ancienTitulaire_type').val();

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
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][numero]": {
                required: true
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][typevoie]": {
                required: true
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][nom]": {
                required: true
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][codepostal]": {
                required: true
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][ville]": {
                required: true
            }
        },
        messages:{
            "demande_ctvo[ctvo][ancienTitulaire][nomprenom]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][numeroFormule]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][prenomTitulaire]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][lieuN]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][departementN]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][paysN]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][nomPrenomTitulaire]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][raisonSociale]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][siren]": {
                required: 'Champs obligatoire',
                minlength: 'Le numéro doit être à 9 chiffres',
                maxlength: 'Le numéro doit être à 9 chiffres'
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][typevoie]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][nom]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][codepostal]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][ville]": {
                required: 'Champs obligatoire',
            },
            "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][numero]": {
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