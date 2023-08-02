import { Link } from "react-router-dom";

const Dashboard = () => {
    return (
        <div>
            <Link to="/">Home</Link>
            <br />
            <Link to="test">Something with fetch</Link>
        </div>
    );
};

export default Dashboard;
