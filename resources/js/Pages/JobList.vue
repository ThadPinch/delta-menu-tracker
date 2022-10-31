<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Job List
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <div v-if="message">
            <p>
              {{message}}
            </p>
          </div>
          <div v-if="files.length == 0">
            <h2 class="text-2xl text-center">There are no jobs in the system.</h2>
          </div>
          <div v-else>
            <h2 class="text-2xl text-center">Choose a job to fulfill.</h2>
            <div 
              v-for="file in files" 
              :key="file.id" 
              class="
                m-auto
                max-w-4xl
                flex flex-row 
                justify-between 
                items-center 
                p-2 
                border-b-2 
                border-gray-300 
                hover:bg-slate-100 
                hover:text-slate-700
              ">
              <div class="flex flex-row justify-evenly align-center">
                <span class="p-2">{{file.percent_allocated}}%</span>
                <Link :href="'/fulfillment/' + file.id" 
                  class="
                    block
                    h-full
                    p-2
                    hover:text-white
                    hover:bg-slate-700
                  "
                >
                  {{file.name}}
                </Link>
              </div>
<!--              Delete link-->
              <Link 
              :href="'/delete-job/' + file.id"
              class="
                text-white
                bg-red-500
                hover:bg-red-700
                p-3
                rounded-lg
              "
              >
                Delete
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'

export default {
  data() {
    return {}
  },
  props: {
    files: Array,
    message: String
  }
}
</script>