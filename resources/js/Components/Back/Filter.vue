<script setup>
import { ref, watch, onMounted } from 'vue'


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
    nowInput.value[i] = selected 
  }
}, { deep: true })

let selectType = ref([
    {value: '=', text: '='},
    {value: '>', text: '>'},
    {value: '>=', text: '>='},
    {value: '<', text: '<'},
    {value: '<=', text: '<='},
]);
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
    await search();

});

const emit = defineEmits(['search'])

async function search() {
    filter = [];
    for (let i = 0; i < filterNum.value; i++) {
        filter.push({field: filterField.value[i], type: filterType.value[i], value: filterValue.value[i]});
    }
    console.log(filter);
    emit('search', filter);
}
</script>

<template>
    <button class="me-3 mb-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" @click="filterNum++">新增條件</button>
    <button class ="me-3 mb-4 bg-sky-500 text-white px-4 py-2 rounded hover:bg-sky-600" @click="filterNum>0 ? filterNum-- : filterNum">刪除條件</button>
    <button class="mb-4 bg-violet-500 text-white px-4 py-2 rounded hover:bg-violet-600" @click="search">搜尋</button>



    <div v-for="count of filterNum"  >
        <select class="inline" v-model="filterField[count - 1]">
            <option :value="filed.value"  v-for="filed in selectField">{{ filed.text }}</option>
        </select>
        <div class="inline" v-if="nowInput[count - 1]?.type === 'text'">
            <select v-model="filterType[count - 1]">
                <option  v-for="type in selectType" :value=type.value>{{type.text}}</option>
            </select>
            <input v-model="filterValue[count - 1]" type="text"  />
        </div>
        <div class="inline" v-else-if="nowInput[count - 1]?.type === 'date'">
            <select v-model="filterType[count - 1]">
                <option  v-for="type in selectType" :value=type.value>{{type.text}}</option>
            </select>
            <input v-model="filterValue[count - 1]" type="date"  />
        </div>
        <div class="inline" v-else-if="nowInput[count - 1]?.type === 'select'">
            <select v-model="filterType[count - 1]">
                <option value="=">=</option>
            </select>
            <select v-model="filterValue[count - 1]">
                <option :value="option.value" v-for="option in nowInput[count - 1].options ">{{ option.text }}</option>
            </select>
        </div>
    
    </div>
    
    
</template>
