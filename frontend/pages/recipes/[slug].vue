<script setup lang="ts">
const route = useRoute()
const slug = route.params.slug
const recipeStore = useRecipeStore()
recipeStore.fetch(slug)
const recipe = recipeStore.recipe
</script>

<template>
    <div>
        <h1>{{ recipe.name }}</h1>
        <p>{{ recipe.authors_email }}</p>
        <p>{{ recipe.description }}</p>
        <ul>
            <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                {{ ingredient.name }}
            </li>
        </ul>
        <ol>
            <li v-for="step in recipe.steps" :key="step.id">
                {{ step.description }}
            </li>
        </ol>
    </div>
</template>
