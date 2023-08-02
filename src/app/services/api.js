// Need to use the React-specific entry point to allow generating React hooks
import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

import { logOut, setCredentials } from "@/features/auth/authSlice";

import { Mutex } from "async-mutex";

const mutex = new Mutex();

const baseQuery = fetchBaseQuery({
    baseUrl: import.meta.env.VITE_APP_BASE_URL,
    credentials: "include",
    prepareHeaders: (headers, { getState }) => {
        const token = getState().auth.accessToken;

        console.log("otken", token);

        if (token) {
            headers.set("authorization", `Bearer ${token}`);
        }

        return headers;
    },
});

const baseQueryWithReauth = async (args, api, extraOptions) => {
    // wait until the mutex is available without locking it
    await mutex.waitForUnlock();

    let result = await baseQuery(args, api, extraOptions);

    console.log("result", result);

    if (
        // result?.error?.status === "PARSING_ERROR" &&
        // result?.error?.originalStatus === 403
        result?.data?.message === "Invalid JWT token"
    ) {
        if (!mutex.isLocked()) {
            const release = await mutex.acquire();

            try {
                console.log("sending refresh token");
                // send refresh token to get new access token

                // /refresh -> backend route
                const refreshResult = await baseQuery(
                    "/refresh.php",
                    api,
                    extraOptions
                );

                console.log("refreshResult", refreshResult);

                if (refreshResult?.data) {
                    const user = api.getState().auth.user;

                    const payload = {
                        user,
                        accessToken: refreshResult?.data?.accessToken,
                    };
                    // store the new token
                    api.dispatch(setCredentials(payload));
                    // retry the original query with new access token
                    result = await baseQuery(args, api, extraOptions);
                } else {
                    api.dispatch(logOut());
                }
            } finally {
                release();
            }
        } else {
            // wait until the mutex is available without locking it
            await mutex.waitForUnlock();
            result = await baseQuery(args, api, extraOptions);
        }
    }

    return result;
};

export const api = createApi({
    baseQuery: baseQueryWithReauth,
    endpoints: (builder) => ({}),
});

// // Define a service using a base URL and expected endpoints
// export const api = createApi({
//     reducerPath: "api",
//     baseQuery: fetchBaseQuery({
//         baseUrl: import.meta.env.VITE_APP_BASE_URL,
//         prepareHeaders: (headers, { getState }) => {
//             const token = getState() as RootState;
//             // If we have a token set in state, let's assume that we should be passing it.
//             if (token) {
//                 headers.set("authorization", `Bearer tae`);
//             }
//             return headers;
//         },
//     }),
//     endpoints: (builder) => ({
//         getUser: builder.query<TransformedResponse<User>, void>({
//             query: () => {
//                 return {
//                     url: "/",
//                     // headers: { authorization: "Bearer token" },
//                 };
//             },
//             transformResponse: (response: User, meta) => {
//                 return {
//                     data: response,
//                     statusCode: meta?.response?.status,
//                     statusText: meta?.response?.statusText,
//                     ok: meta?.response?.ok,
//                 };
//             },
//             transformErrorResponse(response) {
//                 return response;
//             },
//         }),
//         // // eslint-disable-next-line @typescript-eslint/ban-ts-comment
//         // // @ts-ignore
//         login: builder.mutation({
//             query: () => {
//                 return {
//                     url: "/",
//                     // headers: { authorization: "Bearer token" },
//                 };
//             },
//             transformResponse: (response: User, meta) => {
//                 return {
//                     data: response,
//                     statusCode: meta?.response?.status,
//                     statusText: meta?.response?.statusText,
//                     ok: meta?.response?.ok,
//                 };
//             },
//             transformErrorResponse(response) {
//                 return response;
//             },
//         }),

//         getDisbursement: builder.query<DisbursementFormValues, void>({
//             query: () => {
//                 return {
//                     url: "/disbursement",
//                 };
//             },
//         }),

//         createDisbursement: builder.mutation({
//             query: (data: DisbursementFormValues) => {
//                 return {
//                     url: "/disbursement",
//                     method: "POST",
//                     body: data,
//                 };
//             },
//             transformResponse: (response: User, meta) => {
//                 return {
//                     data: response,
//                     statusCode: meta?.response?.status,
//                     statusText: meta?.response?.statusText,
//                     ok: meta?.response?.ok,
//                 };
//             },
//             transformErrorResponse(response) {
//                 return response;
//             },
//         }),
//     }),
// });

// // Export hooks for usage in function components, which are
// // auto-generated based on the defined endpoints
// export const {
//     useGetUserQuery,
//     useLoginMutation,
//     useGetDisbursementQuery,
//     useLazyGetDisbursementQuery,
//     useCreateDisbursementMutation,
// } = api;
