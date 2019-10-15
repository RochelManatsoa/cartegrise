function initFormStep(form, title, bodyTag, transitionEffect) {
    var form = form.show();
    title = title || "h3";
    bodyTag = bodyTag || "fieldset";
    transitionEffect = transitionEffect || "slideLeft";

    form
        .steps({
            headerTag: title,
            bodyTag: bodyTag,
            transitionEffect: transitionEffect,
            onStepChanging: function(event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                console.log(currentIndex, newIndex);
                /*if (currentIndex === 0 && newIndex === 1) { 
                }*/
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
            onStepChanged: function(event, currentIndex, priorIndex) {
                // Used to skip the "Warning" step if the user is old enough.
                if (currentIndex === 3 && Number($("#age-2").val()) >= 18) {
                    form.steps("next");
                }
                // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3) {
                    form.steps("previous");
                }
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                alert("Submitted!");
            }
        })
        .validate({
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
                    }
                },
                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][extension]": {
                    required: true,
                    maxlength: 3,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][complement]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][ville]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][isHosted]": {
                    required: true,
                },
                /**PARTIE 03 NOUVELLE ADRESSE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][isHosted]": {
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
                },
                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][extension]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][complement]": {
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
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: "Champs obligatoire",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
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