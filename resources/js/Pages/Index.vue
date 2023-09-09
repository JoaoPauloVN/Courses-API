<template>
    <div class="grid grid-cols-9 py-7">
        <SideBar />
        <div class="col-span-4 p-4 px-8 border-x border-neutral-800">
            <Description title="List of courses"
                    type="GET"
                    :url="currentRoute.api_url"
                    description="Get a list of all of the courses" />

            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.pathParams">parameters</h2>

            <InputParam v-for="el, index in currentRoute.pathParams" :index="index" :total="currentRoute.pathParams.length" :data="el" @update="updateValue"></InputParam>
            
            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.queryParams">query parameters</h2>

            <InputParam v-for="el, index in currentRoute.queryParams" :index="index" :total="currentRoute.queryParams.length" :data="el" @update="updateValue"></InputParam>

            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.bodyParams">body parameters</h2>

            <InputParam v-for="el, index in currentRoute.bodyParams" :index="index" :total="currentRoute.bodyParams.length" :data="el" @update="updateValue"></InputParam>

            <Line class="mt-6" />

            <Pagination />
        </div>

        <div class="col-span-3 p-4 px-8">
            <Token />

            <CodeBox>
                <CodeLine v-for="el, index in codeLines" :id="index" :number="index" :tab="el.tab" :code='el.code' />
            </CodeBox>

            <Button :loading="loading" @request="request" />

            <Response :loading="loading" :response="response" :status="status" />
        </div>
    </div>
</template>

<script setup>
import InputParam from '../Components/InputParam.vue';
import Description from '../Components/Description.vue';
import Token from '../Components/Token.vue';
import CodeBox from '../Components/CodeBox.vue';
import CodeLine from '../Components/CodeLine.vue';
import { ref, computed } from 'vue';
import Pagination from '../Components/Pagination.vue';
import Response from '../Components/Response.vue';
import Button from '../Components/Button.vue';
import { useRoutesStore } from '@/Stores/RoutesStore';
import SideBar from '../Components/SideBar.vue';
import { usePage } from '@inertiajs/vue3';
import Line from '../Components/Line.vue';

const store = useRoutesStore();
const page = usePage();

const loading = ref(store.loading);
const response = ref('');
const status = ref();

const routes = store.routes;


const codeLines = computed(() => {
    return [
        {
            code: 'axios<span class="text-sky-300">.get</span><span class="text-amber-300">(</span><span class="text-lime-300">"' + api_url +'"</span><span class="text-amber-300">)</span>',
            tab: 0
        },
        {
            code: '<span class="text-sky-300">.then</span><span class="text-amber-300">(</span><span class="text-fuchsia-400">(</span>res<span class="text-fuchsia-400">) =></span> <span class="text-fuchsia-400">{</span>',
            tab: 1
        },
        {
            code: 'response <span class="text-sky-200">=</span> res<span class="text-sky-300">.</span>data',
            tab: 2
        },
        {
            code: '<span class="text-fuchsia-400">}</span><span class="text-amber-300">)</span>',
            tab: 1
        }
    ]
});

const currentUrl = page.props.ziggy.location;
const currentRoute = ref([]);

for(let el in routes) {    
    if(!currentRoute.value.count)
        currentRoute.value = routes[el].routes.find(i => i.url == currentUrl);
}

const api_url = store.apiRoute(currentRoute.value);

function updateValue(param)
{
    let el = null;

    let query = currentRoute.value.queryParams
    let path = currentRoute.value.pathParams
    let body = currentRoute.value.bodyParams

    if(query && query.find(el => el.name == param.name))
        el = query.find(el => el.name == param.name)
    else if(path && path.find(el => el.name == param.name))
        el = path.find(el => el.name == param.name)
    else if(body && body.find(el => el.name == param.name))
        el = body.find(el => el.name == param.name)

    el = param
}

async function request() {
    loading.value = true

    const data = await store.request(currentRoute.value);

    response.value = data.response;
    status.value = data.status

    loading.value = false
}
</script>