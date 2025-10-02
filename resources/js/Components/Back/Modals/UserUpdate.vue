

<template>
<div class="absolute top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-full w-full bg-zinc-200 bg-opacity-50">

    <div class="absolute top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-80 w-80 bg-white shadow-2xl shadow-zinc-500 rounded-xl overflow-hidden">
        <div class="h-4 bg-zinc-800 w-full"></div>
        <div class="flex flex-col h-1/6 flex items-center mt-8"> 
            <h2 class="text-zinc-800 text-xl font-semibold">
                會員修改
            </h2>
            <!-- <hr class="w-1/2 my-2 border-zinc-600" /> -->
        </div>
        <div class="grid grid-cols-12 gap-4 h-3/6 mb-8"> 
            <div class = " col-start-3 col-end-11">
                <label for="name" class="block text-sm/6 font-semibold text-zinc-700">name</label>
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="tableData.name"
                    class="w-full border-0 border-b border-zinc-500 bg-white text-base text-zinc-700 placeholder:text-zinc-400 focus:outline-none focus:border-zinc-700">
            </div>
            <div class = " col-start-3 col-end-11">
                <label for="email" class="block text-sm/6 font-semibold text-zinc-700">Email</label>
                <input id="email" type="text" name="email" autocomplete="given-name" v-model="tableData.email"
                    class="w-full border-0 border-b border-zinc-500 bg-white text-base text-zinc-700 placeholder:text-zinc-400 focus:outline-none focus:border-zinc-700">
            </div>

            <div class = "col-start-3 col-end-11">
                <button @click="submit()" class="w-2/5 bg-zinc-500 text-white px-4 py-2 rounded-md hover:bg-white hover:text-zinc-500 transition-colors font-semibold">
                    修改
                </button>
                <button class="w-1/5"></button>
                <button @click="close()" class="w-2/5 bg-zinc-200 text-white px-4 py-2 rounded-md hover:bg-white hover:text-zinc-200 transition-colors font-semibold">
                    取消
                </button>
            </div>

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

const tableData = ref({
    name: '',
    email: '',
    password: '',
    rePassword: ''
})
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
        await axios.put('/api/back/user/' + props.data.id, 
            {
                name: tableData.value.name,
                email: tableData.value.email,
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