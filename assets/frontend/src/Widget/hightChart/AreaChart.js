import React, { Component } from 'react';
import {
    AreaChart, LineChart, Line, Area, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer,
} from 'recharts';
import config from './config/AreaChartConfig';

class AreaChartClass extends Component {

    constructor(props)
    {
        super(props);
        this.state = {
            datas : [{name: 0, inscriptions:0, estimations: 0, paniers: 0}]
        };
        this.updateStateDatas = this.updateStateDatas.bind(this);
    }

    updateStateDatas(managed){
        this.setState({
            datas: managed
        })
    }

    componentWillUpdate(nextProps, nextState)
    {
        if (this.props.datas !== nextProps.datas){
            let managed = config.manageData(nextProps.datas, nextProps.estimations, nextProps.paniers);
            this.updateStateDatas(managed);
            return true;
        }

        if (this.props.estimations !== nextProps.estimations) {
            let managed = config.manageData(nextProps.datas, nextProps.estimations, nextProps.paniers);
            this.updateStateDatas(managed);
            return true;
        }

        if (this.props.paniers !== nextProps.paniers) {
            let managed = config.manageData(nextProps.datas, nextProps.estimations, nextProps.paniers);
            this.updateStateDatas(managed);
            return true;
        }

        return false;
    }

    getTemplate(type){
        let template = null;
        switch(type){
            case 'Area1':
                template = 
                    <div style={{
                        width: '100%', height: this.props.height || 400,
                        background: this.props.background || 'white',
                        borderRadius: this.props.borderRadius || '0'
                    }}
                    >
                        <ResponsiveContainer>
                            <AreaChart
                                data={this.state.datas}
                                margin={{
                                    top: 5, right: 30, left: 20, bottom: 5,
                                }}
                            >
                                <CartesianGrid strokeDasharray="3 3" />
                                <XAxis dataKey="name" />
                                <YAxis />
                                <Tooltip />
                                <Legend />
                                <Area type="monotone" dataKey="inscriptions" stroke="#8884d8" dot />
                            </AreaChart>
                        </ResponsiveContainer>
                    </div>
                break;
            case 'Area2':
                console.log(this.state.datas);
                template = 
                    <div style={{
                        width: '100%', height: this.props.height || 400,
                        background: this.props.background || 'white',
                        borderRadius: this.props.borderRadius || '0'
                    }}
                    >
                        <ResponsiveContainer>
                            <LineChart
                                width={500}
                                height={400}
                                data={this.state.datas}
                                margin={{
                                    top: 10, right: 30, left: 0, bottom: 0,
                                }}
                            >
                                <CartesianGrid strokeDasharray="3 3" />
                                <XAxis dataKey="name" />
                                <YAxis />
                                <Tooltip />
                                <Line type="line" dataKey="inscriptions" dot={false} stackId="1" strokeWidth="3" stroke="#8884d8" fill="#8884d8" />
                                <Line type="line" dataKey="estimations" dot={false} stackId="1" strokeWidth="3" stroke="#f39b11" fill="#f39b11" />
                                <Line type="line" dataKey="paniers" dot={false} stackId="1" strokeWidth="3" stroke="#00C49F" fill="#00C49F" />
                            </LineChart>
                        </ResponsiveContainer>
                    </div>
                break;
            default:
                break;
        }

        return template;
    }

    render() {
        return (
            <div className="col-md-12" style={{paddingTop:this.props.paddingTop}}>
                {this.getTemplate(this.props.type)}
            </div>
        );
    }
}

export default AreaChartClass ;
