<template>
  <Ckeditor
    :editor="ClassicEditor"
    :config="mergedConfig"
    :model-value="modelValue"
    @update:model-value="updateValue"
    @ready="onReady"
  />
</template>

<script setup>
import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import { computed } from 'vue'

const props = defineProps({
  modelValue: String,
  config: Object
})
const emit = defineEmits(['update:modelValue'])

const mergedConfig = computed(() => ({
  ...props.config,
  licenseKey: 'GPL' 
}))

const updateValue = (data) => emit('update:modelValue', data)

const onReady = (editor) => {
  console.log('✅ CKEditor ready (license=GPL)')
}
</script>
