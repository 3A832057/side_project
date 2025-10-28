
<template>
    <Head title="materialTable" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            材料資料表
            </h2>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >

                    <Filter  :selectField="selectField" @search="search" />

                    <button @click="showAdd = true" class="mt-4 mb-4 me-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        
                        <svg class='w-5 h-5 inline align-middle mb-1' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#ffffff" d="M136 192C136 125.7 189.7 72 256 72C322.3 72 376 125.7 376 192C376 258.3 322.3 312 256 312C189.7 312 136 258.3 136 192zM48 546.3C48 447.8 127.8 368 226.3 368L285.7 368C384.2 368 464 447.8 464 546.3C464 562.7 450.7 576 434.3 576L77.7 576C61.3 576 48 562.7 48 546.3zM544 160C557.3 160 568 170.7 568 184L568 232L616 232C629.3 232 640 242.7 640 256C640 269.3 629.3 280 616 280L568 280L568 328C568 341.3 557.3 352 544 352C530.7 352 520 341.3 520 328L520 280L472 280C458.7 280 448 269.3 448 256C448 242.7 458.7 232 472 232L520 232L520 184C520 170.7 530.7 160 544 160z"/></svg>
                        新增材料
                    </button>
                    <button @click="showQuantityUpdate = true" class="mt-4 mb-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                        
                        <svg class='w-5 h-5 inline align-middle mb-1' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#ffffff" d="M136 192C136 125.7 189.7 72 256 72C322.3 72 376 125.7 376 192C376 258.3 322.3 312 256 312C189.7 312 136 258.3 136 192zM48 546.3C48 447.8 127.8 368 226.3 368L285.7 368C384.2 368 464 447.8 464 546.3C464 562.7 450.7 576 434.3 576L77.7 576C61.3 576 48 562.7 48 546.3zM544 160C557.3 160 568 170.7 568 184L568 232L616 232C629.3 232 640 242.7 640 256C640 269.3 629.3 280 616 280L568 280L568 328C568 341.3 557.3 352 544 352C530.7 352 520 341.3 520 328L520 280L472 280C458.7 280 448 269.3 448 256C448 242.7 458.7 232 472 232L520 232L520 184C520 170.7 530.7 160 544 160z"/></svg>
                        庫存異動單
                    </button>
                    <div ref="tableElement" class="tabulator striped"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <MaterialUpdate v-if="show" :data="productData" @close="closeModal"  />
    <QuantityUpdate v-if="showQuantityUpdate"  @close="closeModal"  />
    <MaterialAdd v-if="showAdd" @close="closeModal" />

</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import MaterialAdd from '@/Components/Back/Modals/MaterialAdd.vue';
import { Head } from '@inertiajs/vue3';
import {TabulatorFull as Tabulator} from 'tabulator-tables';
import 'tabulator-tables/dist/css/tabulator_semanticui.min.css';
import { onMounted, ref , nextTick } from 'vue';
import Filter from '@/Components/Back/Filter.vue';  
import Swal from 'sweetalert2';
import MaterialUpdate from '@/Components/Back/Modals/MaterialUpdate.vue';
import QuantityUpdate from '@/Components/Back/Modals/QuantityUpdate.vue';


let selectField = ref([
    {value: 'name', text: '名稱', type: 'text'},
    {value: 'material_code', text:'材料編碼', type:'text'},
    {value: 'quantity', text:'庫存數量', type:'text'},
    {value: 'cost', text:'成本價', type:'text'},
    {value: 'low_danger', text:'庫存水位', type:'text'},
    {value: 'is_enabled', text:'材料狀態', type:'select' , options: [{value:1, text:'啟用'},{value:0, text:'停用'}]},
    {value: 'created_at', text: '建立時間' , type: 'date'},
    {value: 'updated_at', text: '更新時間' , type: 'date'},
]);
let table = null 
const tableElement = ref(null);
const show = ref(false);
const showAdd = ref(false);
const showQuantityUpdate = ref(false);

let productData = ref({
    id: null ,
});
onMounted(async () => {
    
    await nextTick()

    table = new Tabulator(tableElement.value, {
    ajaxURL: '/api/back/material/datatable',
    ajaxResponse: function(url, params, response){
        return response.data;
    },
    pagination:"local",
    renderHorizontal:"virtual",
    deselectRow:true,
    paginationSize:5,
    paginationSizeSelector:[20, 50, 100, 1000],
    rowHeader:{formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false, resizable: false, frozen:true, headerHozAlign:"center", hozAlign:"center"},
    columns:[
                { title: '材料名稱', field: 'name' },
                { title: '材料編碼', field: 'material_code' },
                { title: '庫存數量', field: 'quantity' },
                { title: '庫存水位', field: 'low_danger' },
                { title: '成本價', field: 'cost' },

                {
                    title: "狀態",
                    field: "is_enabled",
                    formatter: "tickCross",
                    cellClick: function(e, cell) {
                        let currentValue = cell.getValue();
                        let rowData = cell.getRow().getData();
                        let new_is_enabled;
                        if(currentValue == 0)  new_is_enabled = 1;
                        else if(currentValue == 1) new_is_enabled = 0;

                        updateEnabled(rowData.id , new_is_enabled);

                    }
                },
                { title: '建立時間', field: 'created_at'},
                { title: '更新時間', field: 'updated_at' ,hozAlign:"center"},
                {
                    title: "操作",
                    field: "actions",
                    hozAlign: "left",
                    formatter: function (cell) {
                        let action_input = '';
                        
                        action_input += "<button class='edit-btn bg-yellow-300  pt-1 pb-1 ps-2 pe-2  rounded-lg hover:bg-yellow-400 hover:text-white'><svg class='w-4 h-4 inline align-middle mr-1' xmlns=\"http://www.w3.org/2000/svg\" width=\"200\" height=\"200\" viewBox=\"0 0 1025 1023\"><path fill=\"currentColor\" d=\"M896.428 1023h-768q-53 0-90.5-37.5T.428 895V127q0-53 37.5-90t90.5-37h576l-128 127h-384q-27 0-45.5 19t-18.5 45v640q0 27 19 45.5t45 18.5h640q27 0 45.5-18.5t18.5-45.5V447l128-128v576q0 53-37.5 90.5t-90.5 37.5zm-576-464l144 144l-208 64zm208 96l-160-159l479-480q17-16 40.5-16t40.5 16l79 80q16 16 16.5 39.5t-16.5 40.5z\"/></svg>編輯</button>";
                        action_input += "<button class='ms-2 deleate-btn bg-red-400  pt-1 pb-1 ps-2 pe-2  rounded-lg hover:bg-red-600 hover:text-white'><svg class='w-4 h-4 inline align-middle mr-1' xmlns=\"http://www.w3.org/2000/svg\" width=\"200\" height=\"200\" viewBox=\"0 0 1025 1023\"><path fill=\"currentColor\" d=\"M64 432c22.1 0 40 17.9 40 40s-17.9 40-40 40-40-17.9-40-40c0-22.1 17.9-40 40-40zM64 0c26.5 0 48 21.5 48 48 0 .6 0 1.1 0 1.7l-16 304c-.9 17-15 30.3-32 30.3S33 370.7 32 353.7L16 49.7c0-.6 0-1.1 0-1.7 0-26.5 21.5-48 48-48z\"/></svg>刪除</button>";
                        return action_input;
                    },
                    cellClick: function (e, cell) {
                        let rowData = cell.getRow().getData();
                        if (e.target.classList.contains("edit-btn")) {
                            show.value = true;
                            productData.value.id = rowData.id;
                        }
                        if (e.target.classList.contains("deleate-btn")) {
                           deleteData(rowData.id );
                        }
                    },
                }
            ],
            
    })


}

)

function closeModal() {
    show.value = false;
    showAdd.value = false;
    showQuantityUpdate.value = false;

    if ( productData.value.id) {
        const row = table.getRow(productData.value.id);
        if (row) {
            table.replaceData();

            return;
        }
    }
    table.replaceData(); 
}

async function search(filter) {
    let returnData = await axios.get('/api/back/product/datatable', { params: filter });
    console.log(returnData);
    table.replaceData(returnData.data.data);
}

async function updateEnabled(id , new_is_enabled){
    let returnData = 
        await axios.put('/api/back/material/' + id, 
            {
                is_enabled: new_is_enabled,
            }
        )

    if (returnData.data.success) {
        
        await Swal.fire({
            icon: 'success',
            title: '修改成功',
            showConfirmButton: false,
            timer: 1500
        }).then(()=>{
            const row = table.getRow(productData.value.id);
            if (row) {
                row.update({});
            } else {
                table.replaceData();
            }
        })

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

async function deleteData(id){
    let result = await Swal.fire({
        title: '確定要刪除這筆資料嗎？',
        text: "刪除後將無法恢復！",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '是的，刪除它！',
        cancelButtonText: '取消'
    })
    if (result.isConfirmed) {
        let returnData = await await axios.put('/api/back/material/' + id, 
            {
                is_hidden: true,
            }
        );
        if (returnData.data.success) {
            await Swal.fire({
                icon: 'success',
                title: '刪除成功',
                showConfirmButton: false,
                timer: 1500
            });
            table.replaceData();
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '刪除失敗',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }
}
</script>
