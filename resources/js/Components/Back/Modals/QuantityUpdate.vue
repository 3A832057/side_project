

<template>
<div class="fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-zinc-200 bg-opacity-50">

    <div class="grid grid-cols-6 px-7 py-7 justify-items-center overflow-y-auto max-h-[calc(100%)] fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-full  w-full md:w-1/2 md:h-5/6 bg-white shadow-2xl shadow-zinc-500 rounded-md ">
        <div class="col-span-6 w-full mb-1">
            <div class="w-full flex pt-1 mb-5">
                <h2 class="text-zinc-900 text-2xl font-semibold">
                    材料新增
                </h2>
            </div>
        </div>

        <!-- page 1 第一頁頁簽 -->
        <div class="col-span-6 w-full pr-2">
            <div class="mb-2">
                <label for="name" class="block text-sm/6 font-semi text-zinc-900">材料*</label>
                <VueSelect
                    v-model="id"
                    :options="materials_list"
                    label="display"
                    :reduce="reduceToId"
                ></VueSelect>
            </div>
            <div class="mb-2">
                <label for="quantity" class="block text-sm/6 font-semi text-zinc-900">異動數量</label>
                <input id="quantity" type="number" name="quantity" autocomplete="given-quantity" @change="updateAfter"  v-model.number="quantity"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <p >原始數量:{{ before }}，變動後數量:{{ after }}</p>
            <div class="mb-2">
                <label for="description" class="block text-sm/6 font-semi text-zinc-900">描述</label>
                <textarea id="description" name="description" autocomplete="given-description"  v-model="description"
                        class="w-full rounded-sm border border-gray-300 h-32">
                </textarea>
            </div>
            
        </div>

      
        <!-- 按鈕 -->
        <div class = "col-span-6 h-12 flex justify-end gap-2">
            <button class="bg-blue-600 text-white rounded-md px-7 py-1" @click="submit()" >
                新增
            </button>
            <button class="bg-gray-200 text-white rounded-md px-7 py-1" @click="close()"  >
                取消
            </button>
        </div>

    </div>

</div>

</template>
<script setup>
import { watch , ref, onMounted } from 'vue'
import axios, { all } from 'axios';
import Swal from 'sweetalert2';
import  VueSelect  from "vue-select";

let id = ref(null);
let quantity = ref(0);
let before = ref(0);
let after = ref(0);
let description = ref('');

let materials_list = ref([]);

const emit = defineEmits(['close'])

onMounted(async () => {
    await getMaterialList();

});

watch(id, async (newVal, oldVal) => {
    if (!newVal) {
        before.value = 0;
        return;
    }
    await findMaterial(newVal);
});

function reduceToId(option) {
    return option ? option.id : null;
}

function close() {
    console.log("關閉")
    emit('close')
}


async function getMaterialList(){
    let returnData = 
    await axios.get('/api/back/material/getAllWithEnabled' , 
        {
            params: {
                is_enabled: 1
            }
        }
    )

    if (returnData.data.success) {
        materials_list.value = returnData.data.data.map(item => ({
            ...item,
            display: buildDisplayMaterial(item)
        }));

    } else {
        console.error(returnData.data.message)
        await Swal.fire({
            icon:'error',
            title:'取得類別失敗',
            text: returnData.data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}

function buildDisplayMaterial(option) {
    if (!option) return '';
    
    return option.name+' ('+option.material_code+')';
};

function updateAfter() {
    after.value = Number(before.value) + Number(quantity.value);
}

async function findMaterial(id){
    if (!id) return;

    let returnData = await axios.get('/api/back/material/find/' + id);

    if (returnData.data.success) {
        before.value = Number(returnData.data.data.quantity) || 0;
        updateAfter();
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

    
    let returnData = await axios.put('/api/back/material/quantity', {
        material_id: id.value,
        description: description.value,
        before: before.value,
        quantity: quantity.value,
        after: after.value
    })

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





</script>