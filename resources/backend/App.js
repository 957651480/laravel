import React,{ Component } from 'react';
import {
    HashRouter,
    Switch,
    Route,
    Link
} from "react-router-dom";
import Login from "./pages/auth/Login";
import Dashboard from "./pages/dashboard";
import Demo from "./pages/demo";
import Form from "./pages/form";
import Table from "./pages/table";


class App extends Component {

    render() {
        return (
            <HashRouter>
                <Switch>
                    <Route exact path="/" component={Dashboard}>
                    </Route>
                    <Route path="/login" component={Login}>
                    </Route>
                    <Route path="/demo" component={Demo}>
                    </Route>
                    <Route path="/form" component={Form}>
                    </Route>
                    <Route path="/table" component={Table}>
                    </Route>
                </Switch>
            </HashRouter>
        );
    }
}

export default App;
