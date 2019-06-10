import React, { PureComponent} from 'react';
import PieDonut from './PieComponent/PieDonut'
import config from './config/PieChartConfig'


class RechartPie extends PureComponent
{
    constructor(props) {
        super(props);
        this.state = {
            activeIndex: 0,
            datas: [],
            colors: this.props.colors || ['#0088FE', '#00C49F', '#FFBB28', '#FF8042', '#605CA8']
        }
        this.onPieEnter = this.onPieEnter.bind(this);
        this.updateDatasState = this.updateDatasState.bind(this);
    }

    updateDatasState(datas){
        this.setState({
            datas
        })
    }

    componentWillUpdate(nextProps, nextState) {
        if (this.props === nextProps)
            return false;
        // do update
        let datas = [];
        switch (this.props.case){
            case 'commandPaiment':
                datas = [
                    { name: "Attente de Demande", value: 0 },
                    { name: "Attende de Paiement", value: 0 },
                    { name: "Paiement Refuser", value: 0 },
                    { name: "Paiement Accepté", value: 0 }
                ];
                nextProps.datas.map((item, key) => {
                    config.dataManagerComandePaiment(item, datas)
                });
                break;
            case 'commandType':
                datas = [
                    { name: "Demande de Duplicata", value: 0 },
                    { name: "Demande d'Immatriculation Véhicule Neuf", value: 0 },
                    { name: "Changement Titulaire Véhicule d'Occasion Français", value: 0 },
                    { name: "Demande de changement d'adresse", value: 0 },
                    { name: "Déclaration de Cession", value: 0 }
                ];
                nextProps.datas.map((item, key) => {
                    config.dataManagerComandeType(item, datas)
                });
                break;
            default:
                break;
        }
        this.updateDatasState(datas);
        
        return true;
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