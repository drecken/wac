<script setup>
const route = useRoute()
const router = useRouter()
const recipeStore = useRecipeStore()
const paginationStore = usePaginationStore()
const parametersStore = useRecipeQueryParametersStore()

const {parameters} = storeToRefs(parametersStore)
const {links, meta} = storeToRefs(paginationStore)
const {recipes} = storeToRefs(recipeStore)

parametersStore.loadFromUrlQueryString()
recipeStore.fetchAll()

watch(() => route.query, () => {
    parametersStore.loadFromUrlQueryString()
    recipeStore.fetchAll()
})

function applyFilters() {
    parameters.value.page.number = null;
    router.replace({query: parametersStore.queryParameters})
}
</script>

<template>
    <section>
        <form @submit.prevent>
            <div>
                <label for="keyword">Keyword</label>
                <input v-model="parameters.filters.keyword" id="keyword" @keyup.enter="applyFilters">
            </div>
            <div>
                <label for="keyword">Email</label>
                <input v-model="parameters.filters.email" id="email" @keyup.enter="applyFilters">
            </div>
            <div>
                <label for="keyword">Ingredient</label>
                <input v-model="parameters.filters.ingredient" id="ingredient" @keyup.enter="applyFilters">
            </div>
            <div>
                <button @click="applyFilters">Search</button>
            </div>
        </form>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Author</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="recipe in recipes" :key="recipe.id">
                <td>{{ recipe.id }}</td>
                <td>
                    <NuxtLink :to="`/recipes/${recipe.slug}`">{{ recipe.name }}</NuxtLink>
                </td>
                <td>{{ recipe.authors_email }}</td>
                <td>{{ recipe.description }}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">
                    <p v-if="meta.total > 0">
                        Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} results.
                    </p>
                    <p v-else>
                        No results.
                    </p>
                </td>
            </tr>
            </tfoot>
        </table>
        <nav>
            <ul>
                <li v-for="link in links">
                    <NuxtLink v-if="link.url && !link.active" :to="link.url" v-html="link.label"/>
                    <span v-else v-html="link.label"/>
                </li>
            </ul>
        </nav>
    </section>
</template>

<style scoped>
form {
    border: 0;
    box-shadow: 0 0 0 0;
    max-width: 100%;
    width: 100%;
    display: flex;
    justify-content: space-evenly;
    margin-bottom: 2rem;
    gap: 0 2rem;
    padding: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

button {
    padding: 0.5rem 1rem;
}

@media (max-width: 800px) {
    form {
        flex-direction: column;
    }
}

table, tbody, thead, tr, th, td {
    width: 100%;
}
</style>
