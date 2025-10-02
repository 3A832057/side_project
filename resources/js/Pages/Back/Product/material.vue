
<template>
    <Head title="UserTable" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            會員資料表
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
                        新增會員
                    </button>
                    
                    <div ref="tableElement" class="tabulator striped"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <UserUpdate v-if="show" :data="updateData" @close="closeModal"  />
    <UserAdd v-if="showAdd" @close="closeModal" />

</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import UserUpdate from '@/Components/Back/Modals/UserUpdate.vue';
import UserAdd from '@/Components/Back/Modals/UserAdd.vue';
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
    {value: 'role_id', text: '角色' , type: 'select', options: [{value:1 ,text:'管理員'}, {value:2 ,text:'一般會員'}]},
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
onMounted(async () => {
    
    await nextTick()

    table = new Tabulator(tableElement.value, {
    ajaxURL: '/api/back/user/datatable',
    ajaxResponse: function(url, params, response){
        return response.data;
    },
    pagination:"local",
    renderHorizontal:"virtual",
    paginationSize:3,
    paginationSizeSelector:[3, 6, 8, 1000],
    selectableRows:true,
    movableColumns:true,
    paginationCounter:"rows",
    columns:[
                { title: 'Name', field: 'name' },
                { title: 'Email', field: 'email' },
                { title: '建立時間', field: 'created_at' },
                { title: '更新時間', field: 'updated_at' },
                {
                    title: "角色",
                    field: "role_id",
                    formatter: function(cell) {
                       const rowData = cell.getRow().getData();

                        let role_tag = "<select class='role-tag appearance-none bg-gray-400 text-slate-50 border-none w-32 pt-1 pb-1 ps-2 pe-8 rounded-lg hover:bg-gray-500 hover:text-white bg-no-repeat bg-[right_0.5rem_center] bg-[length:1rem] '>";
                            for (let role of rowData.role) {
                            role_tag += `<option value="${role.id}" ${role.id == rowData.role_id ? 'selected' : ''}>${role.name}</option>`;
                        }
                        role_tag += '</select>';
                        return role_tag;
                    },
                    editor: "list",
                    editorParams: function(cell) {
                        const roles = cell.getRow().getData().role;
                        
                        return {
                            values: roles.map(r => ({ value: r.id, label: r.name })),
                            clearable: false,
                            multiselect: false,
                            autocomplete: false,
                            placeholderEmpty: "無可選擇的角色",
                            listOnEmpty: true
                        };
                    }
                },
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
                { title: '停用時間', field: 'disabled_at' },
                {
                    title: "操作",
                    field: "actions",
                    hozAlign: "left",
                    formatter: function (cell) {
                        let action_input = '';
                        
                        action_input += "<button class='edit-btn bg-yellow-300  pt-1 pb-1 ps-2 pe-2  rounded-lg hover:bg-yellow-400 hover:text-white'><svg class='w-4 h-4 inline align-middle mr-1' xmlns=\"http://www.w3.org/2000/svg\" width=\"200\" height=\"200\" viewBox=\"0 0 1025 1023\"><path fill=\"currentColor\" d=\"M896.428 1023h-768q-53 0-90.5-37.5T.428 895V127q0-53 37.5-90t90.5-37h576l-128 127h-384q-27 0-45.5 19t-18.5 45v640q0 27 19 45.5t45 18.5h640q27 0 45.5-18.5t18.5-45.5V447l128-128v576q0 53-37.5 90.5t-90.5 37.5zm-576-464l144 144l-208 64zm208 96l-160-159l479-480q17-16 40.5-16t40.5 16l79 80q16 16 16.5 39.5t-16.5 40.5z\"/></svg>編輯</button>";
                        
                        return action_input;
                    },
                    cellClick: function (e, cell) {
                            let rowData = cell.getRow().getData();
                            if (e.target.classList.contains("edit-btn")) {
                                show.value = true;
                                updateData.value = rowData;
                                console.log("編輯:", rowData,'show:', show.value);
                        }
                    },
                }
            ],
    })

    table.on("cellEdited", function(cell){
        
        const newValue = cell.getValue();
        const rowData = cell.getRow().getData();
        
        if(cell.getField() == 'role_id')
            updateRole(rowData.id , newValue);
    });
    table.on('rowSelectionChanged', function (data, rows) {
        selectedCount.value = data.length
        selectedElements.value = data;
    })
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

async function updateRole(id , new_role_id){
    let returnData = 
        await axios.put('/api/back/user/' + id, 
            {
                role_id: new_role_id,
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
