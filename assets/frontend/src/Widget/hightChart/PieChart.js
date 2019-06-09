import React, { PureComponent} from 'react';
import PieDonut from './PieComponent/PieDonut'


class RechartPie extends PureComponent
{
    constructor(props) {
        super(props);
        this.state = {
            activeIndex: 0,
            datas: [
                { name: "Attente de Demande", value: 0 },
                { name: "Attende de Paiement", value: 0 },
                { name: "Paiement Refuser", value: 0 },
                { name: "Paiement Accepté", value: 0 }
            ],
            colors: this.props.colors || ['#0088FE', '#00C49F', '#FFBB28', '#FF8042']
        }
        this.onPieEnter = this.onPieEnter.bind(this);
        this.dataManager = this.dataManager.bind(this);
    }

    componentWillMount(){
        console.log(this.props);
    }

    component(){
        console.log(this.props)
    }

    componentWillUpdate(nextProps, nextState) {
        if (this.props === nextProps)
            return false;
        console.log(nextProps);
        nextProps.datas.map((item, key) => {
            this.dataManager(item)
        })
        
        return true;
    }
    
    dataManager(item) {
        if (item.demande === null || item.demande === undefined) {
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
            <div className={`col-md-${this.props.col}`}>
                <PieDonut
                    activeIndex={this.state.activeIndex}
                    height={this.props.height}
                    datas={this.state.datas}
                    onPieEnter={this.onPieEnter}
                    colors={this.state.colors}
                />
            </div>
        );
    }
}

export default RechartPie;