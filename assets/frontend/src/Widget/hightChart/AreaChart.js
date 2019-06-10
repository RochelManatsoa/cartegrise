import React, { Component } from 'react';
import {
    AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer,
} from 'recharts';
import config from './config/AreaChartConfig';

class AreaChartClass extends Component {

    constructor(props)
    {
        super(props);
        this.state = {
            datas : [{name: 0, inscriptions:0}]
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
        if (this.props.datas === nextProps.datas)
            return false;

        let managed = config.manageData(nextProps.datas);
        this.updateStateDatas(managed);
        return true;
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
