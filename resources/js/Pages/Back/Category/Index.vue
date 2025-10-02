
<template>
    <Head title="UserTable" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            產品類別資料表
            </h2>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >

                    <Filter  :selectField="selectField" @search="search" />


                    <button class = "rounded px-3 py-2 mt-2 text-white bg-indigo-500" @click="set_sort_order()">確定排序</button>
                    <div class="relative">
                        <div ref="tableElement" class="tabulator striped"></div>
                        <button v-if="!editMode" class="w-full bg-blue-500 text-white px-4 py-2 rounded" @click="addRow(1)">
                            新增父類別
                        </button>
                        <button v-if="startInsertTable" class="w-1/2 bg-blue-500 text-white px-4 py-2 rounded" @click="insertRow">
                            儲存
                        </button>
                        <button v-if="startInsertTable" class = "w-1/2 rounded px-3 py-2 mt-2 text-white bg-gray-300 " @click="cancellAdd(1)">
                            取消
                        </button>
                    </div>
                    <div class="relative mt-8">
                        <div ref="tableElementChild" class="tabulator striped"></div>
                        <button v-if="!editMode" class="w-full bg-blue-500 text-white px-4 py-2 rounded" @click="addRow(2)">
                            新增子類別
                        </button>
                        <button v-if="startInsertTableChild" class="w-1/2 bg-blue-500 text-white px-4 py-2 rounded" @click="insertRow">
                            儲存
                        </button>
                        <button v-if="startInsertTableChild" class = "w-1/2 rounded px-3 py-2 mt-2 text-white bg-gray-300 " @click="cancellAdd(2)">
                            取消
                        </button>
                    </div>
                    <div class="relative mt-8">
                        <div ref="tableElementGrandChild" class="tabulator striped"></div>
                        <button v-if="!editMode" class="w-full bg-blue-500 text-white px-4 py-2 rounded" @click="addRow(3)">
                            新增孫類別
                        </button>
                        <button v-if="startInsertTableGrandChild" class="w-1/2 bg-blue-500 text-white px-4 py-2 rounded" @click="insertRow">
                            儲存
                        </button>
                        <button v-if="startInsertTableGrandChild" class = "w-1/2 rounded px-3 py-2 mt-2 text-white bg-gray-300 " @click="cancellAdd(3)">
                            取消
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <UserAdd v-if="showAdd" @close="closeModal" />

</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import UserAdd from '@/Components/Back/Modals/UserAdd.vue';
import { Head } from '@inertiajs/vue3';
import {TabulatorFull as Tabulator} from 'tabulator-tables';
import Swal from 'sweetalert2';
import 'tabulator-tables/dist/css/tabulator_semanticui.min.css';
import { onMounted, ref , nextTick } from 'vue';
import Filter from '@/Components/Back/Filter.vue';  
import 'https://oss.sheetjs.com/sheetjs/xlsx.full.min.js'
import axios from 'axios';



let table = null;
let tableChild = null;
let tableGrandChild = null; 
const tableElement = ref(null);
const tableElementChild = ref(null);
const tableElementGrandChild = ref(null);
let startInsertTable = ref(false);
let startInsertTableChild = ref(null);
let startInsertTableGrandChild = ref(null);
let allCategoryList = ref([]);
let selectField = ref([
    {value: 'name', text: '名稱', type: 'text'},
    {value: 'description', text: '描述', type: 'text'},
    {value: 'created_at', text: '建立時間' , type: 'date'},
    {value: 'updated_at', text: '更新時間' , type: 'date'},
    {value: 'is_enabled', text: '狀態' , type: 'select', options: [{value:1 ,text:'啟用'}, {value:0 ,text:'停用'}]},
    {value: 'parent_id', text: '父類別名稱', type: 'select', options: allCategoryList.value.map(item => ({ value: item.id, text: item.name }))},
]);
let editMode = ref(false);
const showAdd = ref(false);



onMounted(async () => {
    
    await nextTick()
    await getAllCategoryList();

    // ==================================主表格=========================================
    table = new Tabulator(tableElement.value,{
        layout:"fitData",
        ajaxURL: '/api/back/category/datatable/1',
        ajaxResponse: function(url, params, response){
            return response.data;
        },

        movableRows: true,
        rowHandle: true,
        deselectRow:true,
        rowHeader:{formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false, resizable: false, frozen:true, headerHozAlign:"center", hozAlign:"center"},
        initialSort:[
            {column:"sort_order", dir:"asc"},
        ],
        columns:[
            {
                title:"名稱", field:"name", width:200, responsive:0 , edit:true, editor:"input" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:20,
                    }
                }
            },
            {
                title: "狀態",
                field: "is_enabled",
                formatter: "tickCross",
                // editor: true,
                cellClick: function(e, cell) {

                    let currentValue = cell.getValue();
                    let rowData = cell.getRow().getData();
                    let new_is_enabled;
                    if(currentValue == 0)  new_is_enabled = 1;
                    else if(currentValue == 1) new_is_enabled = 0;

                    let tableData = table.getData();

                    if(rowData.id == undefined){
                        tableData[tableData.length - 1].is_enabled = new_is_enabled;
                        table.setData(tableData);
                    }
                    else
                        updateEnabled(rowData.id , new_is_enabled);

                }
            },
            {
                title:"類別描述", field:"description", width:300, editor:"textarea" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:100,
                    },
            
                }
            },
            { title: '前台顯示順序', field: 'sort_order' },
            { title: '建立時間', field: 'created_at' },
            { title: '更新時間', field: 'updated_at' },
            
        ],
        
    });
    table.on("rowSelectionChanged", function(e,row){

        let childFilter = [];
        for (let i = 0; i < table.getSelectedData().length; i++) {
            console.log("主類別點擊:", table.getSelectedData()[i].id);
            childFilter.push(table.getSelectedData()[i].id);
        }
        
        tableChild.setData("/api/back/category/childDatatable", {parent:childFilter});
    });

    table.on("cellEdited", function(cell){
        
        const newValue = cell.getValue();
        const rowData = cell.getRow().getData();
        console.log("編輯欄位:", cell.getField(), "新值:", newValue, "舊值:", rowData.name);
        
        switch(cell.getField()){
            case 'name':
                updateName(rowData.id , newValue);
                break;
            case 'description':
                updateDescription(rowData.id , newValue);
                break;
        }
    });

    // ==================================子類別表格=========================================
    tableChild = new Tabulator(tableElementChild.value,{
        movableRows: true,

        rowHandle: true,
        deselectRow:true,
        rowHeader:{formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false, resizable: false, frozen:true, headerHozAlign:"center", hozAlign:"center"},
        layout:"fitData",
        ajaxResponse: function(url, params, response){
            return response.data;
        },
        rowHandle: true,
        initialSort:[
            {column:"sort_order", dir:"asc"},
        ],
        columns:[
            {
                title:"名稱", field:"name", width:200, responsive:0 , edit:true, editor:"input" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:20,
                    }
                }
            },
            {title:"父類別名稱",field:"parent_id", width:200, responsive:0 , editor: "list",
            
                 editorParams: function(cell) {
                    
                    return {
                            valuesURL: '/api/back/category/parentList/1',
                            clearable: false,
                            multiselect: false,
                            autocomplete: false,
                            placeholderEmpty: "無可選擇的角色",
                            listOnEmpty: true,
                            defaultValue: cell.getValue(),
                        };
                },
                formatter: function(cell, formatterParams, onRendered) {

                    let rowData = cell.getRow().getData();
                    let parent = allCategoryList.find(item => item.id == rowData.parent_id); 
                    if (!parent) return '';
                    let parent_name = parent.name
                    return parent_name ;  // 顯示對應的名稱
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
            {
                title:"類別描述", field:"description", width:300, editor:"textarea" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:100,
                    },
            
                }
            },
            { title: '前台顯示順序', field: 'sort_order'},
            { title: '建立時間', field: 'created_at' },
            { title: '更新時間', field: 'updated_at' },
        ],
        
    });
    tableChild.on("rowSelectionChanged", function(e,row){
        let childFilter = [];
        for (let i = 0; i < tableChild.getSelectedData().length; i++) {
            childFilter.push(tableChild.getSelectedData()[i].id);
        }
        
        tableGrandChild.setData("/api/back/category/childDatatable", {parent:childFilter});
    });

    tableChild.on("cellEdited", function(cell){
        
        const newValue = cell.getValue();
        const rowData = cell.getRow().getData();
        
        switch(cell.getField()){
            case 'name':
                updateName(rowData.id , newValue);
                break;
            case 'description':
                updateDescription(rowData.id , newValue);
                break;
            case 'parent_id':
                updateParent(rowData.id , newValue);
                break;
        }
        
    });
    // ==================================孫類別表格=========================================

    tableGrandChild = new Tabulator(tableElementGrandChild.value,{
        layout:"fitData",
        ajaxResponse: function(url, params, response){
            return response.data;
        },
        movableRows: true,
        rowHandle: true,
        deselectRow:true,
        rowHeader:{formatter:"rowSelection", titleFormatter:"rowSelection", headerSort:false, resizable: false, frozen:true, headerHozAlign:"center", hozAlign:"center"},
        initialSort:[
            {column:"sort_order", dir:"asc"},
        ],
        columns:[
            {
                title:"名稱", field:"name", width:200, responsive:0 , edit:true, editor:"input" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:20,
                    }
                }
            },
            {title:"子類別名稱",field:"parent_id", width:200, responsive:0 , editor: "list",
            
                 editorParams: function(cell) {
                    
                    return {
                            valuesURL: '/api/back/category/parentList/2',
                            clearable: false,
                            multiselect: false,
                            autocomplete: false,
                            placeholderEmpty: "無可選擇的角色",
                            defaultValue: cell.getValue(),
                            listOnEmpty: true
                        };
                },
                formatter: function(cell, formatterParams, onRendered) {

                    let rowData = cell.getRow().getData();
                    let parent = allCategoryList.find(item => item.id == rowData.parent_id); 
                    if (!parent) return '';
                    let parent_name = parent.name
                    return parent_name ;  // 顯示對應的名稱
                },
            },
            {title:"主類別名稱",field:"parent.parent.name", width:200, responsive:0}, 
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
            {
                title:"類別描述", field:"description", width:300, editor:"textarea" ,
                editorParams:{
                    elementAttributes:{
                        maxlength:100,
                    },
            
                }
            },
            { title: '前台顯示順序', field: 'sort_order', headerSortStartingDir:"desc" },
            { title: '建立時間', field: 'created_at' },
            { title: '更新時間', field: 'updated_at' },
        ],
        
    });

    tableGrandChild.on("cellEdited", function(cell){
        
        const newValue = cell.getValue();
        const rowData = cell.getRow().getData();
        
        if (rowData.id == undefined) {
            return;
        }

        switch(cell.getField()){
            case 'name':
                updateName(rowData.id , newValue);
                break;
            case 'description':
                updateDescription(rowData.id , newValue);
                break;
            case 'parent_id':
                updateParent(rowData.id , newValue);
                break;
        }
    });
})

function closeModal() {
    showAdd.value = false;
    refresh(); 

}

function search(filter) {
    table.setData("/api/back/category/datatable/1");
    tableChild.setData("/api/back/category/datatable/2");
    tableGrandChild.setData("/api/back/category/datatable/3");

    table.setFilter(filter);
    tableChild.setFilter(filter);
    tableGrandChild.setFilter(filter);
}

async function updateName(id , new_name){
    let returnData = 
        await axios.put('/api/back/category/' + id, 
            {
                name: new_name,
            }
        )

    if (returnData.data.success) {
        await getAllCategoryList();
        
        await Swal.fire({
            icon: 'success',
            title: '修改成功',
            showConfirmButton: false,
            timer: 1500
        }).then(()=>{
            refresh(); 
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

async function updateDescription(id , new_description){
    let returnData = 
        await axios.put('/api/back/category/' + id, 
            {
                description: new_description,
            }
        )

    if (returnData.data.success) {
        
        await Swal.fire({
            icon: 'success',
            title: '修改成功',
            showConfirmButton: false,
            timer: 1500
        }).then(()=>{
            refresh(); 
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

async function updateParent(id , new_parent_id){
    let returnData = 
        await axios.put('/api/back/category/' + id, 
            {
                parent_id: new_parent_id,
            }
        )

    if (returnData.data.success) {
        
        await getAllCategoryList();
        
        await Swal.fire({
            icon: 'success',
            title: '修改成功',
            showConfirmButton: false,
            timer: 1500
        }).then(()=>{
            refresh(); 
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
        await axios.put('/api/back/category/' + id, 
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
            refresh(); 
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

async function set_sort_order(){

    let sortConfirm = await Swal.fire({
        title: '確定要修改排序嗎?',
        text: "請確認是否已經完成拖曳排序",
        icon: 'warning',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonText: '取消', 
        confirmButtonText: '是的，確定修改!',
    });

    if (!sortConfirm.isConfirmed) {
        return;
    }
    
    let returnData = 
        await axios.put('/api/back/category/sortOrder',{
                tableData: table.getData(),
                tableChildData: tableChild.getData(),
                tableGrandChildData: tableGrandChild.getData(),
            })

        if (returnData.data.success) {
            await Swal.fire({
                icon: 'success',
                title: '修改成功',
                showConfirmButton: false,
                timer: 1500

            }).then(()=>{
                refresh(); 
            })
        }
        else {
            console.error(returnData.data.message)
            await Swal.fire({
                icon:'error',
                title:'修改失敗',
                text: returnData.data.message,
                // showConfirmButton: false,
                timer: 1500
            })
        }
}
async function refresh(){

    console.log(table.options.movableRows);
    let childFilter = [];
    let table_SelectedData = table.getSelectedData();
    let tableChild_SelectedData = tableChild.getSelectedData();


    await table.replaceData();

    for (let i = 0; i <table_SelectedData.length; i++) {
        childFilter.push(table_SelectedData[i].id);
        table.selectRow(table_SelectedData[i].id);

    }
        
    await tableChild.setData("/api/back/category/childDatatable", {parent:childFilter});


    childFilter = [];
    for (let i = 0; i < tableChild_SelectedData.length; i++) {
        childFilter.push(tableChild_SelectedData[i].id);
        tableChild.selectRow(tableChild_SelectedData[i].id);

    }
    
    await tableGrandChild.setData("/api/back/category/childDatatable", {parent:childFilter});
    
}

function cancellAdd(level){

    switch (level) {
        case 1:
            startInsertTable.value = false;
            editMode.value = false;
            break;
    
        case 2:
            startInsertTableChild.value = false;
            editMode.value = false;
            break;
        case 3:
            startInsertTableGrandChild.value = false;
            editMode.value = false;
            break;
        default:
            break;
    }
    refresh();
}
function addRow(level){

    let sort_order = null;
    
    switch (level) {
        case 1:
            sort_order = table.getDataCount() + 1;
            table.addRow({name:"", description:"", is_enabled:1 ,sort_order:sort_order}, false);
            startInsertTable.value = true;
            editMode.value = true;
            break;
        case 2:
            sort_order = tableChild.getDataCount() + 1;
            tableChild.addRow({name:"", description:"", is_enabled:1 ,sort_order:sort_order}, false);
            startInsertTableChild.value = true;
            editMode.value = true;
            break;
        case 3:
            sort_order = tableGrandChild.getDataCount() + 1;
            tableGrandChild.addRow({name:"", description:"", is_enabled:1 ,sort_order:sort_order}, false);
            startInsertTableGrandChild.value = true;
            editMode.value = true;
            break;
        
    }

}
async function getAllCategoryList(){
    
    let categoryList = await axios.get('/api/back/category')

    console.log("所有類別:", categoryList.data);
    allCategoryList = categoryList.data.data;


    selectField.value[5].options = allCategoryList.map(item => ({ value: item.id, text: item.name }));
    console.log("所有類別selectField:", selectField.value[5].options);
}
async function insertRow(){

    let insertConfirm = await Swal.fire({
        title: '確定要新增嗎?',
        text: "請確認是否已經填寫完畢",
        icon: 'warning',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonText: '取消', 
        confirmButtonText: '是的，確定新增!',
    });

    if (!insertConfirm.isConfirmed) {
        return;
    }

    let returnData = null;
    let newRowData = null;
    if (startInsertTable.value) {
        
        let tableData = table.getData();
        newRowData = tableData[tableData.length - 1];
        newRowData['level'] = 1;
    }
    else if (startInsertTableChild.value) {
        
        let tableChildData = tableChild.getData();
        newRowData = tableChildData[tableChildData.length - 1];
        newRowData['level'] = 2;
    }
    else if (startInsertTableGrandChild.value) {
        
        let tableGrandChildData = tableGrandChild.getData();
        newRowData = tableGrandChildData[tableGrandChildData.length - 1];
        newRowData['level'] = 3;
    }

    returnData = 
        await axios.post('/api/back/category', 
            {
                name: newRowData.name,
                description: newRowData.description,
                is_enabled: newRowData.is_enabled,
                sort_order: newRowData.sort_order,
                parent_id: newRowData.parent_id || null,
                level: newRowData.level,
            }
        )
    if (returnData.data.success) {
        await getAllCategoryList();
        refresh();
    }
}
</script>
