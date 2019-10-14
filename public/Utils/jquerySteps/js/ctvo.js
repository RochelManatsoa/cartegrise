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
                }
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