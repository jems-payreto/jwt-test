import { useTestQuery } from "../features/testApi/testApiSlice";

const Test = () => {
    const { data, error } = useTestQuery();

    console.log("data", data);
    console.log("error", error);

    return <div>Test</div>;
};

export default Test;
