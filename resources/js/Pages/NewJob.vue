<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        New Job
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div>
            <p v-if="result">{{result}}</p>
          </div>
          <form @submit.prevent="submit" >
            <label for="csv">Upload CSV</label>
            <input type="file" name="csv" id="csv" @input="form.csv = $event.target.files[0]">
            <button type="submit">Upload</button>
          </form>
          <div v-if="success">
            <Link href="/dashboard">Return to Dashboard</Link>
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
    const form = useForm({
      csv: null,
    })

    function submit() {
      form.post('/new-job');
    }

    return {
      form,
      submit
    }
  },
  props: {
    result: String,
    file: String,
    success: Boolean,
  }
}
</script>