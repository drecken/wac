<script setup>
const route = useRoute()
const router = useRouter()
const recipeStore = useRecipeStore()
const paginationStore = usePaginationStore()
const parametersStore = useRecipeQueryParametersStore()

const {parameters} = storeToRefs(parametersStore)
const {links} = storeToRefs(paginationStore)
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
    <div>
        <input v-model="parameters.filters.email" placeholder="email" @change="applyFilters()">
        <input v-model="parameters.filters.ingredient" placeholder="ingredient" @change="applyFilters()">
        <input v-model="parameters.filters.keyword" placeholder="keyword" @change="applyFilters()">
        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>author</th>
                <th>description</th>
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
        </table>
        <div>
            <template v-for="link in links">
                <NuxtLink v-if="link.url" :to="link.url" v-html="link.label"/>
                <span v-else v-html="link.label"/>
            </template>
        </div>
    </div>
</template>
