<script setup>
import { ref, watch, onMounted ,nextTick } from 'vue'


let filterNum = ref(1);
let filterField = ref([]);
let filterType = ref([]);
let filterValue = ref([]);
let filter = [];
let nowInput = ref([{}]);

const props = defineProps({
    selectField: Array,
})

watch(filterField, (newFields) => {
// selectField是可以搜尋的欄位選項
// nowInput是根據selectField找出的此搜尋欄預設變數
// filterField是目前使用者要查詢的所有內容
// 如果使用者更改查詢欄位，就會去selectField找出對應的預設值，並放到nowInput陣列中，決定要畫甚麼樣的輸入框
  for (let i = 0; i < newFields.length; i++) {
    let selected=[]
    selected = props.selectField.find(item => item.value === newFields[i])
    if(filterType.value[i] === undefined){ //如果都沒有選過，就給預設值
        filterType.value[i] = '=';
    }
    nowInput.value[i] = selected 
  }
}, { deep: true })

onMounted(async () => {
    
    await props.selectField.forEach(element => {
        if(element.default !== undefined){
            filterField.value.push(element.value)
            nowInput.value.push(element)
            filterType.value.push('=')
            filterValue.value.push(element.default)
        }
    });

    if(filterField.value.length === 0){
        return;
    }
    await nextTick()

    await search();

});

const emit = defineEmits(['search'])

async function search() {
    filter = [];
    for (let i = 0; i < filterNum.value; i++) {
        let join_table = nowInput.value[i]?.join_table ? nowInput.value[i].join_table : null;
        filter.push({field: filterField.value[i], type: filterType.value[i], value: filterValue.value[i], join_table: join_table});
    }
    await emit('search', filter);
}
</script>

<template>
    <div class="mb-4  p-4 border-gray-100 border-b-2 rounded  grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 ">
        <button class="col-span-1 lg:col-span-2 me-3 mb-4 bg-teal-400 text-white px-4 py-2 rounded hover:bg-teal-800" @click="filterNum++">新增條件</button>
        <button class ="col-span-1 lg:col-span-2 me-3 mb-4 bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-800" @click="filterNum>0 ? filterNum-- : filterNum">刪除條件</button>
        <button class="col-span-1 lg:col-span-2 mb-4 bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-800" @click="search">搜尋</button>

        <div v-for="count of filterNum"  class="w-5/6 text-gray-500 mb-4 col-span-3 flex ">
            <select class="inline flex-none w-1/3 rounded-sm border border-gray-300" v-model="filterField[count - 1]" >
                <option :value="filed.value"  v-for="filed in selectField">{{ filed.text }}</option>
            </select>
            <div class="inline flex-none w-2/3 flex" v-if="nowInput[count - 1]?.type === 'text'">
                <select v-model="filterType[count - 1]" class="flex-none w-1/4 rounded-sm border border-gray-300">
                    <option value='=' selected> = </option>
                    <option value='like'>包含</option>
                    <option value='>'>></option>
                    <option value='>='>>=</option>
                    <option value='<'><</option>
                    <option value='<='><=</option>
                </select>
                <input v-model="filterValue[count - 1]" class="flex-1 rounded-sm border border-gray-300" type="text"  />
            </div>
            <div class="inline flex-none w-2/3 flex" v-else-if="nowInput[count - 1]?.type === 'date'">
                <select v-model="filterType[count - 1]" class="flex-none w-1/4 rounded-sm border border-gray-300">
                    <option value="=">=</option>
                    <option value=">">></option>
                    <option value=">=">>=</option>
                    <option value="<"><</option>
                    <option value="<="><=</option>
                </select>
                <input v-model="filterValue[count - 1]" class="flex-1 rounded-sm border border-gray-300" type="date"  />
            </div>
            <div class="inline flex-none w-2/3 flex" v-else-if="nowInput[count - 1]?.type === 'select'">
                <select v-model="filterType[count - 1]" class="flex-none w-1/4 rounded-sm border border-gray-300">
                    <option value="=" selected>=</option>
                </select>
                <select v-model="filterValue[count - 1]" class="flex-1 w-full rounded-sm border border-gray-300">
                    <option :value="option.value" v-for="option in nowInput[count - 1].options ">{{ option.text }}</option>
                </select>
            </div>
            
        </div>
    </div>
    
</template>
