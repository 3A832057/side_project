<script setup>
import AuthenticatedLayout from '@/Layouts/Back/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout >
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-4 h-full py-3 px-3 flex grid grid-cols-5 justify-items-center items-center grid-rows-[1fr,1fr]">
            <div class="mr-1 mb-1 bg-white col-span-3 w-full shadow-xl shadow-sky-200 rounded-lg h-full"></div>
            <div class="ml-1 mb-1 bg-white col-span-2 w-full shadow-xl shadow-sky-200 rounded-lg h-full"></div>
            <div class="mr-1 mt-1 bg-white col-span-2 w-full shadow-xl shadow-sky-200 rounded-lg h-full"></div>
            <div class="ml-1 mt-1 bg-white col-span-3 w-full shadow-xl shadow-sky-200 rounded-lg h-full"></div>
        </div>
    </AuthenticatedLayout>
</template>
