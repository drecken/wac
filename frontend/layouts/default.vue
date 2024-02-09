<script setup lang="ts">

</script>

<template>
    <main>
        <nav>
            <ul>
                <li>
                    <NuxtLink to="/recipes">Recipes</NuxtLink>
                </li>
            </ul>
        </nav>
        <slot/>
    </main>
</template>
<style scoped>
main nav {
    margin-bottom: 2rem;
}
</style>

<style>
@import '~/assets/css/mvp.css';
</style>
