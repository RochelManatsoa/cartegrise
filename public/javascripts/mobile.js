function valueTreatement(value) {
    var valueArray = value.split("");
    if (valueArray.length === 9) {
        return value;
    }
    alert('Votre Numéro d\'immatriculation est incorrecte');

    return ""
}