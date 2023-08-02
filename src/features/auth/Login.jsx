import { useLoginMutation } from "./authApiSlice";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { setCredentials } from "./authSlice";

const Login = () => {
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [login] = useLoginMutation();

    const handleSubmit = async (e) => {
        e.preventDefault();

        console.log("submit");
        await login({ name: "James Santos", email: "james.santos@payreto.com" })
            .unwrap()
            .then((res) => {
                console.log("res", res);

                dispatch(setCredentials(res));

                navigate("/");
            })
            .catch((err) => console.error("err", err));
    };

    return (
        <div>
            Login
            <form onSubmit={handleSubmit}>
                <input type="text" placeholder="email" />
                <input type="password" placeholder="password" />

                <input type="submit" value="Submit" />
            </form>
        </div>
    );
};

export default Login;
