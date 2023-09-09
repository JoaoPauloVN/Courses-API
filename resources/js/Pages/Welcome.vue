<template>
    <div class="grid grid-cols-9 py-7">
        <SideBar />
        <div class="col-span-4 p-4 px-8 border-x border-neutral-800">
            <Description
                    title="Welcome"
                    description="
                        Welcome to the initial version of the Courses API.
                        Here you will find a comprehensive list of currently available methods for our API in development." />

            <Pagination />
        </div>

        <div class="col-span-3 p-4 px-8">

        </div>
    </div>
</template>

<script setup>
import SideBar from "../Components/SideBar.vue";
import Description from "../Components/Description.vue";
import Pagination from "../Components/Pagination.vue";
</script>