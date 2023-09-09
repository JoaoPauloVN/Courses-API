<template>
    <BoxTopTitle title="axios"/>

    <div class="w-full py-3 px-2 bg-neutral-800 border border-neutral-700">
        <h2 class="uppercase text-xs text-neutral-400 mb-2">request</h2>

        <div class="font-mono text-neutral-300 overflow-x-auto pb-2 flex ">
            <div class="w-5 text-right flex flex-col mr-2">
                <p class="text-slate-600 mr-3 text-right w-5 text-sm" v-for="i in lines" :id="i">{{ i }}</p>
            </div>
            <div class="overflow-x-auto">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup  >
import BoxTopTitle from "./BoxTopTitle.vue";

defineProps([
    'lines'
])
</script>