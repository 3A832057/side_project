<template>
<div class="fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-zinc-200 bg-opacity-50">

    <div class="grid grid-cols-6 px-7 py-7 justify-items-center overflow-y-auto max-h-[calc(100%)] fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-full  w-full md:w-1/2 md:h-5/6 bg-white shadow-2xl shadow-zinc-500 rounded-md ">
        <div class="col-span-6 w-full mb-1">
            <div class="w-full flex pt-1 mb-5">
                <h2 class="text-zinc-900 text-2xl font-semibold">
                    材料修改
                </h2>
            </div>
        </div>

        <!-- page 1 第一頁頁簽 -->
        <div class="col-span-6 w-full pr-2">
            <div class="mb-5 ">
                <label for="name" :class="danger_message.name == defalut_message.name ? 'text-zinc-700' :'text-red-400'" class="block text-sm/6 font-semi">{{ danger_message.name }}</label>
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="name"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-5 ">
                <label for="material_code" :class="danger_message.material_code == defalut_message.material_code ? 'text-zinc-700' :'text-red-400'" class="block text-sm/6 font-semi">{{ danger_message.material_code }}</label>
                <input id="material_code" type="text" name="material_code" autocomplete="given-code"  v-model="material_code"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-5 ">
                <label for="cost" :class="danger_message.cost == defalut_message.cost ? 'text-zinc-700' :'text-red-400'" class="block text-sm/6 font-semi">{{ danger_message.cost }}</label>
                <input id="cost" type="number" name="cost" autocomplete="given-cost"  v-model="cost"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
            <div class="mb-5 ">
                <label for="low_danger" :class="danger_message.low_danger == defalut_message.low_danger ? 'text-zinc-700' :'text-red-400'" class="block text-sm/6 font-semi">{{ danger_message.low_danger }}</label>
                <input id="low_danger" type="number" name="low_danger" autocomplete="given-low_danger"  v-model="low_danger"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

      
        <!-- 按鈕 -->
        <div class = "col-span-6 h-12 flex justify-end gap-2">
            <button class="bg-blue-600 text-white rounded-md px-7 py-1" @click="submit()" >
                修改
            </button>
            <button class="bg-gray-200 text-white rounded-md px-7 py-1" @click="close()"  >
                取消
            </button>
        </div>

    </div>

</div>

</template>
<script setup>
import { ref, onMounted } from 'vue'
import axios, { all } from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    data: Object,
})

let name = ref('');
let material_code = ref('');
let cost = ref(0);
let low_danger = ref(0);

let defalut_message = ref({
    'name': '材料名稱 *',
    'material_code': '材料代碼 *',
    'cost': '成本價格 *',
    'low_danger': '最低水位 *',
});
let danger_message = ref({
    'name': '',
    'material_code': '',
    'cost': '',
    'low_danger': '',
});

const emit = defineEmits(['close'])

onMounted(async () => {
    await findMaterial();
    danger_message.value = defalut_message.value;

});

function close() {
    console.log("關閉")
    emit('close')
}



async function findMaterial(){
    let returnData = 
    await axios.get('/api/back/material/find/'+ props.data.id)  
   

    if (returnData.data.success) {
        name.value = returnData.data.data.name ;
        material_code.value = returnData.data.data.material_code;
        cost.value = returnData.data.data.cost;
        low_danger.value = returnData.data.data.low_danger;

        
    } else {
        console.error(returnData.data.message)
        await Swal.fire({
            icon:'error',
            title:'取得材料失敗',
            text: returnData.data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}

async function submit() {

    let isValid = await validate();
    if (!isValid) {
        return;
    }

    let returnData = 
        await axios.put('/api/back/material/' + props.data.id,  
            {
                name: name.value,
                material_code: material_code.value,
                cost: cost.value,
                low_danger: low_danger.value,
            }
        )

    if (returnData.data.success) {
        
        await Swal.fire({
            icon: 'success',
            title: '修改成功',
            showConfirmButton: false,
            timer: 1500
        })
        emit('close')

    } else {
        console.error(returnData.data.message)
        await Swal.fire({
            icon:'error',
            title:'修改失敗',
            text: returnData.data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
  
}

async function validate() {
    let isValid = true;
    danger_message.value = { ...defalut_message.value };

    if (!name.value) {
        danger_message.value.name = '材料名稱 為必填欄位';
        isValid = false;
    }
    if (!material_code.value) {
        danger_message.value.material_code = '材料代碼 為必填欄位';
        isValid = false;
    }
    if (cost.value <= 0) {
        danger_message.value.cost = '成本價格 必須大於0';
        isValid = false;
    }
    if (low_danger.value < 0) {
        danger_message.value.low_danger = '最低水位 不能小於0';
        isValid = false;
    }

    return isValid;
}
</script>