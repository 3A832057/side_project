<template>
    <ckeditor
        v-model="data"
        :editor="ClassicEditor"
        :config="config"
    />
</template>

<script setup>
import { ref, computed } from 'vue';
import { ClassicEditor, Essentials, Paragraph, Bold, Italic } from 'ckeditor5';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';

import 'ckeditor5/ckeditor5.css';

const data = ref( '<p>Hello world!</p>' );

const config = computed( () => {
    return {
        licenseKey: '<YOUR_LICENSE_KEY>', // Or 'GPL'.
        plugins: [ Essentials, Paragraph, Bold, Italic, FormatPainter ],
        toolbar: [ 'undo', 'redo', '|', 'bold', 'italic', '|', 'formatPainter' ]
    };
} );
</script>
