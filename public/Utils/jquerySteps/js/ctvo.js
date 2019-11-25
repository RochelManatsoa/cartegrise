$(document).ready(function () {
    $(".Navigation").sticky({ topSpacing: 0 });

    // Mobile nav
    $('.nav').append($('<div class="nav-mobile"><span></span></div>'));
    $('.nav-item').has('ul').prepend('<span class="nav-click"><i class="icomoon icon-arrow-down"></i></span>');
    $('.nav-mobile').click(function(){
        this.classList.toggle('active');
        $('.nav-list').toggle();
    });
    $('.nav-list').on('click', '.nav-click', function(){
    $(this).siblings('.nav-sub-menu').toggle();
    $(this).children('.icon-arrow-down').toggleClass('nav-rotate');
    
    })
});

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

                    let value = element.value;

                    let label = {
                        "demande_ctvo[ctvo][acquerreur][type]" : "Nouveau Titulaire",
                        "demande_ctvo[ctvo][acquerreur][raisonSociale]" : "Raison sociale",
                        "demande_ctvo[ctvo][acquerreur][siren]" : "SIREN",
                        "demande_ctvo[ctvo][acquerreur][societeCommerciale]" : "Société commerciale",
                        "demande_ctvo[ctvo][acquerreur][nomPrenomTitulaire]" : "Nom de naissance",
                        "demande_ctvo[ctvo][acquerreur][prenomTitulaire]" : "Prénom(s)",
                        "demande_ctvo[ctvo][acquerreur][genre]" : "Civilité ",
                        "demande_ctvo[ctvo][acquerreur][dateN]" : "Date de naissance",
                        "demande_ctvo[ctvo][acquerreur][lieuN]" : "Lieu de naissance",
                        "demande_ctvo[ctvo][acquerreur][departementN]" : "Département de naissance",
                        "demande_ctvo[ctvo][acquerreur][paysN]" : "Pays de naissance",
                        "demande_ctvo[ctvo][acquerreur][droitOpposition]" : "Opposé(e) à la diffusion de mes informations",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][numero]" : "Numéro de rue",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][extension]" : "Extension",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][typevoie]" : "Type de la voie",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][nom]" : "Nom de la voie",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][complement]" : "Complément",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][codepostal]" : "Code postal",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][ville]" : "Ville",
                        "demande_ctvo[ctvo][acquerreur][adresseNewTitulaire][isHosted]" : "Hébergé(e)",
                        "demande_ctvo[ctvo][ancienTitulaire][type]" : "Ancien Titulaire",
                        "demande_ctvo[ctvo][ancienTitulaire][raisonSociale]" : "Raison sociale",
                        "demande_ctvo[ctvo][ciPresent]" : "Carte grise présente",
                        "demande_ctvo[ctvo][numeroFormule]" : "Numéro de formule",
                        "demande_ctvo[ctvo][ancienTitulaire][nomprenom]" : "Nom et prénom(s) de l'ancien titulaire",
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
                    
                    if (typeAncienTitulaire === "mor" && 0 <= $.inArray(name, societyAncienTitulaireArray)) {
                            html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + value + "</div>");
                    } else if (typeAncienTitulaire === "phy" && 0 <= $.inArray(name, physicAncientitulaireArray)) {
                            html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + value + "</div>");
                    } else if (typeNewTitulaire === "mor" && 0 <= $.inArray(name, societyNouveauxTitulaireArray)) {
                            html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + value + "</div>");
                    } else if (typeNewTitulaire === "phy" && 0 <= $.inArray(name, physicNouveauxTitulaireArray)) {
                            html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + value + "</div>");
                    } else if (0 <= $.inArray(name, otherNewTitulaireArray)) {
                            html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong>" + value + "</div>");
                    }   
                });
                resum.html(html.concat("<strong> Démarche </strong> : Changement Titulaire Véhicule d'Occasion Français <br>"));
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

                        if (check == "1") {
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
            "demande_ctvo[ctvo][acquerreur][lieuN]": {
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
            "demande_ctvo[ctvo][acquerreur][dateN]": {
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
            "demande_ctvo[ctvo][acquerreur][departementN]": {
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
            "demande_ctvo[ctvo][acquerreur][paysN]": {
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
                        let persone = $('#demande_ctvo_ctvo_acquerreur_type').val();

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
                required: true,
                digits: true,
                minlength: 5,
                maxlength: 5
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
            "demande_ctvo[ctvo][acquerreur][dateN]": {
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
                minlength: 'Le code postal doit être à 5 chiffres',
                maxlength: 'Le code postal doit être à 5 chiffres'
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