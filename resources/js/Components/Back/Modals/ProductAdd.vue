

<template>
<div class="fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-zinc-200 bg-opacity-50">

    <div class="grid grid-cols-6 px-7 py-7 justify-items-center overflow-y-auto max-h-[calc(100%)] fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-full  w-full md:w-5/6 md:h-5/6 bg-white shadow-2xl shadow-zinc-500 rounded-md ">
        <div class="col-span-6 w-full mb-1">
            <div class="w-full flex pt-1 mb-5">
                <h2 class="text-zinc-900 text-2xl font-semibold">
                    產品新增
                </h2>
            </div>
            <div class="w-full flex">
                <div :class="page == 1 ? 'bg-gray-200' :'' " @click="page = 1;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">基本參數</div>
                <div :class="page == 2 ? 'bg-gray-200' :'' " @click="page = 2;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">圖片設定</div>
                <div :class="page == 3 ? 'bg-gray-200' :'' " @click="page = 3;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">材料設定</div>
                <div :class="page == 4 ? 'bg-gray-200' :'' " @click="page = 4;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">產品描述</div>
            </div>
            <hr>
        </div>

        <!-- page 1 第一頁頁簽 -->
        <div class="col-span-3 w-full pr-2" v-if="page==1">
            <div class="mb-2">
                <label for="name" class="block text-sm/6 font-semi text-zinc-900">產品名稱 *</label>
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="tableData.name"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="product_code" class="block text-sm/6 font-semi text-zinc-900">產品代碼 *</label>
                <input id="product_code" type="text" name="product_code" autocomplete="given-code"  v-model="tableData.email"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="price" class="block text-sm/6 font-semi text-zinc-900">售價</label>
                <input id="price" type="number" name="price" autocomplete="given-price"  v-model="tableData.price"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="sort_order" class="block text-sm/6 font-semi text-zinc-900">排列順序 *</label>
                <input id="sort_order" type="number" name="sort_order" autocomplete="given-sort_order"  v-model="tableData.sort_order"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

        <div class="col-span-3 w-full pl-2" v-if="page==1">
            <div class="mb-2" v-for="value in category_number">
                <label for="password" class="block text-sm/6 font-semi text-zinc-900">產品類別</label>
                <VueSelect v-model="category[value-1]" :options="['Canada321', 'United States','123','321','321321']" ></VueSelect>
            </div>
            <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="category_number++" >
                新增類別
            </button>
            <button class="bg-gray-300 text-white rounded-md px-7 py-1 mr-1" v-if="category_number > 1" @click="category_number--" >
                刪除類別
            </button>
        </div>

        <!-- page 2 第二頁頁簽 --> 
        
        <div class="col-span-6 w-full pr-2 justify-items-center" v-if="page==2">
            <div class="grid grid-cols-6 ">
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="1"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="2"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="3"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="4"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="5"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="6"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="7"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="8"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="9"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="10"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="11"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :dir="'products'" :id="12"></imageUpload>
                </div>
            </div>
        </div>
        
        <!-- page 3 第三頁頁簽 -->
        <div class="col-span-6 grid grid-cols-6 w-full pl-2" v-if="page==3">
            <div class = "col-span-2">
                <div class="flex items center">
                    <input class="rounded-sm border border-gray-300 w-2/3 h-8 mb-4 " placeholder='分類依據 ex:顏色' v-model="group_name[0]" type="text"></input>
                    <button v-if="group_number==1" class="bg-gray-600 h-8 w-1/3 text-white rounded-md px-7 py-1 mr-1 " @click="group_number++" type="text">新增子類別</button>
                </div>
                <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="set_number_level1++ ; set_level.push({first:set_number_level1,second:null,data:null});set_number_level2.push(0)">+新增群組</button>
                <div v-for="set in set_level" >
                    <div class="w-full" v-if="set.second == null">
                        <div class="block text-sm/6 font-semi text-zinc-900">{{ set.first+1 }}</div>
                        <input class="rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <button :class="now_address[0] == set.first ? 'bg-gray-300':'bg-gray-500'" class="text-white rounded-md px-7 py-1 mr-1" @click="now_address[0] = set.first ; now_address[1]=null; ">選定 </button>
                    </div>
                </div>
            </div>

            <div class = "col-span-2" v-if="group_number == 2">
                <div class="flex items center">
                    <input class="rounded-sm border border-gray-300 h-8 mb-4" v-model="group_name[1]" placeholder='分類依據 ex:容量' type="text"></input>
                    <button class="bg-gray-600 h-8 w-1/3 text-white rounded-md px-7 py-1 mr-1 " @click="group_number--" type="text">刪除子類別</button>
                </div>
                <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="set_level.push({first:now_address[0],second:set_number_level2[now_address[0]],data:null});set_number_level2[now_address[0]]++ ;console.log(set_number_level2,'now_first',now_address[0])">+新增子群組</button>
                <div v-for="set in set_level" >
                    <div class="w-full" v-if="set.first==now_address[0] && set.second!=null">
                        <div class="block text-sm/6 font-semi text-zinc-900">{{ set.first+1 }}-{{ set.second+1 }}</div>
                        <input class="rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <button :class="now_address[1] ==  set.second ? 'bg-gray-300':'bg-gray-500'" class="text-white rounded-md px-7 py-1 mr-1" @click=" now_address[1] =  set.second;" >選定</button>
                    </div>
                </div>
            </div>


            <div class = "col-span-2" v-if="(group_number==1 && now_address[0] !=null) || (group_number==2 && now_address[1] !=null)">
                <div class="flex justify-end">
                    <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="set_material.push({first:now_address[0],second:now_address[1],data:null});">+新增材料</button>
                </div>
                <div v-for="set in set_material" >
                    <div class="w-full mb-3" v-if="set.first==now_address[0] && set.second == now_address[1]">
                        <VueSelect v-model="set.data" :options="['Canada321', 'United States','123','321','321321']" ></VueSelect>
                    </div>
                </div>
            </div>

            
        </div>

	    	
        
        <!-- 按鈕 -->
        <div class = "col-span-6 h-12 flex justify-between">
            <Editor/>
            <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="submit()" >
                新增
            </button>
            <button class="bg-gray-200 text-white rounded-md px-7 py-1 ml-1" @click="close()"  >
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
import  VueSelect  from "vue-select";
import imageUpload from '@/Components/Back/ImageUpload.vue';
import Editor from '@/Components/Back/Editor.vue'

let page = ref(1);
const props = defineProps({
    data: Object,
})
let img = ref(null);
let description = ref('');
let now_address = ref([0,0]);
let group_name = ref(['','']);
let set_number_level1 = ref(0);
let set_number_level2 = ref([0]);
let imgSrc = ref('');
let set_level  = ref([{
    first: 0,
    second: null,
    data:''
}])

let set_material= ref([{
    first: 0,
    second: null,
    data:''
}])

let group_number = ref(1); 
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


function uploadSuccess(returnData){
    console.log(returnData);
}
</script>