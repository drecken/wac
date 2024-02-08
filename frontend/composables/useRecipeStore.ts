export const useRecipeStore = defineStore('recipe', () => {

    const parametersStore = useRecipeQueryParametersStore()

    const recipes = ref([] as Recipe[])
    const recipe = ref({
        id: 0,
        name: '',
        description: '',
        authors_email: '',
        slug: '',
        ingredients: [],
        steps: [],
    } as Recipe)

    async function fetchAll() {
        const results = await $fetch('http://localhost:8888/api/recipes', {params: parametersStore.queryParameters})
        recipes.value = results.data
        const paginationStore = usePaginationStore()
        paginationStore.setLinks(results.meta.links)
    }

    async function fetch(slug: string) {
        const results = await $fetch(`http://localhost:8888/api/recipes/${slug}`)
        recipe.value = results.data
    }

    return {recipes, recipe, fetchAll, fetch}
})

interface Recipe {
    id: number
    name: string
    description: string
    authors_email: string
    slug: string
    ingredients: Ingredient[]
    steps: Step[]
}

interface Ingredient {
    id: number
    name: string
}

interface Step {
    id: number
    description: string
    order_column: number
}
