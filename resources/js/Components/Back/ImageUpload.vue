

<template>
    <div>
        <input type="file" :id="'inputImage'+id" @change="uploadImage" style="display: none;"></input>
        <svg v-if="imgSrc == null" class=" w-full" @click="selectImage()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#fedfa9" d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160C544 124.7 515.3 96 480 96L160 96zM224 176C250.5 176 272 197.5 272 224C272 250.5 250.5 272 224 272C197.5 272 176 250.5 176 224C176 197.5 197.5 176 224 176zM368 288C376.4 288 384.1 292.4 388.5 299.5L476.5 443.5C481 450.9 481.2 460.2 477 467.8C472.8 475.4 464.7 480 456 480L184 480C175.1 480 166.8 475 162.7 467.1C158.6 459.2 159.2 449.6 164.3 442.3L220.3 362.3C224.8 355.9 232.1 352.1 240 352.1C247.9 352.1 255.2 355.9 259.7 362.3L286.1 400.1L347.5 299.6C351.9 292.5 359.6 288.1 368 288.1z"/></svg>
        <img :src="imgSrc" @click="selectImage()" alt="預覽圖片" v-if="imgSrc">
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import axios, { all } from 'axios';
import Swal from 'sweetalert2';
let imgSrc = ref('');
let id = ref(0);
let storeDir = ref('');
const props = defineProps({
    imgSrc: null,
    id:0,
    dir:''
})
let returnData = ref({
        imgSrc:'',
        id:0
    }
)
onMounted(() => {
    imgSrc.value = props.imgSrc;
    id.value = props.id ;
    storeDir.value = props.dir;
});

const emit = defineEmits(['uploadSuccess'])

async function selectImage() {
    
    let fileInputButton = document.getElementById('inputImage'+props.id)
    fileInputButton.click();
    
}

async function uploadImage(event) {

    const file = event.target.files[0]; // 取得第一個上傳的檔案
    if (!file) return;

    console.log('file:',storeDir.value);
    
    let fileData ={file:file ,storeDir:storeDir.value};
    let finalReturn = await axios.post('/api/back/uploadImg', fileData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    
    if (finalReturn.data.success){
        await Swal.fire({
            icon: 'success',
            title: finalReturn.data.message,
            showConfirmButton: false,
            timer: 1500
        })
        imgSrc.value = finalReturn.data.data;
        returnData.value.id = id.value;
        returnData.value.imgSrc = imgSrc.value;
        emit('uploadSuccess' , returnData.value)

    }
    else{
        await Swal.fire({
            icon: 'error',
            title: finalReturn.data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }

}


</script>