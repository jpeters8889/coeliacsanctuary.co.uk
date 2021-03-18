<template>
    <div class="flex flex-col">
        <p class="mb-2">
            Looking for somewhere specific? Search by postcode or town below to get places to eat near you!
        </p>

        <input type="search" placeholder="Search..."
               class="text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded"
               v-model="searchText"
               @keyup.enter="search()"/>

        <div class="mt-2 flex w-full">
            <select
                class="flex-1 text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded rounded-l"
                v-model="range" @keyup.enter="search()">
                <option value="1">within 1 Mile</option>
                <option value="2">within 2 Miles</option>
                <option value="5">within 5 Miles</option>
                <option value="10">within 10 Miles</option>
                <option value="20">within 20 Miles</option>
            </select>

            <button class="bg-blue text-grey-lightest px-2 rounded-r" @click="search()">
                <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
            </button>
        </div>
    </div>
</template>

<script>
import Loader from "~/Global/UI/Loader";

export default {
    components: {
        'loader': Loader
    },

    data: () => ({
        searchText: '',
        range: '2',
        loading: false,
    }),

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
