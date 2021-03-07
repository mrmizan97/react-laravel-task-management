import React from "react";
import { HashRouter as Router, Switch, Link, Route } from "react-router-dom";

import Home from "../pages/Home";
import List from "../pages/project/List";
import Create from "../pages/project/Create";
import Edit from "../pages/project/Edit";
import About from "../pages/about";
import View from "../pages/project/View";

function Content() {
    return (
        <div className="container py-3">
            <Switch>
                <Route path="/about">
                    <About></About>
                </Route>
                <Route path="/project/create">
                    <Create></Create>
                </Route>
                <Route path="/project/:id/edit">
                    <Edit></Edit>
                </Route>
                <Route path="/project/:id/view">
                    <View></View>
                </Route>
                <Route path="/project">
                    <List></List>
                </Route>

                <Route path="/">
                    <Home />
                </Route>
            </Switch>
        </div>
    );
}

export default Content;
