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
            var dep = slugify(region);
            var depart = dep;
            var valueDep = value;
            if (dep == "cote-dor") {
                depart = "cote-d-or";
            } else if (dep == "meurthe-et-moselle") {
                depart = "meurhe-et-moselle";
            } else if (dep == "haut-rhin") {
                valueDep = 67;
            } else if (dep == "cotes-darmor") {
                depart = "cotes-d-armor";
            } else if (dep == "la-reunion" || dep == "guyane" || dep == "guadeloupe" || dep == "martinique") {
                depart = 'departement-' + dep;
            }
            $('.departement_selectione').text(value + " - " + region);
            $('.departement_tarif').text(taxeArray['' + value + ''] + " €");
            $('.departement_exoneration').text(exonerationArray[value] + " %");
            $('.departement_selectione_nom').text(region);
            $('#fr_departement').val(code);
            $('#fr_departement_first').val(code);
            $('.lien_pref').attr('data-link', 'http://www.' + dep + '.gouv.fr');
            $('.target_blank').attr('target', '_blank');
            $('.src_img').attr('src', 'https://www.regions-et-departements.fr/images/logos-departements/' + valueDep + '-logo-' + depart + '.png');
            $('.lien_pref').on('click', function(){
                e.preventDefault();
                console.log($(this));
            });
        },
        onRegionOver: function (element, label, region) {
            //alert(element.type);
            //console.log(label);
            // label.html('<div class="map-tooltip"><h1 class="header">' + region + '</h1><p class="description">Some Description</p></div>');
        },
        onRegionOut: function (event, code, region) {
            event.preventDefault();
        }
    });
});