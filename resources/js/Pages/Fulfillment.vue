<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Fulfillment
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div v-if="message">
          <p>
            {{ message }}
          </p>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex flex-row justify-evenly">
          <div>
            <form @submit.prevent="allocate">
              <input type="text" v-model="allocation" name="allocation" id="allocation" @change="testing">
              <button type="submit">Allocate</button>
              <p>{{allocation}}</p>
            </form>
          </div>
          <div>
            <form @submit.prevent="deallocate">
              <input type="text" :model="deallocation" name="deallocation" id="deallocation">
              <button type="submit">Deallocate</button>
            </form>
          </div>
        </div>
<!--        This is the table     -->
        <div class="flex flex-col px-8" v-if="content">
          <div class="-my-2 overflow-x-scroll sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div
                  class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
              >
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                  <tr>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Allocated
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Total Packs
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Departure
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Menu Type
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Lot Number
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Title
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Print Quantity
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Flight Number
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Arrival
                    </th>
                    <th
                        scope="col"
                        class="
                                px-6
                                py-3
                                text-left text-xs
                                font-medium
                                text-gray-500
                                uppercase
                                tracking-wider
                            "
                    >
                      Shipper
                    </th>
                  </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="row in content" :key="row.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['allocated'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['packs'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['departure']}}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['menu_type'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['lot_number'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['title']}}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['print_quantity'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['flight_number'] }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['arrival']}}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{ row['shipper']}}
                      </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
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
    return {
      allocation: "test",
      deallocation: "test"
    }
  },
  methods: {
    allocate() {
      console.log('allocating')
      console.log(this.allocation)
      // return;
      // Post the allocation to the server
      this.$inertia.post('/allocate', {
        allocation: this.allocation,
        job: this.job
      })
    },
    deallocate() {
      console.log('deallocating')
      console.log(this.deallocation)
      return;
      // Post the deallocation to the server
      this.$inertia.post('/deallocate', {
        deallocation: this.deallocation,
        job: this.job
      })
    },
    testing() {
      console.log(this.allocation)
    }
  },
  props: {
    job: Number,
    content: String,
    message: String
  },
  mounted() {
    console.log('mounted')
    console.log('content', this.content)
  }
}
</script>