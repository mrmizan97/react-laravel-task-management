import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, withRouter } from "react-router-dom";
function List() {
    const [values, setvalues] = useState([]);
    const [loading, setloading] = useState(false);
    const [error, seterror] = useState([]);
    const deleteItem = async (id) => {
        if (confirm("Are you sure to delete this item?")) {
            await axios
                .get(`http://localhost:8000/api/project/${id}/delete`)
                .then((response) => {
                    getItem();
                    alert("Data deleted.");
                })
                .catch((error) => {
                    seterror("Data not deleted.");
                });
        }
    };
    const getItem = async () => {
        setloading(true);
        await axios
            .get("http://localhost:8000/api/project")
            .then((response) => {
                setvalues(response.data.data);
                setloading(false);
            })
            .catch((error) => {
                console.log("error", error.response.data.error);
                seterror(error.response.data.error);
            });
    };

    useEffect(() => {
        getItem();
        // return () => {
        //     cleanup
        // }
    }, []);

    return (
        <div className="container">
            <div className="float-left">
                {" "}
                <h2>
                    Project List{" "}
                    <span className="badge bg-secondary text-light">
                        {values.length}
                    </span>
                </h2>
            </div>
            <div className="float-right">
                <Link to="/project/create" className="btn btn-primary mr-2">
                    + Create New
                </Link>
            </div>
            <div className="clearfix"></div>
            {loading && <h3>Loading...</h3>}
            {error.length > 0 && <h3>{error}</h3>}
            {values.map((item, index) => (
                <div className="card text-left" key={index}>
                    <h5 className="card-header">
                        {item.name}
                        <span className="badge bg-secondary text-light">
                            {item.tasks_count}
                        </span>
                    </h5>
                    <div className="card-body">
                        {/*                     <h5 className="card-title">Special title treatment</h5>
                         */}{" "}
                        <p className="card-text">{item.description}</p>
                        <Link
                            to={`project/${item.id}/view`}
                            className="btn btn-primary mr-2"
                        >
                            View
                        </Link>
                        <Link
                            to={`project/${item.id}/edit`}
                            className="btn btn-success  mr-2"
                        >
                            Edit
                        </Link>
                        <button
                            onClick={() => deleteItem(item.id)}
                            className="btn btn-danger  mr-2"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            ))}
            {values.length === 0 && <h2>No data found.</h2>}
        </div>
    );
}

export default withRouter(List);
