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
                if (currentIndex === 0 && newIndex === 1) {
                    //code

                }
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
                /**PARTIE 01 TITULAIRE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]": {
                    required: true,
                    minlength: 3,
                    maxlength: 120,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]": {
                    required: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][droitOpposition]": {
                    required: true
                },

                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: true,
                    number: true,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][extension]": {
                    required: true,
                    maxlength: 3,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][complement]": {
                    required: true,
                    minlength: 4,
                    maxlength: 120,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]": {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][ville]": {
                    required: true,
                    minlength: 4,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][isHosted]": {
                    required: true,
                },

                /**PARTIE 03 NOUVELLE ADRESSE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]": {
                    required: true,
                    number: true,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]": {
                    required: true,
                    maxlength: 3,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: true,
                    minlength: 3,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]": {
                    required: true,
                    minlength: 3,
                    maxlength: 120,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
                    required: true,
                    minlength: 4,
                    maxlength: 60,
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][isHosted]": {
                    required: true,
                },

            },
            messages: {
                /**PARTIE 01 TITULAIRE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][nomPrenomTitulaire]": {
                    required: "Le nom et prénom séparés par un espace ne doit pas être vide!",
                    minlength: "Le nom et prénom séparés par un espace est trop court!",
                    maxlength: "Le nom et prénom séparés par un espace est trop long!"
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][birthName]": {
                    required: "Le nom du titulaire ne doit pas être vide!",
                    minlength: "Le nom du titulaire est trop court!",
                    maxlength: "Le nom du titulaire est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][prenomTitulaire]": {
                    required: "Ce prénom(s) ne doit pas être vide!",
                    minlength: "Votre prénom(s) est trop court!",
                    maxlength: "Votre prénom(s) est trop long!"
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][dateN]": {
                    required: "Ce champ ne doit pas être vide!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][lieuN]": {
                    required: "Le lieu de naissance ne doit pas être vide",
                    minlength: "Le lieu de naissance est trop court",
                    maxlength: "Le lieu de naissance est trop long",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][paysN]": {
                    required: "Le pays ne doit pas être vide",
                    minlength: "Le pays est trop court!",
                    maxlength: "Le pays est trop long!"
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][droitOpposition]": {
                    required: ""
                },

                /**PARTIE 02 ANCIENNE ADRESSE */
                "demande_changement_adresse[changementAdresse][ancienAdresse][numero]": {
                    required: "Ce champ ne doit pas être vide!",
                    number: "Le numéro de la voie est invalide!",
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][extension]": {
                    required: "Ce champ ne doit pas être vide!",
                    maxlength: "L'extension que vous avez entré est trop long!"

                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][nom]": {
                    required: "Le nom de la voie ne doit pas être vide!",
                    minlength: "Le nom de la voie est trop court!",
                    maxlength: "Le nom de la voie est trop long!"
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][complement]": {
                    required: "Le complément d'adresse ne doit pas être vide!",
                    minlength: "Le complément d'adresse est trop court!",
                    maxlength: "Le complément d'adresse est trop long!"
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][codepostal]": {
                    required: "Le code postal ne doit pas être vide!",
                    minlength: "Votre code postal est trop court!",
                    maxlength: "Votre code postal est trop long!"

                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][ville]": {
                    required: "Ce champ ne doit pas être vide!",
                    minlength: "Votre ville est trop court!",
                    maxlength: "Votre ville est trop long!"
                },
                "demande_changement_adresse[changementAdresse][ancienAdresse][isHosted]": {
                    required: "",
                },

                /**PARTIE 03 NOUVELLE ADRESSE */
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][numero]": {
                    required: "Ce champ ne doit pas être vide!",
                    number: "Le numéro de la voie est invalide!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][extension]": {
                    required: "L'extension au numéro de rue ne doit pas être vide!",
                    maxlength: "L'extension au numéro de rue est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][nom]": {
                    required: "Le nom de la voie ne doit pas être vide!",
                    minlength: "Le nom de la voie est trop court!",
                    maxlength: "Le nom de la voie est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][complement]": {
                    required: "Ce champ ne doit pas être vide!",
                    minlength: "Le complément d'adresse est trop court!",
                    maxlength: "Le complément d'adresse est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][codepostal]": {
                    required: "Le code postal ne doit pas être vide!",
                    minlength: "Votre code postal est trop court!",
                    maxlength: "Votre code postal est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][ville]": {
                    required: "Ce champ ne doit pas être vide!",
                    minlength: "La ville est trop court!",
                    maxlength: "La ville est trop long!",
                },
                "demande_changement_adresse[changementAdresse][nouveauxTitulaire][adresseNewTitulaire][isHosted]": {
                    required: "",
                },

            }
        });
}