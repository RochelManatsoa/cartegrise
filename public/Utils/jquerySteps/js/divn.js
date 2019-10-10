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
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
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
            if (currentIndex === 3 && Number($("#age-2").val()) >= 18) {
                form.steps("next");
            }
            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3) {
                form.steps("previous");
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
              required : true
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
          "demande_divn[divn][acquerreur][adresseNewTitulaire][codepostal]":{
            required: "Champs obligatoire",
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
        changeYear: true
    });
}