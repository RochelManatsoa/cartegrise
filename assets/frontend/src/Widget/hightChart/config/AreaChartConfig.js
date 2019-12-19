import React from 'react';

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
//             compiled = [...compiled, { name: key, inscriptions: 0, commandes: 1 }]
//             return;
//         }
//         let temp = compiled.find(data => data.name === key);
//         temp.commandes = temp.commandes + 1;
//     })
// }

const manageData = (datas, commandes) => {
    let compiled = [];
    commandes.map((item, i) => {
        let date = new Date(item.ceerLe);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find == undefined) {
            compiled = [...compiled, { name: key, inscriptions: 0, commandes: 1 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.commandes = temp.commandes + 1;
    })
    datas.map((item, i) => {
        let date = new Date(item.registerDate);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find == undefined) {
            compiled = [...compiled, { name: key, inscriptions: 1, demandes: 0 }]
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

