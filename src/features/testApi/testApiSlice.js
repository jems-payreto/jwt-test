import { api } from "@/app/services/api";

export const testApiSlice = api.injectEndpoints({
    endpoints: (builder) => ({
        test: builder.query({
            query: () => ({
                url: "/test",
            }),
        }),
    }),
});

export const { useTestQuery } = testApiSlice;
