<template>
     <NavTitle>authentication</NavTitle>

    <div class="w-full bg-neutral-800 border rounded-lg border-neutral-700 flex justify-between">
        <input v-model="store.api_token" @input="store.api_token" placeholder="Access token" class="rounded border-none bg-neutral-800 outline-0 px-2 py-[0.7rem] text-sm text-neutral-300 focus:ring-0 focus:ring-offset-0 w-full">
    </div>

    <Line class="my-7" />
</template>

<script setup lang="ts">
import NavTitle from "./NavTitle.vue";
import Line from "./Line.vue";
import { useRoutesStore } from "@/Stores/RoutesStore";

const store = useRoutesStore();
</script>