import React, {Component} from 'react';
import ReactHighChart from 'react-highcharts';
import Highcharts from 'highcharts';

class Chart extends Component
{
    constructor(props)
    {
        super(props);
        this.state={
            datas: props.dataCommandeHighchart,
            testData: [
                ['Shanghai', 0],
                ['Beijing', 0],
                ['Karachi', 0],
                ['Shenzhen', 0],
                ['Guangzhou', 0]
            ]
        }
    }

    manageOptions(){
        let option = {
    chart: {
        type: 'column'
    },
    title: {
        text: 'World\'s largest cities per 2017'
    },
    subtitle: {
        text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
    },
    
    series: [{
        name: 'Population',
        data: this.state.testData,
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
};
        return option;
    }

    render () {

        setTimeout(() => {
            this.setState({
                testData: [
                    ['Shanghai', 24.2],
                    ['Beijing', 20.8],
                    ['Karachi', 14.9],
                    ['Shenzhen', 13.7],
                    ['Guangzhou', 13.1]
                ]
            })
        }, 3000);
        return (
            <div className={`col-md-${this.props.col}`}>
                <ReactHighChart 
                    ref='chart' 
                    config={this.manageOptions()}
                />
            </div>
        )
    };  
    
}

export default Chart;