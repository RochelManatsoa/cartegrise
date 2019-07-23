import React from 'react';
import axios from 'axios';
import Card from './../../Widget/Card/card';
import PieChart from '../../Widget/hightChart/PieChart';
import LineChart from '../../Widget/hightChart/AreaChart';
import param from '../../params';

class UserItem extends React.Component {
    constructor() {
        super();

        this.state = {
            userEntries: [],
            commandeEntries: [],
            demandeEntries: [],
            transactionEntries: [],
        };
        this.renderAllItems = this.renderAllItems.bind(this);
        this.getUsers = this.getUsers.bind(this);
        this.synchro = this.synchro.bind(this);
        
    }

    getUsers()
    {
        axios({
            method: 'get',
            url: `${param.ENTRYPOINT}/users`,
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
            .then(userEntries => {
                if (this.state.userEntries !== userEntries.data){
                    this.setState({
                        userEntries: userEntries.data
                    });
                }  
        });
    }

    synchro()
    {
        setInterval(() => {
            this.getUsers();
        }, 5000);
    }

    componentDidMount() {
        this.getUsers();
        axios({
            method: 'get',
            url: `${param.ENTRYPOINT}/commandes`,
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
            url: `${param.ENTRYPOINT}/demandes`,
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
        axios({
            method: 'get',
            url: `${param.ENTRYPOINT}/transactions`,
            headers: {
                'content-type': 'application/vnd.myapp.type+json',
                'accept': 'application/json'
            }
        })
        .then(transactionEntries => {
            this.setState({
                transactionEntries: transactionEntries.data
            });
        });

        // for synchronisation : 
        this.synchro();
    }

    renderAllItems() {
        return (
            <div>
                <div className="col-md-12">
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
                        text='Estimations'
                        textClass=''
                        innerClass='inner'
                        iconName='file'
                        linkDetail='/'
                        textDetail='detail'
                        background='yellow'
                    />

                    <Card
                        type="topCard"
                        title={this.state.demandeEntries.length}
                        text='Panier'
                        textClass=''
                        innerClass='inner'
                        iconName='folder'
                        linkDetail='/'
                        textDetail='detail'
                        background='purple'
                    />

                    <Card
                        type="topCard"
                        title={this.state.transactionEntries.length}
                        text='En attente de documents'
                        textClass=''
                        innerClass='inner'
                        iconName='euro'
                        linkDetail='/'
                        textDetail='detail'
                        background='teal'
                    />
                </div>
                <div className="col-md-12">
                    <PieChart
                        col={6}
                        datas={this.state.commandeEntries}
                        height={500}
                        type="donut"
                        case="commandPaiment"
                    />

                    <PieChart
                        col={6}
                        datas={this.state.commandeEntries}
                        height={500}
                        type="donut"
                        case="commandType"
                    />
                </div>
                <div className="col-md-12">
                    <LineChart 
                        datas={this.state.userEntries}
                        paddingTop={15}
                        height={400}
                        borderRadius={4}
                        type='Area1'
                    />
                </div>
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