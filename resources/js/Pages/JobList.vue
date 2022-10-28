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
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div v-if="message">
            <p>
              {{message}}
            </p>
          </div>
          <div v-if="files.length == 0">
            <p>There are no jobs in the system.</p>
          </div>
          <div v-else>
            <h2>Choose a job to fulfill.</h2>
            <div v-for="file in files" :key="file.id">
              <Link :href="'/fulfillment/' + file.id">
                {{file.name}}
              </Link>
<!--              Delete link-->
              <Link :href="'/delete-job/' + file.id">
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
  },
  props: {
    files: Array,
    message: String
  }
}
</script>