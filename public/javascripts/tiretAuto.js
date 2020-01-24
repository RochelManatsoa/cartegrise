
function valueTreatement(value) {
	var ua = new UAParser();
	var result = ua.getResult();
    var valueArray = value.split("");
    if (result.device.vendor !== "Samsung"){
        if (valueArray.length === 7) {
            return value.slice(0, 2) + "-" + value.slice(2, 5) + "-" + value.slice(5, 7);
        } else if (valueArray.length === 9) {
            return value;
        }
        alert('Votre Numéro d\'immatriculation est incorrecte');
    
        return ""
    } else {
        alert('Vous êtes sur samsung?!');
        return value;
    }
}