<template>
    <div :class="classes">
        <p class=" text-neutral-300 text-sm font-bold">{{ data.name }} <span class="text-neutral-400 text-xs ml-1 font-normal" v-html="types"></span></p>

        <select v-if="input == 'select'" v-model="data.value" class="text-sm py-1 px-2 rounded-lg bg-neutral-700 text-neutral-300 border-neutral-700 w-52" placeholder="Select">
            <option v-for="i in options" :value="i">{{ i }}</option>
        </select>

        <input type="text" v-else-if="types.includes('string')" class="text-sm py-1 px-2 rounded-lg bg-neutral-700 text-neutral-300 border-neutral-700 w-52" v-model="data.value" @input="$emit('updateValue', props.data)">

        <input :type="type[0]" v-else-if="test.some(i => types.includes(i))" class="text-sm py-1 px-2 rounded-lg bg-neutral-700 text-neutral-300 border-neutral-700 w-52" v-model="data.value" @input="$emit('updateValue', props.data)">
        
        <input type="text" v-else v-mask="mask" class="text-sm py-1 px-2 rounded-lg bg-neutral-700 text-neutral-300 border-neutral-700 w-52" v-model="data.value" @input="$emit('updateValue', props.data)">
        
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { computed } from 'vue';

const props = defineProps<{
    data: Object;
    index: number;
    total: number;
    type: Array<String>;
    input?: string;
    options?: Array<String>;
}>();

const base = "w-full py-3 px-2 bg-neutral-800 border border-neutral-700 flex justify-between items-center border-collapse";

const types = props.data.types.toString().replaceAll(',', ' ').replace('required', '<span class="text-rose-700">required</span>')

const test = [
    'email',
    'password'
];

const classes = computed(function() {
    if(props.total == 1)
        return base + ' rounded-lg';

    if(props.index == 0)
        return base + ' rounded-lg rounded-b-none';

    if(props.index == (props.total - 1))
        return base + ' rounded-lg rounded-t-none';

    return base;
});

const mask = computed(function() {   
    if(props.type.includes('decimal'))
        return ['##', '##,#', '##,##', '###,##', '####,##', '##.###,##'];
    if(props.type.includes('int')) 
        return '######';
});

</script>