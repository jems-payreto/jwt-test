import { api } from "@/app/services/api";

export const authApiSlice = api.injectEndpoints({
    endpoints: (builder) => ({
        login: builder.mutation({
            query: (credentials) => ({
                url: "/login_validation.php",
                method: "POST",
                body: credentials,
            }),
        }),
        refresh: builder.query({
            query: () => ({
                url: "/refresh",
            }),
        }),
    }),
});

export const { useLoginMutation, useRefreshQuery } = authApiSlice;
