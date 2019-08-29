$(document).ready(function () {
    $('#francemap').vectorMap({
        map: 'france_fr',
        hoverOpacity: 0.7,
        hoverColor: false,
        backgroundColor: "#f9f9f9",
        colors: couleurs,
        borderColor: "#121212",
        selectedColor: "#325da7",
        enableZoom: false,
        showTooltip: true,
        onRegionClick: function (element, code, region) {
            let value = code.replace('fr-', '');
            value = value.toUpperCase();
            $('.departement_selectione').text(value + " - " + region);
            $('.departement_tarif').text(taxeArray['' + value+''] + " €");
            $('.departement_exoneration').text(exonerationArray[value] + " %");
            $('.departement_selectione_nom').text(region);
            $('#fr_departement').val(code);
            $('#fr_departement_first').val(code);
            $('.lien_pref').attr('href', '/prefecture/' + code);
        }
    });
});

$(document).ready(function () {
    $('.icon-mobile-menu').click(function(){
        $('#sidebar-container').toggleClass('show');
    });
});

function valueTreatement(value) {
    var valueArray = value.split("");
    if (valueArray.length === 7)
    {
        return value.slice(0, 2) + "-" + value.slice(2, 5) + "-" + value.slice(5, 7);
    } else if(valueArray.length === 9) {
        return value;
    }
    alert('Votre Numéro d\'immatriculation est incorrecte');

    return ""
    
}