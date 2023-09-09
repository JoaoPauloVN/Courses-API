<template>
    <div class="text-sm flex">
        <span v-for="index in props.tab" :id="index" class="inline-block min-w-[1.75rem]"></span>
        <span class="whitespace-nowrap" v-html="code"></span>
    </div>
</template>

<script setup>

const props = defineProps({
    number: Number,
    code: String,
    tab: Number,
})

</script>