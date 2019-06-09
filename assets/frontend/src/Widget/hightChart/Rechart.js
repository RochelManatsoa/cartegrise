import React ,{ Component} from 'react';
import { PieChart, Pie, Sector, Cell, Legend } from 'recharts';
import axios from 'axios';


const data = [{ name: 'Group A', value: 400 }, { name: 'Group B', value: 300 },
{ name: 'Group C', value: 300 }, { name: 'Group D', value: 200 }];

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
            <text x={cx} y={cy} dy={8} textAnchor="middle" fill={fill}>{payload.name}</text>
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
                {`Nombres: ${value}`}
            </text>
            <text x={ex + (cos >= 0 ? 1 : -1) * 12} y={ey} dy={18} textAnchor={textAnchor} fill="#999">
                {`(Pourcentage: ${(percent * 100).toFixed(2)}%)`}
            </text>
        </g>
    );
};

const colors = ['#0088FE', '#00C49F', '#FFBB28', '#FF8042'];

class TwoLevelPieChart extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            activeIndex: 0,
            datas: [
                { name: "Attente de Demande", value: 1 },
                { name: "Attende de Paiement", value: 0 },
                { name: "Paiement Refuser", value: 0 },
                { name: "Paiement Accepté", value: 0 }
            ],
            data: [
                { name: "Attente de Demande", value: 1 },
                { name: "Attende de Paiement", value: 0 },
                { name: "Paiement Refuser", value: 0 },
                { name: "Paiement Accepté", value: 0 }
            ]
        }
        this.onPieEnter = this.onPieEnter.bind(this);
        this.dataManager = this.dataManager.bind(this);
    }

    componentDidMount() {
        axios({
            method: 'get',
            url: 'https://127.0.0.1:8000/api/commandes',
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(commandeEntries => {
            commandeEntries.data.map((item, i) => {
                this.dataManager(item);
            });
        }).then(() => {
            this.setState({
                data: this.state.datas
            });
        });
    }

    dataManager(item) {
        if (item.demande === null) {
            let data = [...this.state.datas];
            data[0].value = data[0].value + 1;
            this.setState({
                datas: [...this.state.datas]
            })
            return;
        }
        else if (item.demande.transaction === null) {
            let data = [...this.state.datas];
            data[1].value = data[1].value + 1;
            this.setState({
                datas: [...this.state.datas]
            })
            return;
        } else if (item.demande.transaction.status !== '00') {
            let data = [...this.state.datas];
            data[2].value = data[2].value + 1;
            this.setState({
                datas: [...this.state.datas]
            })
            return;
        }
        let data = [...this.state.datas];
        data[3].value = data[3].value + 1;
        this.setState({
            datas: [...this.state.datas]
        })

        return;
    }

    onPieEnter(data, index) {
        this.setState({
            activeIndex: index,
        });
    }

    render() {
        return (
            <div>
                <PieChart width={800} height={400}>
                    <Legend verticalAlign="bottom" height={36} />
                    <Pie
                        activeIndex={this.state.activeIndex}
                        activeShape={renderActiveShape}
                        data={this.state.data}
                        cx={300}
                        cy={200}
                        innerRadius={60}
                        outerRadius={80}
                        onMouseEnter={this.onPieEnter}
                    >
                        {
                            data.map((entry, index) => (
                                <Cell key={`cell-${index}`} fill={colors[index]} />
                            ))
                        }
                    </Pie>
                </PieChart>
            </div>
        );
    }
}

export default TwoLevelPieChart;