import React from 'react';
import axios from 'axios';
import Card from './../../Widget/Card/card';
import Chart from './../../Widget/hightChart/chart';
import Column from './../../Widget/hightChart/column';
import ReactChart from './../../Widget/hightChart/ReactChart';
import MyResponsivePie from './../../Widget/hightChart/NivoChart';
import ReRechart from './../../Widget/hightChart/Rechart';

class UserItem extends React.Component {
    constructor() {
        super();

        this.state = {
            userEntries: [],
            commandeEntries: [],
            demandeEntries: [],
        };
        this.renderAllItems = this.renderAllItems.bind(this);
        
    }

    
    

    componentDidMount() {
        axios({
            method: 'get',
            url: 'https://127.0.0.1:8000/api/users',
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(userEntries => {
            this.setState({
                userEntries: userEntries.data
            });
        });

        axios({
            method: 'get',
            url: 'https://127.0.0.1:8000/api/commandes',
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(commandeEntries => {
            this.setState({
                commandeEntries: commandeEntries.data
            });
        });
        axios({
            method: 'get',
            url: 'https://127.0.0.1:8000/api/demandes',
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(demandeEntries => {
            this.setState({
                demandeEntries: demandeEntries.data
            });
        });
    }

    renderAllItems() {
        return (
            <div>
                <Card
                    type="topCard"
                    title={this.state.userEntries.length}
                    text='Utilisateurs'
                    textClass=''
                    innerClass='inner'
                    iconName='user'
                    linkDetail='/'
                    textDetail='detail'
                    background='aqua'
                />

                <Card
                    type="topCard"
                    title={this.state.commandeEntries.length}
                    text='Comandes'
                    textClass=''
                    innerClass='inner'
                    iconName='archive'
                    linkDetail='/'
                    textDetail='detail'
                    background='yellow'
                />

                <Card
                    type="topCard"
                    title={this.state.demandeEntries.length}
                    text='Demandes'
                    textClass=''
                    innerClass='inner'
                    iconName='archive'
                    linkDetail='/'
                    textDetail='detail'
                    background='purple'
                />
                <Chart 
                    col={6}
                    paramOptions={this.state.commandeEntries}
                    dataCommandeHighchart={this.state.dataCommandeHighchart}
                    type="pie"
                    title="Commande Status"
                />
                <Column 
                    col={6}
                    paramOptions={this.state.commandeEntries}
                    dataCommandeHighchart={this.state.dataCommandeHighchart}
                    type="pie"
                    title="Commande Status"
                />

                <ReRechart />
            </div>
        )
    }

    render() {
        return (
            <div className="col-md-12">
                {this.renderAllItems()}
            </div>
        );
    }
}

export default UserItem;