import React, {Component} from 'react'
import { VictoryPie, VictoryTheme } from 'victory';

class MyResponsivePie extends Component
{
    constructor(props)
    {
        super(props);

        this.state= {
            data: [
                { x: "Cats", y: 0.1 },
                { x: "Dogs", y: 0.1 },
                { x: "Birds", y: 20 }
            ]
        }
    }
    render(){
        setTimeout(() => {
            this.setState({
                data: [
                    { x: "Cats", y: 14 },
                    { x: "Dogs", y: 12 },
                    { x: "Birds", y: 34 }
                ]
            })
        }, 1000);
        return (
            <div>
                <VictoryPie
                animate={{ duration: 2000 }}
                    data={this.state.data}
                    theme={VictoryTheme.material}
                />
            </div>
        )
    } 
};

export default MyResponsivePie;