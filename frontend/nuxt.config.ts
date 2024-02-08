// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    devtools: {enabled: true},
    modules: ['@pinia/nuxt'],
    runtimeConfig: {
        public: {
            apiBase: 'http://localhost:8888/api', // can be overridden by NUXT_PUBLIC_API_BASE environment variable
        }
    },
})
