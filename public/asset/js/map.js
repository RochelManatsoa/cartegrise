$(document).ready(function() {
$('#francemap').vectorMap({
    map: 'france_fr',
  hoverOpacity: 0.5,
  hoverColor: false,
  backgroundColor: "#ffffff",
  colors: couleurs,
  borderColor: "#000000",
  selectedColor: "#EC0000",
  enableZoom: true,
  showTooltip: true,
    onRegionClick: function(element, code, region)
    {
window.location.assign("http://localhost/CGofficiel/Tarif-departements/" + region)
    }
});
});
