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
                let typeTitulaire = "";
                let motifsDemande = "";
                let otherTitulaireArray = [
                    "demande_duplicata[duplicata][numeroFormule]",
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
                    "demande_duplicata[duplicata][motifDemande]",
                    "demande_duplicata[duplicata][datePerte]",
                ];
                let otherMotifDemandeArray = [
                    "demande_duplicata[duplicata][motifDemande]",
                ];
                data.forEach(element => {
                    if (element.name === "demande_duplicata[duplicata][titulaire][type]"){
                        typeTitulaire = element.value;
                    } else if (element.name === "demande_duplicata[duplicata][motifDemande]"){
                        motifsDemande = element.value;
                    }
                    let name = element.name;
                    
                    if (typeTitulaire === "mor" && 0 <= $.inArray(name, motifDemandePerteArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (typeTitulaire === "phy" && 0 <= $.inArray(name, otherMotifDemandeArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (motifsDemande === "PERT" && 0 <= $.inArray(name, societyTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (motifsDemande ==! "PERT" && 0 <= $.inArray(name, physicTitulaireArray)) {
                        html = html.concat(element.name + " ==> " + element.value + "<br>");
                    } else if (0 <= $.inArray(name, otherTitulaireArray)) {
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
                digits: true,
                minlength: 11,
                maxlength: 11,
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
                minlength: 'Le numéro doit être à 11 chiffres',
                maxlength: 'Le numéro doit être à 11 chiffres'
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