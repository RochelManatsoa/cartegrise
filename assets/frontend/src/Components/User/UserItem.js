import React from 'react';
import axios from 'axios';
import Card from './../../Widget/Card/card';
import PieChart from '../../Widget/hightChart/PieChart';
import LineChart from '../../Widget/hightChart/AreaChart';
import { NotificationContainer, NotificationManager } from 'react-notifications';
import param from '../../params';
import DatePicker from '../DatePicker/Datepicker';
import { addDays} from "date-fns";
import { format } from 'path';


class UserItem extends React.Component {
    constructor() {
        super();

        this.state = {
          userEntries: [],
          commandeEntries: [],
          commandeEntriesLength: 0,
          demandeEntries: [],
          transactionEntries: [],
          dateFilterStart: new moment().format("YYYY-MM-DD"),
          dateFilterEnd: moment(addDays(new Date(), 1)).format("YYYY-MM-DD")
        };
        this.renderAllItems = this.renderAllItems.bind(this);
        this.getUsers = this.getUsers.bind(this);
        this.updateCommande = this.updateCommande.bind(this);
        this.updateDemande = this.updateDemande.bind(this);
        this.updateTransaction = this.updateTransaction.bind(this);
        this.getFilter = this.getFilter.bind(this);
        this.updateContent = this.updateContent.bind(this);
        
    }

    getUsers()
    {
        // if (this.state.dateFilterStart === this.state.dateFilterEnd)
        let url =
          `${param.ENTRYPOINT}/users?registerDate[before]=`+
          this.state.dateFilterEnd+`&registerDate[after]=`+
          this.state.dateFilterStart ;
        // let url = 
        axios({
          method: "get",
          url: url,
          headers: {
            "content-type": "application/vnd.myapp.type+json",
            accept: "application/json"
          }
        }).then(userEntries => {
          if (this.state.userEntries !== userEntries.data) {
            this.setState({
              userEntries: userEntries.data
            });
          }
        });
    }

    getFilter(start, end)
    {
        if (
            this.state.dateFilterStart !== start.format("YYYY-MM-DD") ||
            this.state.dateFilterEnd !== end.format("YYYY-MM-DD")
        ) {
            this.setState({
              dateFilterStart: start.format("YYYY-MM-DD"),
                dateFilterEnd: end.add(1, 'days').format("YYYY-MM-DD")
            });
            this.updateContent(
                start.format("YYYY-MM-DD"),
                end.add(1, 'days').format("YYYY-MM-DD")
            );
        }
    }

    updateContent( startString, endString)
    {
        this.getUsers();
        this.updateCommande();
        this.updateDemande();
        this.updateTransaction();
    }

    updateCommande(){
        let url =
          `${param.ENTRYPOINT}/commandes?ceerLe[before]=` +
          this.state.dateFilterEnd +
          `&ceerLe[after]=` +
          this.state.dateFilterStart;
        axios({
          method: "get",
          url: url,
          headers: {
            "content-type": "application/vnd.myapp.type+json",
            accept: "application/json"
          }
        }).then(commandeEntries => {
          this.setState({
            commandeEntries: commandeEntries.data,
            commandeEntriesLength: commandeEntries.data.length
          });
        }); 
    }
    updateDemande(){
        let url =
          `${param.ENTRYPOINT}/demandes?dateDemande[before]=` +
          this.state.dateFilterEnd +
          `&dateDemande[after]=` +
          this.state.dateFilterStart;
        axios({
            method: 'get',
            url: url ,
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
    updateTransaction()
    {
        let url =
          `${param.ENTRYPOINT}/transactions?createAt[before]=` +
          this.state.dateFilterEnd +
          `&createAt[after]=` +
          this.state.dateFilterStart;
        axios({
          method: "get",
          url: url,
          headers: {
            "content-type": "application/vnd.myapp.type+json",
            accept: "application/json"
          }
        }).then(transactionEntries => {
          this.setState({
            transactionEntries: transactionEntries.data
          });
        });
    }
    componentDidMount(){
        this.getUsers();
        this.updateCommande();
        this.updateDemande();
        this.updateTransaction();

        // Secret of Mercure Ninja
        // URL is a built-in JavaScript class to manipulate URLs
        const url = new URL('http://dev3.cgofficiel.fr/hub/hub');
        url.searchParams.append('topic', 'http://cgofficiel.com/addNewSimulator');
        // Subscribe to updates of several Book resources
        url.searchParams.append('topic', 'http://example.com/books/2');
        // All Review resources will match this pattern
        url.searchParams.append('topic', 'http://example.com/reviews/{id}');

        const eventSource = new EventSource(url);
        eventSource.onmessage = event => {
            let res = JSON.parse(event.data);
            if (res.status === "success") {
                if (res.item != "") {
                    let message = '';
                    let withImmat = ['commande', 'demande'];
                    if (withImmat.includes(res.item)) {
                        message += 'une Nouvelle ' + res.item + ' avec info : ' +
                            ' / Immatriculation ==> ' + res.data.immat +
                            ' / departement ==> ' + res.data.department +
                            ' / demarche ==> ' + res.data.demarche;
                    } else {
                        message = res.message;
                    }
                    NotificationManager.info(message, "Nouvelle "+res.item+"", 7000);
                    switch(res.item){
                        case 'commande':
                            this.updateCommande();
                        case 'demande':
                            this.updateDemande();
                        case 'utilisateur':
                            this.getUsers();
                        default:
                            return;

                    }
                    
                } else {
                    NotificationManager.info(res.message);
                }
            }
        }
        // End of secret of mercure Ninja

    }

    renderAllItems() {
        return (
            <div>
                <div>
                    <DatePicker getFilter = {this.getFilter} />
                </div>
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
                        title={this.state.commandeEntriesLength}
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
                <NotificationContainer />
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