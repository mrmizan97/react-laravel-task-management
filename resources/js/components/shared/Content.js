import React from "react";
import { BrowserRouter as Router, Switch, Link, Route } from "react-router-dom";

import Home from "../pages/Home";
import Contact from "../pages/Contact";
import About from "../pages/about";

function Content() {
    return (
        <div className="text-center py-5">
            <Switch>
                <Route path="/contact">
                    <Contact />
                </Route>
                <Route path="/">
                    <Home />
                </Route>
                <Route path="/about">
                    <About></About>
                </Route>
            </Switch>
        </div>
    );
}

export default Content;
