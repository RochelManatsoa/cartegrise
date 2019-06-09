import React, {Component} from 'react';
import { VictoryPie, VictoryTheme, VictoryChart, VictoryLegend, VictoryGroup } from 'victory';
import axios from 'axios';

class Chart extends Component
{
    constructor(props)
    {
        super(props);
        this.state={
            datas: [ 
                {x: 0,y: 1, label: "Attente de Demande"},
                {x: 0,y: 0, label: "Attende de Paiement"}, 
                {x: 0,y: 0, label: "Paiement Refuser"}, 
                {x: 0,y: 0, label: "Paiement Accepté"}
            ],
            datasLabel: [ 
                {name: 'Attente de Demande'},
                {name: 'Attende de Paiement'}, 
                {name: 'Paiement Refuser'}, 
                {name: 'Paiement Accepté'}
            ],

        }
        this.dataManager = this.dataManager.bind(this);
    }

    dataManager(item){
        if (item.demande === null) {
            let data = [...this.state.datas];
            data[0].y = data[0].y +1;
            this.setState({
                datas: [...this.state.datas]
            })
            return ;
        } 
        else if (item.demande.transaction === null) {
            let data = [...this.state.datas];
            data[1].y = data[1].y + 1;
            this.setState({
                datas: [...this.state.datas]
            })
            return;
        } else if (item.demande.transaction.status !== '00') {
            let data = [...this.state.datas];
            data[2].y = data[2].y + 1;
            this.setState({
                datas: [...this.state.datas]
            })
            return;
        }
        let data = [...this.state.datas];
        data[3].y = data[3].y + 1;
        this.setState({
            datas: [...this.state.datas]
        })

        return;
    }

    componentDidMount()
    {
        axios({
            method: 'get',
            url: 'https://127.0.0.1:8000/api/commandes',
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(commandeEntries => {
            commandeEntries.data.map((item,i) => {
                this.dataManager(item);
            });
        }).then(()=>{
            setTimeout(()=> {
                this.setState({
                    data:this.state.datas
                });
            }, 2000);
        });
    }

    render () {
        return (
            <div className={`col-md-${this.props.col}`}>
                
                    <VictoryPie
                    padAngle={1}
                    innerRadius={10}
                    titl="Comandes"
                    // labelPosition="endAngle"
                    labelPlacement="vertical"
                    labelRadius={60}
                    animate={{ duration: 2000 }}
                    data={this.state.datas}
                    theme={VictoryTheme.material}
                    style={
                        {
                            labels:{
                                fontSize: 5,
                            }
                        }
                    }
                    />
            </div>
        )
    };  
    
}

export default Chart;