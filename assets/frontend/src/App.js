import React from 'react';
import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'admin-lte/dist/css/AdminLTE.css';
import 'react-notifications/lib/notifications.css';

import UserItem from './Components/User/UserItem'

function App() {
  return (
    <div className="col-md-12">
        <UserItem />
    </div>
  );
}

export default App;
