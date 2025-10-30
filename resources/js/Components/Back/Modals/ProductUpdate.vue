

<template>
<div class="fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-zinc-200 bg-opacity-50">

    <div class="grid grid-cols-6 px-7 py-7 justify-items-center overflow-y-auto max-h-[calc(100%)] fixed top-1/2 left-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 h-full  w-full md:w-5/6 md:h-5/6 bg-white shadow-2xl shadow-zinc-500 rounded-md ">
        <div class="col-span-6 w-full mb-1">
            <div class="w-full flex pt-1 mb-5">
                <h2 class="text-zinc-900 text-2xl font-semibold">
                    產品修改
                </h2>
            </div>
            <div class="w-full flex">
                <div :class="page == 1 ? 'bg-gray-200' :'' , header_default_message.page1 == header_danger_message.page1 ? 'text-zinc-900' : 'text-red-400'" @click="page = 1;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">{{ header_danger_message.page1 }}</div>
                <div :class="page == 2 ? 'bg-gray-200' :'' , header_default_message.page2 == header_danger_message.page2 ? 'text-zinc-900' : 'text-red-400'" @click="page = 2;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">{{ header_danger_message.page2 }}</div>
                <div :class="page == 3 ? 'bg-gray-200' :'' , header_default_message.page3 == header_danger_message.page3 ? 'text-zinc-900' : 'text-red-400'" @click="page = 3;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">{{ header_danger_message.page3 }}</div>
                <div :class="page == 4 ? 'bg-gray-200' :'' , header_default_message.page4 == header_danger_message.page4 ? 'text-zinc-900' : 'text-red-400'" @click="page = 4;" class=" w-1/6 px-4 py-1 rounded-md hover:bg-gray-100">{{ header_danger_message.page4 }}</div>
            </div>
            <hr>
        </div>

        <!-- page 1 第一頁頁簽 -->
        <div class="col-span-3 w-full pr-2" v-show="page==1">
            <div class="mb-2">
                <label for="name" :class="page1_danger_message.name == page1_default_message.name ? 'text-zinc-900' :'text-red-400'" class="block text-sm/6 font-semi">{{ page1_danger_message.name }}</label>
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="page1.name"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="product_code" :class="page1_danger_message.product_code == page1_default_message.product_code ? 'text-zinc-900' :'text-red-400'"  class="block text-sm/6 font-semi">{{ page1_danger_message.product_code }}</label>
                <input id="product_code" type="text" name="product_code" autocomplete="given-code"  v-model="page1.product_code"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="price" :class="page1_danger_message.price == page1_default_message.price ? 'text-zinc-900' :'text-red-400'" class="block text-sm/6 font-semi">{{ page1_danger_message.price }}</label>
                <input id="price" type="text" name="price" autocomplete="given-price"  v-model="page1.price"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="sort_order" :class="page1_danger_message.sort_order == page1_default_message.sort_order ? 'text-zinc-900' :'text-red-400'" class="block text-sm/6 font-semi">{{ page1_danger_message.sort_order }}</label>
                <input id="sort_order" type="number" name="sort_order" autocomplete="given-sort_order"  v-model="page1.sort_order"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

        <div class="col-span-3 w-full pl-2" v-show="page==1">
            <label for="password" :class="page1_danger_message.categories == page1_default_message.categories ? 'text-zinc-900' :'text-red-400'" class="block text-sm/6 font-semi">{{ page1_danger_message.categories }}</label>
            <div class="mb-2" v-for="(catego, idx) in categories" :key="idx">
                <VueSelect
                    v-model="categories[idx]"
                    :options="categories_list"
                    label="display"
                    :reduce="reduceToId"
                ></VueSelect>
            </div>
            <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="categories.push(null)" >
                新增類別
            </button>
            <button class="bg-gray-300 text-white rounded-md px-7 py-1 mr-1" v-if="categories.length > 1" @click="categories.pop()" >
                刪除類別
            </button>
        </div>

        <!-- page 2 第二頁頁簽 --> 
        <div class="col-span-6 w-full pr-2 justify-items-center" v-if="page==2">
            <div class="grid grid-cols-6 ">
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[0]" :dir="'products'" :id="0"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[1]" :dir="'products'" :id="1"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[2]" :dir="'products'" :id="2"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[3]" :dir="'products'" :id="3"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[4]" :dir="'products'" :id="4"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[5]" :dir="'products'" :id="5"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[6]" :dir="'products'" :id="6"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[7]" :dir="'products'" :id="7"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[8]" :dir="'products'" :id="8"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[9]" :dir="'products'" :id="9"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[10]" :dir="'products'" :id="10"></imageUpload>
                </div>
                <div class="col-span-1">
                    <imageUpload @uploadSuccess = uploadSuccess :imgSrc="images[11]" :dir="'products'" :id="11"></imageUpload>
                </div>
            </div>
        </div>
        
        <!-- page 3 第三頁頁簽 -->
        <div class="col-span-6 grid grid-cols-6 w-full pl-2" v-show="page==3">
            <div class = "col-span-2">
                <div class="flex items center">
                    <input class="rounded-sm border border-gray-300 w-2/3 h-8 mb-4 " placeholder='分類依據 ex:顏色' v-model="group_name[0]" type="text"></input>
                    <button v-if="group_number==1" class="bg-gray-600 h-8 w-1/3 text-white rounded-md px-7 py-1 mr-1 " @click="group_number++" type="text">新增子類別</button>
                </div>
                <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="set_number_level1++ ; sets.push({first:set_number_level1,second:null,data:null});set_number_level2.push(0)">+新增群組</button>
                <div v-for="set in sets" >
                    <div class="w-full" v-if="set.second == null">
                        <div class="block text-sm/6 font-semi text-zinc-900">{{ set.first+1 }}</div>
                        <div v-if="sets_danger[set.first] && sets_danger[set.first].data" class="text-red-400 text-sm mt-1">{{ sets_danger[set.first].data }}</div>
                        <div v-if="sets_danger[set.first] && sets_danger[set.first].price" class="text-red-400 text-sm mt-1">{{ sets_danger[set.first].price }}</div>

                        <label v-if="group_number==1" for ="SetName{{ set.first }}"> 組合顯示名稱/組合售價</label>
                        <label v-if="group_number==2" for ="SetName{{ set.first }}"> 組合顯示名稱</label>

                        <input id="SetName{{ set.first }}" class="w-2/3 rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <input v-if="group_number == 1" class="w-1/3 rounded-sm border border-gray-300 h-8" v-model="set.price" type="number"></input>
                        <button :class="now_address[0] == set.first ? 'bg-gray-300':'bg-gray-500'" class="text-white rounded-md px-7 py-1 mr-1" @click="now_address[0] = set.first ; now_address[1]=null; ">選定 </button>
                        <button class="bg-red-500 text-white rounded-md px-7 py-1 mr-1" @click="removeSet(set.first , null);">刪除</button>
                    </div>
                </div>
            </div>

            <div class = "col-span-2" v-if="group_number == 2">
                <div class="flex items center">
                    <input class="rounded-sm border border-gray-300 h-8 mb-4" v-model="group_name[1]" placeholder='分類依據 ex:容量' type="text"></input>
                    <button class="bg-gray-600 h-8 w-1/3 text-white rounded-md px-7 py-1 mr-1 " @click="group_number--" type="text">刪除子類別</button>
                </div>
                <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="sets.push({first:now_address[0],second:set_number_level2[now_address[0]],data:null});set_number_level2[now_address[0]]++ ;console.log(set_number_level2,'now_first',now_address[0])">+新增子群組</button>
                <div v-for="set in sets" >
                    <div class="w-full" v-if="set.first==now_address[0] && set.second!=null">
                        <div class="block text-sm/6 font-semi text-zinc-900">{{ set.first+1 }}-{{ set.second+1 }}</div>
                        <div v-if="sets_danger[set.first] && sets_danger[set.first].data" class="text-red-400 text-sm mt-1">{{ sets_danger[set.first].data }}</div>
                        <div v-if="sets_danger[set.first] && sets_danger[set.first].price" class="text-red-400 text-sm mt-1">{{ sets_danger[set.first].price }}</div>

                        <label for ="SetName{{ set.first }}{{ set.second }}"> 組合顯示名稱/組合售價</label>
                        <input id="SetName{{ set.first }}{{ set.second }}" class="w-2/3 rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <input v-if="group_number == 2" class="w-1/3 rounded-sm border border-gray-300 h-8" v-model="set.price" type="number"></input>
                        <button :class="now_address[1] ==  set.second ? 'bg-gray-300':'bg-gray-500'" class="text-white rounded-md px-7 py-1 mr-1" @click=" now_address[1] =  set.second;" >選定</button>
                        <button class="bg-red-500 text-white rounded-md px-7 py-1 mr-1" @click="removeSet(set.first , set.second);">刪除</button>
                    </div>
                </div>
            </div>
            <div class = "col-span-1" v-if="group_number != 2"></div>


            <div class = "col-span-2" v-if="(group_number==1 && now_address[0] !=null) || (group_number==2 && now_address[1] !=null)">
                <div class="flex justify-end">
                    <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="set_material.push({first:now_address[0],second:now_address[1],data:null});">+新增材料</button>
                    <button class="bg-red-500 text-white rounded-md px-7 py-1 mr-1" @click="set_material.pop({first:now_address[0],second:now_address[1]});">-刪除材料</button>
                </div>
                <div v-for="(set, smIdx) in set_material" :key="smIdx">
                    <div class="w-full mb-3" v-if="set.first==now_address[0] && set.second == now_address[1]">
                        <VueSelect
                            v-model="set.data"
                            :options="materials_list"
                            label="display"
                            :reduce="reduceToId"
                        ></VueSelect>
                        <div v-if="sets_danger[set.first] && sets_danger[set.first].set_material && sets_danger[set.first].set_material[getLocalSetMaterialIndex(smIdx)]" class="text-red-400 text-sm mt-1">{{ sets_danger[set.first].set_material[getLocalSetMaterialIndex(smIdx)] }}</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- page 4 第四頁頁簽 -->
        <div class="col-span-6 w-full pr-2" v-if="page==4" >
            <Editor v-model:content="description"  />
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
import  VueSelect  from "vue-select";
import imageUpload from '@/Components/Back/ImageUpload.vue';
import Editor from '@/Components/Back/Editor.vue'

let page = ref(1);
const props = defineProps({
    data: Object,
})
let page1 = ref({
    name: '',
    product_code: '',
    price: 0,
    sort_order: 0,
});

let categories = ref([]);
let categories_list = ref([]);
let materials_list = ref([]);
let description = ref('');
let now_address = ref([0,null]);
let group_name = ref(['','']);
let set_number_level1 = ref(0);
let set_number_level2 = ref([]);
let sets  = ref([]);
// per-set error messages (indexed by sets' first index)
let sets_danger = ref([]);
let images = ref(['','','','','','','','','','','','']);
let set_material= ref([])

let group_number = ref(1); 
let page1_default_message = ref({
    name: '產品名稱 *',
    product_code: '產品代碼 *',
    price: '產品售價 *',
    sort_order: '排列順序 *',
    categories: '產品類別',
});
let page1_danger_message = ref({
    name: '',
    product_code: '',
    price: '',
    sort_order: '',
    categories: '',
});


let header_default_message = ref({
    page1: '基本參數',
    page2: '圖片設定',
    page3: '材料設定',
    page4: '產品描述',
});
let header_danger_message = ref({
    page1: '',
    page2: '',
    page3: '',
    page4: '',
});

const emit = defineEmits(['close'])

onMounted(async () => {
    await getCategoriesList();
    await getMaterialList();
    await findProduct();

    header_danger_message.value = header_default_message.value;
    page1_danger_message.value = page1_default_message.value;

});

// 將 option 物件轉成要放入 v-model 的值（只要 id）
const reduceToId = (option) => option ? option.id : null;

// 組合層級顯示字串：Parent > Child > ...
const buildDisplay = (option) => {
    if (!option) return '';
    const names = [];
    let cur = option;

    // 只要 有 parent 物件，就沿著 parent 往上串
    while (cur) {
        
        if (cur.name) names.unshift(cur.name);

        //移到下一個parent
        cur = cur.parent;
    }
    return names.join(' > ');
};

function close() {
    console.log("關閉")
    emit('close')
}

async function findProduct(){
    let returnData = 
    await axios.get(`/api/back/product/find/${props.data.id}`)
    if (returnData.data.success) {
        let data = returnData.data.data;
        page1.value.name = data.name;
        page1.value.product_code = data.product_code;
        page1.value.price = data.price;
        page1.value.sort_order = data.sort_order;
        description.value = data.description;

        //處理類別
        categories.value = data.categories.map(item => item.id);

        //處理圖片
        data.images.forEach((img, index) => {
            if(index < 12) images.value[index] = img.url;
        });

        //處理材料設定
        if(data.sets){
            if(data.groups.length > 0){
                group_number.value = data.groups.length;
                group_name.value[0] = data.groups[0].name;
                if(data.groups[1]) group_name.value[1] = data.groups[1].name;
            }

            let temp_sets_parent = [{id: null, first: null}];

            data.sets.forEach(set => {
                if(set.level == 1){
                    sets.value.push({
                        first: set_number_level1.value,
                        second: null,
                        data: set.name,
                        price: set.price,
                    });

                    temp_sets_parent.push({id: set.id, first: set_number_level1.value ,second: null});
                    set_number_level1.value++;
                    set_number_level2.value.push(0);
                } else if (set.level == 2){
                    sets.value.push({
                        first: temp_sets_parent.find(s => s.id == set.parent_id && s.second == null).first,
                        second: set_number_level2.value[temp_sets_parent.find(s => s.id == set.parent_id && s.second == null).first],
                        data: set.name,
                        price: set.price,
                    });

                    temp_sets_parent.push({id: set.id, first: temp_sets_parent.find(s => s.id == set.parent_id && s.second == null).first, second: set_number_level2.value[temp_sets_parent.find(s => s.id == set.parent_id && s.second == null).first]});
                    set_number_level2.value[temp_sets_parent.find(s => s.id == set.parent_id ).first]++;
                }

                set.materials.forEach(mat => {
                    temp_sets_parent.forEach(item => {
                       if(item.id == mat.pivot.set_id){
                            set_material.value.push({
                               first: item.first ,
                               second: item.second, 
                               data: mat.id,
                           });
                       }
                    });
                });
            });
        }
        console.log("sets:",set_material);

    } else {
        console.error(returnData.data.message)
        await Swal.fire({
            icon:'error',
            title:'取得產品失敗',
            text: returnData.data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}

async function getCategoriesList(){
    let returnData = 
    await axios.get('/api/back/category/getAllWithEnabled' , 
        {
            params: {
                is_enabled: 1
            }
        }
    )

    if (returnData.data.success) {
        // 為每個 option 預先計算 display（層級顯示字串），再賦值
        categories_list.value = returnData.data.data.map(item => ({
            ...item,
            display: buildDisplay(item)
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

async function submit() {

    page1_danger_message.value = { ...page1_default_message.value };
    header_danger_message.value = { ...header_default_message.value };
    sets_danger.value = [];

    const payload = {
        product: {
            name: page1.value.name,
            product_code: page1.value.product_code,
            price: page1.value.price,
            sort_order: page1.value.sort_order,
            description: description.value,
        },
        categories: categories.value,
        images: images.value,
        set: {
            group_number: group_number.value,
            group_name: group_name.value,
            sets: sets.value,
            set_material: set_material.value,
        }
    };

    try {
        const returnData = await axios.put('/api/back/product/edit/' + props.data.id, payload, { headers: { Accept: 'application/json' } });

        if (returnData.data.success) {
            await Swal.fire({ icon: 'success', title: '修改成功', showConfirmButton: false, timer: 1500 });
            emit('close');
            return;
        }

        console.error(returnData.data.message);
        await Swal.fire({ icon: 'error', title: '修改失敗', text: returnData.data.message, showConfirmButton: false, timer: 1500 });

    } catch (err) {
        if (err.response) {
            const status = err.response.status;
            const data = err.response.data || {};

            if (status === 422) {
                const errors = data.errors || {};
                console.log('Validation errors:', errors);
                for (const key in errors) {
                    const msg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];

                    if (key.includes('product.name') || key === 'name') {
                        page1_danger_message.value.name = msg;
                        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
                        continue;
                    }
                    if (key.includes('product.product_code') || key === 'product_code') {
                        page1_danger_message.value.product_code = msg;
                        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
                        continue;
                    }
                    if (key.includes('product.price') || key === 'price') {
                        page1_danger_message.value.price = msg;
                        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
                        continue;
                    }
                    if (key.includes('product.sort_order') || key === 'sort_order') {
                        page1_danger_message.value.sort_order = msg;
                        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
                        continue;
                    }
                    if (key.startsWith('categories')) {
                        page1_danger_message.value.categories = msg;
                        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
                        continue;
                    }

                    if (key === 'images' || key.startsWith('images')) {
                        header_danger_message.value.page2 = msg;
                        continue;
                    }

                    if (key.includes('product.description') || key === 'description') {
                        page4_danger_message.description = msg;
                        header_danger_message.value.page4 = '產品描述 (有欄位錯誤)';
                        continue;
                    }

                    if (key.startsWith('set.group_name')) {
                        const parts = key.split('.');
                        const idx = parseInt(parts[2] ?? -1);
                        if (!isNaN(idx) && idx >= 0) {
                            page3_danger_message.value.group_name[idx] = msg;
                        } else {
                            page3_danger_message.value.set_name = msg;
                        }
                        header_danger_message.value.page3 = '材料/組合設定 (有欄位錯誤)';
                        continue;
                    }

                    let m;
                    if ((m = key.match(/^set\.sets\.(\d+)\.price/))) {
                        const idx = parseInt(m[1]);
                        if (!sets_danger.value[idx]) sets_danger.value[idx] = {};
                        sets_danger.value[idx].price = msg;
                        header_danger_message.value.page3 = '材料/組合設定 (有欄位錯誤)';
                        continue;
                    }
                    if ((m = key.match(/^set\.sets\.(\d+)\.data/))) {
                        const idx = parseInt(m[1]);
                        if (!sets_danger.value[idx]) sets_danger.value[idx] = {};
                        sets_danger.value[idx].data = msg;
                        header_danger_message.value.page3 = '材料/組合設定 (有欄位錯誤)';
                        continue;
                    }

                    if ((m = key.match(/^set\.set_material\.(\d+)(?:\.(\d+))?\.data/))) {
                        const idx = parseInt(m[1]);
                        if (!sets_danger.value[idx]) sets_danger.value[idx] = {};
                        sets_danger.value[idx].data = msg;
                        header_danger_message.value.page3 = '材料/組合設定 (有欄位錯誤)';
                        continue;
                    }

                    if (key.startsWith('set.sets') || key.startsWith('set.group_number')) {
                        page3_danger_message.value.set_name = msg;
                        header_danger_message.value.page3 = '材料/組合設定 (有欄位錯誤)';
                        continue;
                    }
                }

                const messages = Object.values(errors).flat().join('<br>');
                await Swal.fire({ icon: 'error', title: '請確認資料是否填妥' });
                return;
            }

            await Swal.fire({ icon: 'error', title: `錯誤 (${status})`});
            return;
        }

        // network or unknown error
        console.error(err);
        await Swal.fire({ icon: 'error', title: '網路錯誤', text: err.message || '未知錯誤' });
    }

}


async function validate_page1() {
    let isValid = true;
    page1_danger_message.value = { ...page1_default_message.value };

    if (!page1.value.name) {
        page1_danger_message.value.name = '產品名稱 為必填欄位';
        isValid = false;
    }
    if (!page1.value.product_code) {
        page1_danger_message.value.product_code = '產品代碼 為必填欄位';
        isValid = false;
    }
    if (!page1.value.price) {
        page1_danger_message.value.price = '產品售價 為必填欄位';
        isValid = false;
    }
    if (!page1.value.sort_order && page1.value.sort_order !== 0) {
        page1_danger_message.value.sort_order = '排列順序 為必填欄位';
        isValid = false;
    }

    for (let i = 0; i < categories.value.length; i++) {

        for (let j = i + 1; j < categories.value.length; j++) {
            if (categories.value[i] === categories.value[j]) {
                page1_danger_message.value.categories = '產品類別 不能有重複值';
                isValid = false;
            }
        }
    }
    

    if (!isValid) {
        header_danger_message.value.page1 = '基本參數 (有欄位未填寫正確)';
    } else {
        header_danger_message.value.page1 = header_default_message.value.page1;
    }

    return isValid;
}
async function validate_page2() {
    let isValid = true;
   
    if (images.value.filter(img => img !== '').length === 0) {
        isValid = false;
    }

    if (!isValid) {
        header_danger_message.value.page2 = '未上傳圖片';
    } else {
        header_danger_message.value.page2 = header_default_message.value.page2;
    }
    
    return isValid;
}

async function removeSet(first,second){
    
    sets.value = sets.value.filter(item => !(item.first == first && item.second == second));
    set_material.value = set_material.value.filter(item => !(item.first == first && item.second == second));
} 
    

function uploadSuccess(returnData){
    images.value[returnData.id] = returnData.imgSrc;
}

function getLocalSetMaterialIndex(globalIdx) {
    if (globalIdx == null) return null;
    const list = set_material.value;
    if (!list || !list[globalIdx]) return null;
    const item = list[globalIdx];
    let local = 0;
    for (let i = 0; i < globalIdx; i++) {
        if (list[i].first === item.first && list[i].second === item.second) local++;
    }
    return local;
}
</script>