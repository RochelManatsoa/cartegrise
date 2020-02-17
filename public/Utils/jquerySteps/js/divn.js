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
                let typeVehicule = "";
                let typeNewTitulaire = "";
                let typeCarrossier = "";
                let otherNewTitulaireArray = [
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][numero]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][extension]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][typevoie]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][nom]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][complement]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][codepostal]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][ville]",
                    "demande_divn[divn][acquerreur][adresseNewTitulaire][isHosted]",
                    "demande_divn[divn][vehicule][vin]",
                    "demande_divn[divn][vehicule][d1Marque]",
                    "demande_divn[divn][vehicule][d2Version]",
                    "demande_divn[divn][vehicule][z1Mention1]",
                    "demande_divn[divn][vehicule][z1Value]",
                    "demande_divn[divn][vehicule][g1PoidsVide]",
                    "demande_divn[divn][vehicule][f2MmaxTechAdm]",
                    "demande_divn[divn][vehicule][gMmaxAvecAttelage]",
                    "demande_divn[divn][vehicule][f2MmaxAdmServ]",
                    "demande_divn[divn][vehicule][derivVp]",
                    "demande_divn[divn][vehicule][j3Carrosserie]",
                    "demande_divn[divn][vehicule][s1NbPlaceAssise]",
                    "demande_divn[divn][vehicule][j1Genre]",
                ];
                let societyCarrossierArray = [
                    "demande_divn[divn][carrosier][typeCarrossier]",
                    "demande_divn[divn][carrosier][raisonSocialCarrossier]",
                    "demande_divn[divn][carrosier][agrement]",
                    "demande_divn[divn][carrosier][justificatifs]",
                ];
                let physicCarrossierArray = [
                    "demande_divn[divn][carrosier][typeCarrossier]",
                    "demande_divn[divn][carrosier][nomCarrosssier]",
                    "demande_divn[divn][carrosier][prenomCarrossier]",
                    "demande_divn[divn][carrosier][agrement]",
                    "demande_divn[divn][carrosier][justificatifs]",
                ];
                let societyNouveauxTitulaireArray = [
                    "demande_divn[divn][acquerreur][type]",
                    "demande_divn[divn][acquerreur][raisonSociale]",
                    "demande_divn[divn][acquerreur][siren]",
                    "demande_divn[divn][acquerreur][societeCommerciale]",
                ];
                let physicNouveauxTitulaireArray = [
                    "demande_divn[divn][acquerreur][type]",
                    "demande_divn[divn][acquerreur][nomPrenomTitulaire]",
                    "demande_divn[divn][acquerreur][prenomTitulaire]",
                    "demande_divn[divn][acquerreur][genre]",
                    "demande_divn[divn][acquerreur][dateN]",
                    "demande_divn[divn][acquerreur][lieuN]",
                    "demande_divn[divn][acquerreur][departementN]",
                    "demande_divn[divn][acquerreur][paysN]",
                    "demande_divn[divn][acquerreur][droitOpposition]",
                ];
                let nationalVehiculeArray = [
                    "demande_divn[divn][vehicule][type]",
                    "demande_divn[divn][vehicule][d3Denomination]",
                    "demande_divn[divn][vehicule][f3MmaxAdmEns]",
                    "demande_divn[divn][vehicule][jCategorieCe]",
                    "demande_divn[divn][vehicule][j2CarrosserieCe]",
                    "demande_divn[divn][vehicule][p1Cyl]",
                    "demande_divn[divn][vehicule][p3Energie]",
                    "demande_divn[divn][vehicule][p6PuissFiscale]",
                    "demande_divn[divn][vehicule][qRapportPuissMasse]",
                    "demande_divn[divn][vehicule][s2NbPlaceDebout]",
                    "demande_divn[divn][vehicule][u1NiveauSonore]",
                    "demande_divn[divn][vehicule][u2NbTours]",
                    "demande_divn[divn][vehicule][v7Co2]",
                    "demande_divn[divn][vehicule][v9ClasseEnvCe]",
                ];
                let communautaireVehiculeArray = [
                    "demande_divn[divn][vehicule][type]",
                    "demande_divn[divn][vehicule][kNumRecepCe]",
                    "demande_divn[divn][vehicule][dateReception]",
                    "demande_divn[divn][vehicule][d21Cenit]",
                ];
                data.forEach(element => {
                    if (element.name === "demande_divn[divn][vehicule][type]"){
                        typeVehicule = element.value;
                    } else if (element.name === "demande_divn[divn][acquerreur][type]"){
                        typeNewTitulaire = element.value;
                    }else if (element.name === "demande_divn[divn][carrosier][typeCarrossier]"){
                        typeCarrossier = element.value;
                    }
                    let name = element.name;
                    let value = element.value;

                    let label = {
                        "demande_divn[divn][acquerreur][type]" : "Titulaire",
                        "demande_divn[divn][acquerreur][raisonSociale]" : "Raison sociale",
                        "demande_divn[divn][acquerreur][siren]" : "SIREN",
                        "demande_divn[divn][acquerreur][societeCommerciale]" : "Société commerciale",
                        "demande_divn[divn][acquerreur][nomPrenomTitulaire]" : "Nom",
                        "demande_divn[divn][acquerreur][prenomTitulaire]" : "Prénom(s)",
                        "demande_divn[divn][acquerreur][genre]" : "Civilité",
                        "demande_divn[divn][acquerreur][dateN]" : "Date de naissance",
                        "demande_divn[divn][acquerreur][lieuN]" : "Lieu de naissance",
                        "demande_divn[divn][acquerreur][departementN]" : "Département de naissance",
                        "demande_divn[divn][acquerreur][paysN]" : "Pays de naissance",
                        "demande_divn[divn][acquerreur][droitOpposition]" : "Opposé(e) à la diffusion de ces données personnelles",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][numero]" : "Numéro de rue",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][extension]" : "Extension",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][typevoie]" : "Type de la voie",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][nom]" : "Nom de la voie",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][complement]" : "Complément",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][codepostal]" : "Code postal",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][ville]" : "Ville",
                        "demande_divn[divn][acquerreur][adresseNewTitulaire][isHosted]" : "Hébergé(e)",
                        "demande_divn[divn][vehicule][type]" : "Type de reception",
                        "demande_divn[divn][vehicule][d3Denomination]" : "Dénomination commerciale",
                        "demande_divn[divn][vehicule][f3MmaxAdmEns]" : "Masse en charge maximale admissible de l'ensemble en service (en kg)",
                        "demande_divn[divn][vehicule][jCategorieCe]" : "Catégorie du véhicule (CE)",
                        "demande_divn[divn][vehicule][j2CarrosserieCe]" : "Carrosserie (CE)",
                        "demande_divn[divn][vehicule][p1Cyl]" : "Cylindrée (en cm3)",
                        "demande_divn[divn][vehicule][p3Energie]" : "Type de carburant ou source d'énergie",
                        "demande_divn[divn][vehicule][p6PuissFiscale]" : "Puissance administrative nationale",
                        "demande_divn[divn][vehicule][qRapportPuissMasse]" : "Rapport puissance/masse kW/kg",
                        "demande_divn[divn][vehicule][s2NbPlaceDebout]" : "Nombre de places debout",
                        "demande_divn[divn][vehicule][u1NiveauSonore]" : "Niveau sonore à l'arrêt en dB(A)",
                        "demande_divn[divn][vehicule][u2NbTours]" : "Vitesse du moteur (en /min)",
                        "demande_divn[divn][vehicule][v7Co2]" : "CO2 (en g/Km)",
                        "demande_divn[divn][vehicule][v9ClasseEnvCe]" : "Classe environnementale de réception CE",
                        "demande_divn[divn][vehicule][kNumRecepCe]" : "Numéro de réception par type",
                        "demande_divn[divn][vehicule][dateReception]" : "Date de réception du véhicule",
                        "demande_divn[divn][vehicule][d21Cenit]" : "Code National d’Identification du Type",
                        "demande_divn[divn][vehicule][vin]" : "VIN du véhicule (champ E. sur la carte grise)",
                        "demande_divn[divn][vehicule][d1Marque]" : "Marque du véhicule",
                        "demande_divn[divn][vehicule][d2Version]" : "Type - Variant - Version",
                        "demande_divn[divn][vehicule][z1Mention1]" : "Mention spécifique (Z1)",
                        "demande_divn[divn][vehicule][z1Value]" : "Date limite de validité de la mention Z1",
                        "demande_divn[divn][vehicule][g1PoidsVide]" : "Poids à vide national",
                        "demande_divn[divn][vehicule][f2MmaxTechAdm]" : "Masse en charge maximale techniquement admissible",
                        "demande_divn[divn][vehicule][gMmaxAvecAttelage]" : "Masse du véhicule en service avec carrosserie et dispositif d'attelage",
                        "demande_divn[divn][vehicule][f2MmaxAdmServ]" : "Masse en charge maximale admissible en service (en kg): PTAC",
                        "demande_divn[divn][vehicule][derivVp]" : "Avec une carrosserie DERIV VP",
                        "demande_divn[divn][vehicule][j3Carrosserie]" : "Carrosserie (désignation nationale)",
                        "demande_divn[divn][vehicule][s1NbPlaceAssise]" : "Nombre de places assises",
                        "demande_divn[divn][vehicule][j1Genre]" : "Genre national",
                        "demande_divn[divn][carrosier][nomCarrosssier]" : "Nom du carrossier",
                        "demande_divn[divn][carrosier][prenomCarrossier]" : "Prénom(s) du carrossier",
                        "demande_divn[divn][carrosier][agrement]" : "Numéro d'Agrément du carrossier",
                        "demande_divn[divn][carrosier][justificatifs]" : "Les pièces justificatives attestant de la modification sont-elles présentes ?",
                        "demande_divn[divn][carrosier][typeCarrossier]" : "Carrossier",
                        "demande_divn[divn][carrosier][raisonSocialCarrossier]" : "Raison sociale du carrossier",
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
                    
                    if (typeVehicule === "1" && 0 <= $.inArray(name, nationalVehiculeArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (typeVehicule === "0" && 0 <= $.inArray(name, communautaireVehiculeArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (typeNewTitulaire === "mor" && 0 <= $.inArray(name, societyNouveauxTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (typeNewTitulaire === "phy" && 0 <= $.inArray(name, physicNouveauxTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (typeCarrossier === "mor" && 0 <= $.inArray(name, societyCarrossierArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (typeCarrossier === "phy" && 0 <= $.inArray(name, physicCarrossierArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    } else if (0 <= $.inArray(name, otherNewTitulaireArray)) {
                        html = html.concat("<div>" + "<strong>" + label[element.name] + "</strong><span>" + value + "</span></div>");
                    }   
                });
                resum.html(html.concat("<div><strong> Démarche </strong> <span>Immatriculation Véhicule Neuf</span></div>"));
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
            "demande_divn[divn][acquerreur][nomPrenomTitulaire]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_acquerreur_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][acquerreur][prenomTitulaire]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_acquerreur_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][acquerreur][dateN]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_acquerreur_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][acquerreur][lieuN]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_acquerreur_type').val();

                        if (persone == 'phy') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][acquerreur][raisonSociale]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_acquerreur_type').val();

                        if (persone == 'mor') {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][acquerreur][siren]": {
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
            "demande_divn[divn][vehicule][kNumRecepCe]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "0") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][dateReception]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "0") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][d21Cenit]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "0") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][d3Denomination]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][f3MmaxAdmEns]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][jCategorieCe]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][p3Energie]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][p6PuissFiscale]": {
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][s2NbPlaceDebout]":{
                required: {
                    depends: function () {
                        let persone = $('#demande_divn_divn_vehicule_type').val();

                        if (persone == "1") {
                            return true;
                        }
                        else {
                            return false;
                        }

                    }
                }
            },
            "demande_divn[divn][vehicule][g1PoidsVide]": {
                required: true
            },
            "demande_divn[divn][vehicule][f2MmaxTechAdm]": {
                required: true
            },
            "demande_divn[divn][vehicule][f2MmaxAdmServ]": {
                required: true
            },
            "demande_divn[divn][acquerreur][adresseNewTitulaire][codepostal]":{
              required : true,
              digits: true,
              minlength: 5,
              maxlength: 5,
            },
            "demande_divn[divn][acquerreur][adresseNewTitulaire][ville]":{
              required : true
            },
            "demande_divn[divn][vehicule][j1Genre]":{
              required : true
            }
        },
        messages:{
          "demande_divn[divn][acquerreur][nomPrenomTitulaire]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][prenomTitulaire]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][dateN]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][lieuN]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][raisonSociale]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][siren]": {
              required: 'Champs obligatoire',
              minlength: 'Le numéro doit être à 9 chiffres',
              maxlength: 'Le numéro doit être à 9 chiffres'
          },
          "demande_divn[divn][acquerreur][adresseNewTitulaire][codepostal]":{
            required: "Champs obligatoire",
            minlength: 'Le code postale doit être à 5 chiffres',
            maxlength: 'Le code postale doit être à 5 chiffres'
          },
          "demande_divn[divn][acquerreur][adresseNewTitulaire][ville]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][adresseNewTitulaire][nom]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][acquerreur][adresseNewTitulaire][numero]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][vin]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][d1Marque]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][d2Version]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][kNumRecepCe]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][dateReception]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][g1PoidsVide]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][f2MmaxTechAdm]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][f2MmaxAdmServ]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][d21Cenit]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][d3Denomination]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][f3MmaxAdmEns]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][jCategorieCe]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][s2NbPlaceDebout]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][p3Energie]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][p6PuissFiscale]":{
            required: "Champs obligatoire",
          },
          "demande_divn[divn][vehicule][z1Value]": {
            required: "Champs obligatoire"
          },
          "demande_divn[divn][vehicule][s1NbPlaceAssise]": {
            required: "Champs obligatoire"
          },
          "demande_divn[divn][vehicule][j1Genre]": {
            required: "Champs obligatoire"
          }
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
        changeYear: true,
        maxDate: (new Date(2003, 12 - 1, 26)),
    });
}