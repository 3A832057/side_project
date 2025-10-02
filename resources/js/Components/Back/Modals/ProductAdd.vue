

<template>
<div class="fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-zinc-200 bg-opacity-50">

    <div class="grid grid-cols-6 px-7 py-7 justify-items-center overflow-y-auto max-h-[calc(100%)] fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-4/5 md:w-5/6 w-full bg-white shadow-2xl shadow-zinc-500 rounded-md ">
        <div class="col-span-6 w-full">
            <div class="w-full flex pt-1">
                <h2 class="text-zinc-900 text-2xl font-semibold">
                    產品新增
                </h2>
            </div>
        </div>
        <div class="col-span-2 w-full pr-2">
            <div class="mb-3">
                <label for="name" class="block text-sm/6 font-semi text-zinc-900">產品名稱 *</label>
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="tableData.name"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-3">
                <label for="product_code" class="block text-sm/6 font-semi text-zinc-900">產品代碼 *</label>
                <input id="product_code" type="text" name="product_code" autocomplete="given-code"  v-model="tableData.email"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-3">
                <label for="price" class="block text-sm/6 font-semi text-zinc-900">售價 *</label>
                <input id="price" type="number" name="price" autocomplete="given-price"  v-model="tableData.price"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-3">
                <label for="sort_order" class="block text-sm/6 font-semi text-zinc-900">排列順序 *</label>
                <input id="sort_order" type="number" name="sort_order" autocomplete="given-sort_order"  v-model="tableData.sort_order"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

        <div class="col-span-2 w-full pl-1 pr-1">
            <div class="mb-3">
                <label for="password" class="block text-sm/6 font-semi text-zinc-900">產品類別</label>
                <input id="password" type="password" name="password" autocomplete="given-password"  v-model="tableData.password"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="block text-sm/6 font-semi text-zinc-900">確認密碼</label>
                <input id="password_confirm" type="password" name="password_confirm" autocomplete="given-password_confirm"  v-model="tableData.password_confirm"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

        <div class="col-span-2 w-full pl-2">
            <div class="mb-3">
                <label for="password" class="block text-sm/6 font-semi text-zinc-900">密碼</label>
                <input id="password" type="password" name="password" autocomplete="given-password"  v-model="tableData.password"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="block text-sm/6 font-semi text-zinc-900">確認密碼</label>
                <input id="password_confirm" type="password" name="password_confirm" autocomplete="given-password_confirm"  v-model="tableData.password_confirm"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class = "mb-3 flex justify-between mt-7">
                <button class="bg-blue-600 text-white rounded-md px-5 py-1" @click="submit()">
                    新增
                </button>
                <button class="bg-gray-200 text-white rounded-md px-5 py-1" @click="close()">
                    取消
                </button>
            </div>
        </div>
    </div>

</div>


</template>
<script setup>
import { defineProps, defineEmits ,ref, onMounted } from 'vue'
import axios, { all } from 'axios';
import Swal from 'sweetalert2';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    data: Object,
})

const tableData = ref({
    name: '',
    email: '',
    password: '',
    password_confirm: '',
});
const emit = defineEmits(['close'])

onMounted(() => {
    if (props.data) {
        tableData.value = { ...props.data };
    } else {
        tableData.value = {
            name: '',
            email: '',
        };
    }
});

function close() {
    console.log("關閉")
    emit('close')
}


async function submit() {

    let returnData = 
        await axios.post('/back/register' , 
            {
                name: tableData.value.name,
                email: tableData.value.email,
                password: tableData.value.password,
                password_confirmation: tableData.value.password_confirm,
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


</script>