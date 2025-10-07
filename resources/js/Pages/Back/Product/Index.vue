
<template>
    <Head title="ProductTable" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            產品資料表
            </h2>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >

                    <Filter  :selectField="selectField" @search="search" />

                    <button @click="showAdd = true" class="mt-4 mb-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        
                        <svg class='w-5 h-5 inline align-middle mb-1' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#ffffff" d="M136 192C136 125.7 189.7 72 256 72C322.3 72 376 125.7 376 192C376 258.3 322.3 312 256 312C189.7 312 136 258.3 136 192zM48 546.3C48 447.8 127.8 368 226.3 368L285.7 368C384.2 368 464 447.8 464 546.3C464 562.7 450.7 576 434.3 576L77.7 576C61.3 576 48 562.7 48 546.3zM544 160C557.3 160 568 170.7 568 184L568 232L616 232C629.3 232 640 242.7 640 256C640 269.3 629.3 280 616 280L568 280L568 328C568 341.3 557.3 352 544 352C530.7 352 520 341.3 520 328L520 280L472 280C458.7 280 448 269.3 448 256C448 242.7 458.7 232 472 232L520 232L520 184C520 170.7 530.7 160 544 160z"/></svg>
                        新增商品
                    </button>
                    
                    <div ref="tableElement" class="tabulator striped"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <UserUpdate v-if="show" :data="updateData" @close="closeModal"  />
    <ProductAdd v-if="showAdd" @close="closeModal" />

</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import UserUpdate from '@/Components/Back/Modals/UserUpdate.vue';
import ProductAdd from '@/Components/Back/Modals/ProductAdd.vue';
import { Head } from '@inertiajs/vue3';
import {TabulatorFull as Tabulator} from 'tabulator-tables';
import 'tabulator-tables/dist/css/tabulator_semanticui.min.css';
import { onMounted, ref , nextTick } from 'vue';
import Filter from '@/Components/Back/Filter.vue';  
import Swal from 'sweetalert2';

let selectField = ref([
    {value: 'name', text: '名稱', type: 'text'},
    {value: 'email', text: '電子郵件', type: 'text'},
    {value: 'created_at', text: '建立時間' , type: 'date'},
    {value: 'updated_at', text: '更新時間' , type: 'date'},
    {value: 'disabled_at', text: '停用時間' , type: 'date'},
    {value: 'is_hi', text: '角色' , type: 'select', options: [{value:1 ,text:'管理員'}, {value:2 ,text:'一般會員'}]},
    {value: 'is_enabled', text: '狀態' , type: 'select', options: [{value:1 ,text:'啟用'}, {value:0 ,text:'停用'}]},
]);

let table = null 
const tableElement = ref(null);
const selectedCount = ref(0);
const selectedElements = ref([]);
const show = ref(false);
const showAdd = ref(false);
let updateData = ref({
    name: '',
    email: '',
});
let selectedRowIndex = ref([]);
onMounted(async () => {
    
    await nextTick()

    table = new Tabulator(tableElement.value, {
    ajaxURL: '/api/back/product/datatable',
    ajaxResponse: function(url, params, response){
        return response.data;
    },
    responsiveLayout:"collapse",
    deselectRow:true,
    rowHeader:{formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false, resizable: false, frozen:true, headerHozAlign:"center", hozAlign:"center"},
    columns:[
                { title: '產品名稱', field: 'name' },
                { title: '產品編碼', field: 'product_code' },
                { title: '建立時間', field: 'created_at'},
                { title: '更新時間', field: 'updated_at' ,hozAlign:"center"},
                
            ],
            rowFormatter:function(row){
                var element = row.getElement(),
                data = row.getData(),
                width = element.offsetWidth,
                rowTable, cellContents;
                let rowTabletr;
                
                // while(element.firstChild) element.removeChild(element.firstChild);


                let ok = selectedElements.value.findIndex(item => item === data.id);

                if(ok == -1) return;

                rowTable = document.createElement("table")
                rowTable.style.width = (width - 18) + "px";

                rowTabletr = document.createElement("tr");

                cellContents = "<td><p>" + data.name + "</p></td>";

                cellContents += "<td><div><strong>Type:</strong> " + data.product_code + "</div></td>"

                rowTabletr.innerHTML = cellContents;

                rowTable.appendChild(rowTabletr);

                element.append(rowTable);
            },
    })

    table.on("rowClick", function(e, row){

        let id = row.getData().id;
        let ok = selectedElements.value.findIndex(item => item === id);
        if(ok == -1) {
            selectedElements.value.push(id);
            table.replaceData();
            return;
        }

        selectedElements.value.splice(ok);
        table.replaceData();
        
    });
})

function closeModal() {
    show.value = false;
    showAdd.value = false;
    table.replaceData(); 
}

function search(filter) {
    console.log("搜尋條件123:", filter);
    table.setFilter(filter);
}

async function updateEnabled(id , new_is_enabled){
    let returnData = 
        await axios.put('/api/back/user/' + id, 
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
            table.replaceData(); 
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
</script>
