import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Switch,Link,Route } from "react-router-dom";
import Content from "./shared/Content";
import Footer from "./shared/Footer";
import Header from "./shared/Header";


function Myapp() {
    return (
        <div className="container">
        <Router>
        <div>
         <Header></Header>
          {/* A <Switch> looks through its children <Route>s and
              renders the first one that matches the current URL. */}

          <Content></Content>
          <Footer></Footer>
        </div>
      </Router>
        </div>
    );
}

export default Myapp;

if (document.getElementById("myapp")) {
    ReactDOM.render(<Myapp />, document.getElementById("myapp"));
}
