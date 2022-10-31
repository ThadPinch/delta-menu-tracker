<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

Inertia.on('finish', () => {
  let urlParams = new URLSearchParams(window.location.search);
  let options = ['allocated', 'deallocated'];
  for (let option in options) {
    if (urlParams.has(options[option])) {
      let selectedID = document.getElementById(urlParams.get(options[option]));
      if (selectedID) {
        selectedID.scrollIntoView();
        // pulseClass();
        if (options[option] == 'allocated') {
          selectedID.classList.remove('allocate-pulse')
          selectedID.classList.add('allocate-pulse')
          setTimeout(() => {
            selectedID.classList.remove('allocate-pulse')
          }, 1000);
        } else {
          selectedID.classList.remove('deallocate-pulse')
          selectedID.classList.add('deallocate-pulse')
          setTimeout(() => {
            selectedID.classList.remove('deallocate-pulse')
          }, 1000);
        }
      }
    }
  }
})
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Fulfillment
      </h2>
    </template>

    <div class="py-12">
      <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="sticky bottom-0 py-3 bg-slate-100">
          <div v-if="message" class="m-auto text-center text-xl">
            <p>
              {{ message }}
            </p>
          </div>
          <div class="text-center">
            <h2 class="text-2xl">{{ jobName }}</h2>
            <p class="text-2xl">
              {{ percent }}% Complete
            </p>
          </div>
          <div class="overflow-hidden mb-4 sm:rounded-lg flex flex-row justify-evenly">
            <div>
              <form @submit.prevent="allocate">
                <input type="text" v-model="allocation" ref="allocation" name="allocation" id="allocation" class="rounded-lg mx-2 shadow-md">
                <button class="bg-emerald-500 hover:bg-emerald-700 text-white p-2 rounded-md" type="submit">Allocate</button>
              </form>
            </div>
            <div>
              <form @submit.prevent="deallocate">
                <input type="text" v-model="deallocation" ref="deallocation" name="deallocation" id="deallocation" class="rounded-lg mx-2 shadow-md">
                <button class="bg-red-500 hover:bg-red-700 text-white p-2 rounded-md" type="submit">Deallocate</button>
              </form>
            </div>
          </div>
        </div>
<!--        This is the table     -->
        <div class="flex flex-col px-8" v-if="content">
          <div class="my-2 sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div
                  class="shadow border-b border-gray-200 sm:rounded-lg overflow-scroll  max-w-7xl mx-auto max-h-custom" 
              >
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50 sticky top-0">
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
                      Bin
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
                    <tr v-for="row in content" :key="row.id" :class="(row['allocated'] == row['packs'])? 'bg-emerald-200':''" :id="row['lot_number']" class="pt-5">
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-xl">
                          {{ row['allocated'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-xl">
                          {{ row['packs'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 text-xl">
                          {{ (row['bin'] == null)? '-': row['bin'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['departure']}}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['menu_type'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['lot_number'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['title']}}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['print_quantity'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['flight_number'] }}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ row['arrival']}}
                        </div>
                      </td>
                      <td class="px-6 pt-20 pb-4 whitespace-nowrap">
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

export default {
  data() {
    return {
      allocation: "",
      deallocation: ""
    }
  },
  methods: {
    allocate() {
      // Post the allocation to the server then return to the same page
      this.$inertia.post('/allocate', {
        allocation: this.allocation,
        job: this.job
      })
      this.allocation = '';
    },
    deallocate() {
      // Post the deallocation to the server
      this.$inertia.post('/deallocate', {
        deallocation: this.deallocation,
        job: this.job
      })
      this.deallocation = '';
    this.$refs.allocation.focus()
    },
  },
  props: {
    job: String,
    jobName: String,
    content: Object,
    message: String,
    percent: String,
  },
  mounted() {
    this.$refs.allocation.focus()
  }
}
</script>