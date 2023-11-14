<template>
    <div>Hello {{ name }}!</div>
    <VBtn color="info" class="font-weight-bold">Hola</VBtn>
</template>

<script setup>
    defineProps({
        name: String
    });
</script>
