<template>
    <div class="my-2 p-2 bg-blue-light bg-opacity-40 rounded font-semibold justify-center items-center">
        <p class="mb-2 text-md">
            Looking for somewhere specific? Search by postcode or town below to get places to eat near you!
        </p>

        <div class="flex flex-col space-y-2 xs:flex-row xs:space-x-2 xs:space-y-0">
            <input type="search" placeholder="Search..."
                   class="text-sm p-2 flex-1 bg-grey-lightest border border-grey-off rounded h-10 xs:flex-1"
                   v-model="searchText"
                   @keyup.enter="search()"/>

            <div class="mt-2 flex w-full xs:w-auto xs:space-x-2 xs:mt-0">
                <select
                    class="flex-1 text-sm p-2 flex-1 bg-grey-lightest border border-grey-off rounded h-10"
                    v-model="range" @keyup.enter="search()">
                    <option value="1">within 1 Mile</option>
                    <option value="2">within 2 Miles</option>
                    <option value="5">within 5 Miles</option>
                    <option value="10">within 10 Miles</option>
                    <option value="20">within 20 Miles</option>
                </select>

                <button class="bg-blue text-grey-lightest px-2 rounded-r leading-none h-10 xs:rounded"
                        @click="search()">
                    <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from "~/Global/UI/Loader";

export default {
    components: {
        'loader': Loader
    },

    props: {
        currentTerm: {
            required: false,
            default: null,
        },

        currentRange: {
            required: false,
            default: null,
        }
    },

    data: () => ({
        searchText: '',
        range: '2',
        loading: false,
    }),

    mounted() {
        if (this.currentTerm) {
            this.searchText = this.currentTerm;
        }

        if (this.currentRange) {
            this.range = this.currentRange;
        }
    },

    methods: {
        search() {
            this.loading = true;
            coeliac().request().post('/api/wheretoeat/search', {
                text: this.searchText,
                range: this.range,
            }).then((response) => {
                if (response.status === 200) {
                    const term = response.data.search;

                    window.location.href = `/wheretoeat/search/${term}`;
                    return;
                }

                this.loading = false;
                coeliac().error('There was an error running your search...')
            }).catch(() => {
                this.loading = false;
                coeliac().error('There was an error running your search...')
            });
        }
    }
}
</script>
