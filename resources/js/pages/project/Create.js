import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, withRouter } from "react-router-dom";

function Create(props) {
    const [error, seterror] = useState([]);
    const [loading, setloading] = useState(false);
    const [items, setItems] = useState({
        name: "",
        description: "",
        // order_index: "",
    });
    const { history } = props;
    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setItems((items) => ({
            ...items,
            [key]: value,
        }));
    }

    const submitForm = async(e) => {
        e.preventDefault();
        setloading(true);
        await axios
            .post("http://localhost:8000/api/project/store", items)
            .then((res) => {
                setloading(false);
                history.push("/project");
                alert("Data inserted.");
            })
            .catch((error) => {
                setloading(false);
                seterror(error.response.data.error);
            });
    };

    return (
        <div className="container">
            <div className="float-left">
                {" "}
                <h2>Create new project </h2>
            </div>
            <div className="float-right">
                {" "}
                <Link to="/project" className="btn btn-primary mr-2">
                    All Project
                </Link>
            </div>
            <div className="clearfix"></div>
            {loading && <h3>Loading...</h3>}

            <div className="card text-left p-3">
                <form onSubmit={submitForm}>
                    <div className="form-group">
                        <label htmlFor="exampleInputEmail1">
                            Project Name.
                        </label>
                        <input
                            type="text"
                            className="form-control"
                            name="name"
                            value={items.name}
                            onChange={handleChange}
                            placeholder="Enter project Name"
                        />
                        {error && <p className="text-danger">{error.name}</p>}
                    </div>
                    <div className="form-group">
                        <label htmlFor="exampleInputPassword1">
                            Project Description.
                        </label>
                        <textarea
                            type="text"
                            className="form-control"
                            name="description"
                            value={items.description}
                            onChange={handleChange}
                            placeholder="Enter project Description"
                        ></textarea>
                        {error && (
                            <p className="text-danger">{error.description}</p>
                        )}
                    </div>

                    <button type="submit" className="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    );
}

export default withRouter(Create);
