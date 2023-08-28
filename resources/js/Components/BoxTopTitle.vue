<template>
    <div class="w-full py-3 px-2 bg-neutral-800 border rounded-b-none rounded-lg border-neutral-700 flex justify-between">
        <p class=" text-neutral-300 text-sm uppercase">{{ title }}</p>
    </div>
</template>

<script setup lang="ts">

defineProps<{
    title: string;
}>();

</script>