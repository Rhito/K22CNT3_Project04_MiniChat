import { type JSX } from "react";
import { Navigate } from "react-router-dom";

type Props = {
    children: JSX.Element;
};

const CheckLogin = ({ children }: Props) => {
    const token = localStorage.getItem("authToken");

    if (!token) {
        return <Navigate to="/" replace />;
    }

    return children;
};

export default CheckLogin;
