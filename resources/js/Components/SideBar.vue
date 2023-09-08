<template>
    <div class="max-h-[95vh] overflow-y-auto col-span-2 px-4 bg-scroll">
        <div v-for="el, index in data" :id="index">
            <NavTitle class="ml-4">{{ el.name }}</NavTitle>

            <NavLink v-for="route, i in el.routes" :id="i" :href="route.url" :name="route.name" :method="route.method" :active="page.props.ziggy.location == route.url"></NavLink>
        </div>
    </div>
</template>

<script setup  >
import { useRoutesStore } from '@/Stores/RoutesStore';
import NavLink from '../Components/NavLink.vue';
import NavTitle from '../Components/NavTitle.vue';
import { usePage } from '@inertiajs/vue3';

const store = useRoutesStore();
const page = usePage()

const data = store.routes;
</script>