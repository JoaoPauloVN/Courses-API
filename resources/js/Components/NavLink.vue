<template>
    <Link :href="href" :class="classes">
        {{ name }}<span :class="methodClasses">{{ method }}</span>
    </Link>
</template>

<script setup  >
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
    name: String,
    method: String
});

const classBase = "text-sm text-neutral-400 flex justify-between px-4 py-[0.3rem] my-1 align-middle hover: rounded-lg text-center";

const classes = computed(() =>
    props.active
        ? classBase + " bg-neutral-700"
        : classBase
);

const methodBase = "text-[0.65rem] px-3 rounded-full self-center text-neutral-300";

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