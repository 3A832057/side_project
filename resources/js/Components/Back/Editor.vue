<template>
  <div class="bg-white p-6 rounded-lg shadow border">

    <QuillEditor
      v-model:content="editorContent"
      contentType="html"
      theme="snow"
      :options="{ modules }"
      class="h-[400px] bg-white"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Quill from 'quill'

if (typeof window !== 'undefined' && !window.Quill) {
  window.Quill = Quill
}

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const props = defineProps({
  content: {
    type: String,
    default: '<p>請輸入內容...</p>'
  }
})
const emit = defineEmits(['update:content'])

const editorContent = ref(props.content)


// 如果傳進來的內容動了，就更新本地內容
watch(() => props.content, (v) => {
  if (v !== editorContent.value) editorContent.value = v
})

//如果本地內容動了，就更新傳出去
watch(editorContent, (v) => {
  emit('update:content', v)
})

const modules = {
  toolbar: {
    container: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline', 'strike'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      ['link', 'image'],
      ['clean']
    ],
      handlers: {
      image: function () {
        const input = document.createElement('input')
        input.type = 'file'
        input.accept = 'image/*'
        input.onchange = () => {
          const file = input.files[0]
          const reader = new FileReader()

          reader.onload = (e) => {
            const base64 = e.target.result
            // debug: 檢查是否為 data URI

            const range = this.quill.getSelection()
            this.quill.insertEmbed(range.index, 'image', base64)

            // 檢查已插入的 <img> 是否為 base64
            try {
              const imgs = this.quill.root.querySelectorAll('img')
              const last = imgs[imgs.length - 1]
              console.log('inserted img src startsWith data:image/?', last ? last.src.startsWith('data:image/') : 'no-img')
            } catch (err) {
              console.log('unable to verify inserted image src', err)
            }
          }

          reader.readAsDataURL(file)
        }
        input.click()
      }

    }
  }
}


</script>

<style scoped>
:deep(.ql-toolbar) {
  border-radius: 0.375rem 0.375rem 0 0;
}
:deep(.ql-container) {
  border-radius: 0 0 0.375rem 0.375rem;
}
</style>
