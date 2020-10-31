<template>
    <widget>
        <template v-slot:title>
            Search Reviews
        </template>

        <template v-slot:body>
            <div class="flex">
                <input type="search" placeholder="Search..."
                       class="text-sm p-1 flex-1 bg-grey-lightest border border-grey-off"
                       v-model="searchText"
                       @keyup.enter="search()"
                       style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem" />
                <button class="bg-blue text-grey-lightest px-2"
                        style="border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem"
                        @click="search()">
                    <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
                </button>
            </div>
        </template>
    </widget>
</template>

<script>
    export default {
        data: () => ({
            searchText: '',
        }),

        methods: {
            search() {
                const searchText = btoa(`search=${this.searchText}`);
                window.location.href = `/review?o=${searchText}`;
            }
        }
    }
</script>
