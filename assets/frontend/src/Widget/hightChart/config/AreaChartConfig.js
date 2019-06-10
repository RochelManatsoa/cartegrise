import React from 'react';

const convertDate = (date) =>
{
    let converted = date.getFullYear() + '-'
        + ('0' + date.getMonth()).slice(-2) + '-'
        + ('0' + date.getDate()).slice(-2);

    return converted;
}

const manageData = (datas) => {
    let compiled = [];
    datas.map((item, i) => {
        let date = new Date(item.registerDate);
        let key = convertDate(date);
        let find = compiled.find(data => data.name === key)
        if (find == undefined) {
            compiled = [...compiled, { name: key, inscriptions: 1 }]
            return;
        }
        let temp = compiled.find(data => data.name === key);
        temp.inscriptions = temp.inscriptions + 1;
    })

    return compiled;
}

export default { convertDate, manageData};

