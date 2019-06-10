import React from 'react'
import { Sector } from 'recharts';

const labelPercent='Pourcent';
const labelNombre='Nombre'

const renderActiveShape = (props) => {
    const RADIAN = Math.PI / 180;
    const { cx, cy, midAngle, innerRadius, outerRadius, startAngle, endAngle,
        fill, payload, percent, value } = props;
    const sin = Math.sin(-RADIAN * midAngle);
    const cos = Math.cos(-RADIAN * midAngle);
    const sx = cx + (outerRadius + 10) * cos;
    const sy = cy + (outerRadius + 10) * sin;
    const mx = cx + (outerRadius + 30) * cos;
    const my = cy + (outerRadius + 30) * sin;
    const ex = mx + (cos >= 0 ? 1 : -1) * 22;
    const ey = my;
    const textAnchor = cos >= 0 ? 'start' : 'end';

    return (
        <g>
            <text x={cx} y={cy} dy={8} textAnchor="middle" fill={fill} style={{ fontSize: 15 }} >{payload.centerLabel || payload.name}</text>
            <Sector
                cx={cx}
                cy={cy}
                innerRadius={innerRadius}
                outerRadius={outerRadius}
                startAngle={startAngle}
                endAngle={endAngle}
                fill={fill}
            />
            <Sector
                cx={cx}
                cy={cy}
                startAngle={startAngle}
                endAngle={endAngle}
                innerRadius={outerRadius + 6}
                outerRadius={outerRadius + 10}
                fill={fill}
            />
            <path d={`M${sx},${sy}L${mx},${my}L${ex},${ey}`} stroke={fill} fill="none" />
            <circle cx={ex} cy={ey} r={2} fill={fill} stroke="none" />
            <text x={ex + (cos >= 0 ? 1 : -1) * 12} y={ey} textAnchor={textAnchor} fill="#333">
                {`${labelNombre}: ${value}`}
            </text>
            <text x={ex + (cos >= 0 ? 1 : -1) * 12} y={ey} dy={18} textAnchor={textAnchor} fill="#999">
                {`(${labelPercent}: ${(percent * 100).toFixed(2)}%)`}
            </text>
        </g>
    );
};


const dataManagerComandePaiment = (item, data) => {
    if (item.demande === null || item.demande === undefined) {
        data = [...data];
        data[0].value = data[0].value + 1;

        return data;
    }
    else if (item.demande.transaction === null) {
        data = [...data];
        data[1].value = data[1].value + 1;

        return data;
    } else if (item.demande.transaction.status !== '00') {
        data = [...data];
        data[2].value = data[2].value + 1;

        return data;
    }
    data = [...data];
    data[3].value = data[3].value + 1;

    return data;
}
const dataManagerComandeType = (item, data) => {
    if (item.demarche.type === "DUP") {
        data = [...data];
        data[0].value = data[0].value + 1;
        data[0].type = 'DUP';
        data[0].centerLabel = 'DUP';
        return data;
    }
    else if (item.demarche.type === "DIVN") {
        data = [...data];
        data[1].value = data[1].value + 1;
        data[1].type = 'DIVN';
        data[1].centerLabel = 'DIVN';
        return data;
    } else if (item.demarche.type === "CTVO") {
        data = [...data];
        data[2].value = data[2].value + 1;
        data[2].type = 'CTVO';
        data[2].centerLabel = 'CTVO';
        return data;
    }
    else if (item.demarche.type === "DCA") {
        data = [...data];
        data[3].value = data[2].value + 1;
        data[3].type = 'DCA';
        data[3].centerLabel = 'DCA';
        return data;
    }
    else if (item.demarche.type === "DC") {
        data = [...data];
        data[4].value = data[2].value + 1;
        data[4].type = 'DC';
        data[4].centerLabel = 'DC';

        return data;
    }

    return data;
}


////for export all foncig statics

export default { renderActiveShape, dataManagerComandePaiment, dataManagerComandeType};