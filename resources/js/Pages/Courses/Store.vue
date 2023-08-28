<template>
    <div class="grid grid-cols-9 py-7">
        <SideBar />
        <div class="col-span-4 p-4 px-8 border-x border-neutral-800">
            <Description 
                    title="Store Course"
                    :method="currentRoute.method"
                    :url="currentRoute.api_url"
                    description="" />

            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.pathParams">parameters</h2>
            <InputParam 
                v-for="el, index in currentRoute.pathParams" 
                :index="index"
                :total="currentRoute.pathParams.length" 
                :data="el" 
                :type="el.types" 
                :input="el.input" 
                :options="el.options"
                @update="store.updateValue" /> 
            
            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.queryParams">query parameters</h2>
            <InputParam 
                v-for="el, index in currentRoute.queryParams"
                :index="index" 
                :total="currentRoute.queryParams.length"
                :data="el"
                :type="el.types" 
                :input="el.input"
                :options="el.options"
                @update="store.updateValue" />

            <h2 class="title mt-6 mb-3 text-neutral-400 uppercase" v-if="currentRoute.bodyParams">body parameters</h2>
            <InputParam 
                v-for="el, index in currentRoute.bodyParams"
                :index="index"
                :total="currentRoute.bodyParams.length"
                :data="el"
                :type="el.types"
                :input="el.input"
                :options="el.options"
                @update="store.updateValue" />

            <Line class="mt-6" />
            <Pagination />
        </div>

        <div class="col-span-3 p-4 px-8">
            <Token />

            <CodeBox :lines="codeLines.length">
                <CodeLine
                    v-for="el, index in codeLines"
                    :id="index"
                    :number="index"
                    :tab="el.tab"
                    :code='el.code' />
            </CodeBox>
            <Button 
                :loading="loading"
                @request="request" />

            <Response
                :loading="loading"
                :response="response"
                :status="status" />
        </div>
    </div>
</template>

<script setup lang="ts">
import InputParam from '../../Components/InputParam.vue';
import Description from '../../Components/Description.vue';
import Token from '../../Components/Token.vue';
import CodeBox from '../../Components/CodeBox.vue';
import CodeLine from '../../Components/CodeLine.vue';
import { ref, computed, Ref } from 'vue';
import Pagination from '../../Components/Pagination.vue';
import Response from '../../Components/Response.vue';
import Button from '../../Components/Button.vue';
import { useRoutesStore } from '../../Stores/RoutesStore';
import SideBar from '../../Components/SideBar.vue';
import { usePage } from '@inertiajs/vue3';
import Line from '../../Components/Line.vue';
import { Route, Routes } from '../../types/global';

const store = useRoutesStore();
const page = usePage();
const loading: Ref<boolean> = ref(store.loading);
const response: Ref<string> = ref('');
const status: Ref<number> = ref(0);
const routes: Array<Routes> = store.routes;
const currentUrl: string = page.props.ziggy.location;

let currentRoute: Ref<Route>;
for(let el in routes) {     
    currentRoute = ref(routes[el].routes.find(i => i.url == currentUrl));

    if(currentRoute.value)
        break
}

const api_url = computed(() => store.apiRoute(currentRoute.value));
const codeLines: Object = computed(() => {
    return [
        ...store.bodyCodeLines(currentRoute.value.bodyParams),
        {
            code: 'axios<span class="text-sky-300">.' + currentRoute.value.method.toLowerCase() + '</span><span class="text-amber-300">(</span><span class="text-lime-300">"' + api_url.value +'"</span>, body<span class="text-amber-300">)</span>',
            tab: 0
        },
        {
            code: '<span class="text-sky-300">.then</span><span class="text-amber-300">(</span><span class="text-fuchsia-400">(</span>res<span class="text-fuchsia-400">) =></span> <span class="text-fuchsia-400">{</span>',
            tab: 1
        },
        {
            code: 'response <span class="text-sky-200">=</span> res<span class="text-sky-300">.</span>data<span class="text-sky-200">;</span>',
            tab: 2
        },
        {
            code: '<span class="text-fuchsia-400">}</span><span class="text-amber-300">)</span><span class="text-sky-200">;</span>',
            tab: 1
        }
    ]
});

async function request() {
    loading.value = true

    const data = await store.request(currentRoute.value);

    response.value = data.response;
    status.value = data.status
    loading.value = false
}
</script>