
const convertDate = (date) =>
{
    let converted = date.getFullYear() + '-'
        + ('0' + (date.getMonth()+1)).slice(-2) + '-'
        + ('0' + date.getDate()).slice(-2);

    return converted;
}
// const convertData = (data) => {
//     data.map((item, i) => {
//         let date = new Date(item.ceerLe);
//         let key = convertDate(date);
//         let find = compiled.find(data => data.name === key)
//         if (find == undefined) {
//             compiled = [...compiled, { name: key, inscriptions: 0, estimations: 1 }]
//             return;
//         }
//         let temp = compiled.find(data => data.name === key);
//         temp.estimations = temp.estimations + 1;
//     })
// }

const manageData = (datas, estimations, paniers, factures) => {
    let compiled = [];
    paniers.map((item, i) => {
        let date = new Date(item.dateDemande);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find === undefined) {
            compiled = [...compiled, { name: key, inscriptions: 0, estimations: 0, dossiers: 1, paiements: 0 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.dossiers = temp.dossiers + 1;
    })

    estimations.map((item, i) => {
        let date = new Date(item.ceerLe);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find === undefined) {
            compiled = [...compiled, { name: key, inscriptions: 0, estimations: 1, dossiers: 0, paiements: 0 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.estimations = temp.estimations + 1;
    })

    factures.map((item, i) => {
        let date = new Date(item.createdAt);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find === undefined) {
            compiled = [...compiled, { name: key, inscriptions: 0, estimations: 0, dossiers: 0, paiements: 1 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.paiements = temp.paiements + 1;
    })

    datas.map((item, i) => {
        let date = new Date(item.registerDate);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find === undefined) {
            compiled = [...compiled, { name: key, inscriptions: 1, estimations: 0, dossiers: 0, paiements: 0 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.inscriptions = temp.inscriptions + 1;
    })

    compiled.sort(function (a, b) {
        var keyA = new Date(a.name),
            keyB = new Date(b.name);
        // Compare the 2 dates
        if (keyA < keyB) return -1;
        if (keyA > keyB) return 1;
        return 0;
    });

    return compiled;
}

export default { convertDate, manageData};

