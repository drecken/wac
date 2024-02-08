export const useRecipeQueryParametersStore = defineStore('recipe-query-parameters', () => {
    const parameters = ref({
        filters: {
            email: null,
            ingredient: null,
            keyword: null,
        },
        page: {
            number: null,
            size: null,
        }
    } as RecipeQueryParameters)

    const queryParameters = computed(() => {
        const filters = parameters.value.filters
        const page = parameters.value.page
        let combinedParams = []
        Object.entries(filters).forEach(([key, value]) => {
            if (value) {
                combinedParams[`filter[${key}]`] = value;
            }
        })
        Object.entries(page).forEach(([key, value]) => {
            if (value) {
                combinedParams[`page[${key}]`] = value;
            }
        })
        return combinedParams
    })

    function loadFromUrlQueryString() {
        const route = useRoute()
        const query = route.query
        parameters.value.filters.email = query['filter[email]'] ? query['filter[email]'] : null
        parameters.value.filters.ingredient = query['filter[ingredient]'] ? query['filter[ingredient]'] : null
        parameters.value.filters.keyword = query['filter[keyword]'] ? query['filter[keyword]'] : null
        parameters.value.page.number = query['page[number]'] ? parseInt(query['page[number]'] as string) : null
        parameters.value.page.size = query['page[size]'] ? parseInt(query['page[size]'] as string) : null
    }

    return {parameters, loadFromUrlQueryString, queryParameters}
})

interface RecipeQueryParameters {
    filters: {
        email: string | null,
        ingredient: string | null,
        keyword: string | null,
    },
    page: {
        number: number | null,
        size: number | null,
    }
}

