
function valueTreatement(value) {
    var valueArray = value.split("");
    if (valueArray.length === 7) {
        return value.slice(0, 2) + "-" + value.slice(2, 5) + "-" + value.slice(5, 7);
    } else if (valueArray.length === 8) {
        return value.slice(0, 4) + "-" + value.slice(4, 6) + "-" + value.slice(6, 8);
    }else if (valueArray.length === 9 || valueArray.length === 10) {
        return value;
    }
    alert('Votre Numéro d\'immatriculation est incorrecte');

    return ""
}