<template>
    <h1 class="text-2xl text-neutral-400">{{ title }}</h1>

    <p class="text-sm text-neutral-400 py-[0.3rem] my-1 align-middle"><span :class="methodClasses">{{ method }}</span> {{ url }}</p>

    <p class="text-neutral-300 text-lg">{{ description }}</p>

    <Line class="mt-6" />
</template>

<script setup lang="ts">
import { computed } from "vue";
import Line from "./Line.vue";

const props = defineProps<{
    title: string;
    method?: string;
    url?: string;
    description: string;
}>();

const methodBase = "text-[0.65rem] px-3 rounded-full self-center text-neutral-300 py-[0.2rem] align-bottom";

const methodClasses = computed(function() {
    switch(props.method) {
        case "GET":
            return methodBase + " bg-green-800";
        case "POST":
            return methodBase + " bg-sky-800";
        case "PUT":
            return methodBase + " bg-orange-800";
        case "DELETE":
            return methodBase + " bg-red-800";
    }
});
</script>