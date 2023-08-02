import {
    createBrowserRouter,
    createRoutesFromElements,
    Route,
} from "react-router-dom";
import Login from "./features/auth/Login";
import RequireAuth from "./features/auth/RequireAuth";
import Dashboard from "./pages/Dashboard";
import Test from "./pages/Test";

const routes = createRoutesFromElements(
    <Route path="/">
        <Route path="login" element={<Login />} />

        <Route element={<RequireAuth />}>
            {/* Dashboard */}
            <Route index element={<Dashboard />} />

            {/* Test */}
            <Route path="test" element={<Test />} />
        </Route>
    </Route>
);

const router = createBrowserRouter(routes, {
    future: {
        // Normalize `useNavigation()`/`useFetcher()` `formMethod` to uppercase
        v7_normalizeFormMethod: true,
    },
});

export default router;
