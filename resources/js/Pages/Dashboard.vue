<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row justify-evenly">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:bg-teal-700 hover:text-white">
                <Link href="/new-job" class="text-2xl block h-full w-full p-10">New Job</Link>
              </div>
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:bg-teal-700 hover:text-white">
                <Link href="/job-list" class="text-2xl block h-full w-full p-10">Job List</Link>
              </div>
            </div>
        </div>
    </AppLayout>
</template>
