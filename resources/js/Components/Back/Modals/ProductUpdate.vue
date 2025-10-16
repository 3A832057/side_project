

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
                <input id="name" type="text" name="name" autocomplete="given-name"  v-model="page1.name"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="product_code" class="block text-sm/6 font-semi text-zinc-900">產品代碼 *</label>
                <input id="product_code" type="text" name="product_code" autocomplete="given-code"  v-model="page1.product_code"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="price" class="block text-sm/6 font-semi text-zinc-900">售價</label>
                <input id="price" type="number" name="price" autocomplete="given-price"  v-model="page1.price"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            <div class="mb-2">
                <label for="sort_order" class="block text-sm/6 font-semi text-zinc-900">排列順序 *</label>
                <input id="sort_order" type="number" name="sort_order" autocomplete="given-sort_order"  v-model="page1.sort_order"
                        class="w-full rounded-sm border border-gray-300 h-8">
            </div>
            
        </div>

        <div class="col-span-3 w-full pl-2" v-if="page==1">
            <div class="mb-2" v-for="(catego, idx) in categories" :key="idx">
                <label for="password" class="block text-sm/6 font-semi text-zinc-900">產品類別</label>
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
        <div class="col-span-6 grid grid-cols-6 w-full pl-2" v-if="page==3">
            <div class = "col-span-2">
                <div class="flex items center">
                    <input class="rounded-sm border border-gray-300 w-2/3 h-8 mb-4 " placeholder='分類依據 ex:顏色' v-model="group_name[0]" type="text"></input>
                    <button v-if="group_number==1" class="bg-gray-600 h-8 w-1/3 text-white rounded-md px-7 py-1 mr-1 " @click="group_number++" type="text">新增子類別</button>
                </div>
                <button class="bg-blue-600 text-white rounded-md px-7 py-1 mr-1" @click="sets.push({first:set_number_level1,second:null,data:null});set_number_level1 ++ ; set_number_level2.push(0);console.log('sets:',sets)">+新增群組</button>
                <div v-for="set in sets" >
                    <div class="w-full" v-if="set.second == null">
                        <div class="block text-sm/6 font-semi text-zinc-900">{{ set.first+1 }}</div>
                        <label v-if="group_number==1" for ="SetName{{ set.first }}"> 組合顯示名稱/組合售價</label>
                        <label v-if="group_number==2" for ="SetName{{ set.first }}"> 組合顯示名稱</label>

                        <input id="SetName{{ set.first }}" class="w-2/3 rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <input v-if="group_number == 1" class="w-1/3 rounded-sm border border-gray-300 h-8" v-model="set.price" type="number"></input>
                        <button :class="now_address[0] == set.first ? 'bg-gray-300':'bg-gray-500'" class="text-white rounded-md px-7 py-1 mr-1" @click="now_address[0] = set.first ; now_address[1]=null; ">選定 </button>
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
                        <label for ="SetName{{ set.first }}{{ set.second }}"> 組合顯示名稱/組合售價</label>
                        <input id="SetName{{ set.first }}{{ set.second }}" class="w-2/3 rounded-sm border border-gray-300 h-8" v-model="set.data" type="text"></input>
                        <input v-if="group_number == 2" class="w-1/3 rounded-sm border border-gray-300 h-8" v-model="set.price" type="number"></input>
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
                        <VueSelect
                            :model-value="materials_list.find(o => o.id == set.data) || null"
                            :options="materials_list"
                            label="display"
                            @update:modelValue="val => set.data = val ? val.id : null"
                        ></VueSelect>
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
let images = ref(['','','','','','','','','','','','']);
let set_material= ref([])

let group_number = ref(1); 
const emit = defineEmits(['close'])

onMounted(async () => {
    await getCategoriesList();
    await getMaterialList();
    await findProduct();

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
                       if(item.id == mat.set_id)
                           set_material.value.push({
                               first: item.first ,
                               second: item.second, 
                               data: mat.material_id,
                           });
                    });
                });
                console.log("set_material_list:", materials_list.value);
            });
        }
                console.log("sets:", sets.value);

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

    if (group_number.value == 2){
        set_material.value = set_material.value.filter(item => item.second != null);
    }
    let returnData = 
        await axios.put('/api/back/product/edit/' + props.data.id,  
            {
                product: {
                    name: page1.value.name,
                    product_code: page1.value.product_code,
                    price: page1.value.price,
                    sort_order: page1.value.sort_order,
                    description: description.value,
                },
                categories: categories.value,
                images: images.value,
                set:{
                    group_number: group_number.value,
                    group_name: group_name.value,
                    sets: sets.value,
                    set_material: set_material.value,
                }

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
    images.value[returnData.id] = returnData.imgSrc;
}
</script>