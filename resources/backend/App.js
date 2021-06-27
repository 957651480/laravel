import React,{ Suspense, lazy } from 'react';
import {
    HashRouter,
    Switch,
    Route,
    Link
} from "react-router-dom";


const Login =lazy(() => import('./pages/auth/Login'))
const Dashboard =lazy(() => import('./pages/dashboard'))
const Demo =lazy(() => import('./pages/demo'))
const Form =lazy(() => import('./pages/form'))
const Table =lazy(() => import('./pages/table'))

const App=()=>(
    <HashRouter>
        <Suspense fallback={<div>Loading...</div>}>
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
        </Suspense>
    </HashRouter>
)


export default App;
