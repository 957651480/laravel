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
                </Switch>
            </HashRouter>
        );
    }
}

export default App;
