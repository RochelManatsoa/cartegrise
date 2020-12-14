$(function(){
    $('#sonata-ba-field-container-s6fe8771bb1_commande__partner').append('<button type="button" id="buttonAddPartner" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalPartner">Ajouter un partenariat</button><button type="button" id="something" class="btn btn-warning btn-sm mb-3 ml-3">Rafraîchir</button>');
    $('#sonata-ba-field-container-sb50d44505d_partner').append('<button type="button" id="buttonAddPartner" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalPartner">Ajouter un partenariat</button><button type="button" id="something" class="btn btn-warning btn-sm mb-3 ml-3">Rafraîchir</button>');
    $('#sonata-ba-field-container-sefe236040a_partner').append('<button type="button" id="buttonAddPartner" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalPartner">Ajouter un partenariat</button><button type="button" id="something" class="btn btn-warning btn-sm mb-3 ml-3">Rafraîchir</button>');
    initModal();

    $('#exampleModalPartner').on('show.bs.modal', function(event) {
        initUpdate();
    });

    $('#something').click(function() {
        location.reload();
    });
});

function initModal(){
    $('#buttonAddPartner').click(function(e) {
        e.preventDefault();
        $('#exampleModalPartner').modal('show');
    });
};

function initUpdate(){
    $('#savePartner').click(function(e) {
        e.preventDefault();
        var classError = $('.has-error');
        var span = $('.help-block');
        classError.removeClass("has-error");
        if (span) {
            span.remove();
        }
        form = $(this).parents('form');
        nom = form.find("input[name=nom]").val();
        description = form.find("textarea[name=description]").val();
        $.ajax({
            url: "/ajax/partner/add",
            method: "POST",
            data: {
                nom: nom,
                description: description
            },
            dataType: "json",
            success: function(data) {
                console.log(data)
                $("#myFormUpdate").removeClass("disabled");
                if (data.status != 200) {
                    var input = $('[name=nom]');
                    var span = $('<span class="help-block"></span>')
                    span.html(data.message);
                    input.parent().addClass('has-error');
                    input.parent().append(span);
                } else {
                    $("#savePartner").addClass("disabled");
                    $('#exampleModalPartner').modal('hide');
                }
            }
        });
        return false;
    });

    $('#closeModal').click(function(e){
        $('#exampleModalPartner').modal('hide');
    });
}
