<template>
    <div class="w-full py-3 px-2 bg-neutral-800 border rounded-b-none rounded-lg border-neutral-700 flex justify-between mt-4">
        <p class=" text-neutral-300 text-sm uppercase">response</p>
        <div class="flex justify-between">
            <p class=" text-neutral-300 text-sm flex items-center"><span :class="statusClass()"></span> {{ status ? status : "" }}</p>
        </div>
    </div>
    <div class="w-full py-3 px-2 bg-neutral-800 border rounded-t-none rounded-lg border-neutral-700 " >
        <div class="max-h-80 overflow-y-auto rounded text-neutral-400 text-sm min-h-[10rem] max-h">
            <div v-show="loading" class="w-full relative h-40">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 spin">
                    <div class=" w-10 h-10 rounded-full border-2 border-neutral-800 border-t-neutral-200 animate-spin"></div>
                </div>
            </div>
            <pre v-show="!loading" >
                <div v-html="response"></div>
            </pre>
        </div>
    </div>
</template>

<script setup  >
const props = defineProps({
    response: String,
    loading: Boolean,
    status: Number
});

function statusClass() {
    let base = "inline-block w-3 h-3 rounded-full mr-1";

    if(props.status == 0)
        return base + " bg-gray-600";
    if(props.status >= 200 && props.status < 299)
        return base + " bg-green-700";
    if(props.status >= 300 && props.status < 399)
        return base + " bg-sky-700";
    if(props.status >= 400 && props.status < 499)
        return base + " bg-orange-700";
    if(props.status >= 500)
        return base + " bg-red-700";
}
</script>