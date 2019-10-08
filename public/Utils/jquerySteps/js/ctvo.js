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
            console.log(currentIndex, newIndex);
            if(currentIndex == 0 && newIndex == 1){
                if($('#demande_ctvo_ctvo_ancienTitulaire_type').val() == 'phy'){
                    // var nomprenom = $('[name="demande_ctvo[ctvo][acquerreur][prenomTitulaire]"]');
                    // console.log(nomprenom);

                    /* 
                    tsy mety aminy pory mintsy le name misy crochet io
                    */

                    $("#example-advanced-form").validate({
                        rules: {
                            'demande_ctvo[ctvo][ancienTitulaire][nomprenom]': {
                                required: true
                            }
                        },
                        messages: {
                            'demande_ctvo[ctvo][ancienTitulaire][nomprenom]': {
                                required: 'Ce champs est requis'
                            }
                        }
                    });

                    return false;
                }else{
                    $("#example-advanced-form").validate({
                        rules: {
                            'demande_ctvo[ctvo][ancienTitulaire][raisonsociale]': {
                                required: true
                            }
                        },
                        messages: {
                            'demande_ctvo[ctvo][ancienTitulaire][raisonsociale]': {
                                required: 'Ce champs est requis'
                            }
                        }
                    });

                    return false;
                };
            }
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
            confirm: {
                equalTo: "#password-2"
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