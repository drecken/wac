<script setup lang="ts">
const route = useRoute()
const slug = route.params.slug
const recipeStore = useRecipeStore()
recipeStore.fetch(slug)
const {recipe} = storeToRefs(recipeStore)
</script>

<template>
    <section>
        <header>
            <h1>{{ recipe.name }}</h1>
            <small> by {{ recipe.authors_email }}</small>
        </header>
        <aside>
            <h2>Description</h2>
            <p>{{ recipe.description }}</p>
        </aside>
        <aside>
            <h2>Ingredients</h2>
            <ul>
                <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                    {{ ingredient.name }}
                </li>
            </ul>
        </aside>
        <aside>
            <h2>Steps</h2>
            <ol>
                <li v-for="step in recipe.steps" :key="step.id">
                    {{ step.description }}
                </li>
            </ol>
        </aside>
    </section>
</template>
