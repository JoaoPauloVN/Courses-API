<template>
    <div class="w-full py-3 px-2 bg-neutral-800 border rounded-t-none rounded-lg border-neutral-700">
        <button class="bg-emerald-800 rounded-full px-6 py-2 text-neutral-300 text-sm font-bold" @click="$emit('request')" :class="{'bg-neutral-600 ': loading}" :disabled="loading">Try</button>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    loading: boolean;
}>();
</script>