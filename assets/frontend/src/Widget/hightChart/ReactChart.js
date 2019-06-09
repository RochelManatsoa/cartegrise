import React, {Component} from 'react';
import { Doughnut } from 'react-chartjs-2';

class Chart extends Component
{
    constructor(props)
    {
        super(props);
        this.state={
            datas: {}
        }

        this.mountAfter = this.mountAfter.bind(this)
    }

    mountAfter()
    {
        let datas = {labels: [
                    'Red',
                    'Green',
                    'Yellow'
                ],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                    ],
                    hoverBackgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                    ]
                }]};
        this.setState({
            datas
        })
        
    }

    render () {
        setTimeout(()=> {
            this.mountAfter();
        }, 3000);
        return (
            <div className={`col-md-${this.props.col}`}>
                <Doughnut 
                ref='chart' 
                data={this.state.datas}
                />
            </div>
        )
    };  
    
}

export default Chart;