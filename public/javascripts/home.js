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
