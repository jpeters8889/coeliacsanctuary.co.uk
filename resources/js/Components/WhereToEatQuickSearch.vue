<template>
    <div>
        <div class="my-2 p-2 bg-blue-light-40 rounded font-semibold justify-center items-center">
            <p class="text-center">
                Want to find a location quickly? Type a town or county here to go straight to that location in
                our Eating Out guide!
            </p>

            <div class="bg-white-80 rounded-lg p-2 mt-2">
                <input type="text" class="border-0 focus:border-0 focus:outline-none p-0 m-0 w-full bg-transparent"
                       @keyup="openSearch()"
                       v-model="searchText" placeholder="Search here..."/>
            </div>
        </div>

        <div v-if="showBox"
             class="z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center px-4"
             @click.self="hide()">
            <div class="w-full max-w-modal-small max-h-full bg-white rounded-lg p-2">
                <div class="flex flex-col">
                    <input type="text"
                           class="border-0 focus:border-0 focus:outline-none pt-0 p-1 text-large border-b border-gray-off w-full"
                           ref="modalSearch"
                           v-model="searchText" placeholder="Search here..." @keyup="runSearch()"
                           @keyup.esc="hide()"/>
                </div>
                <div v-if="loading" class="relative p-4 h-115px">
                    <loader show></loader>
                </div>

                <div v-else>
                    <ul>
                        <li v-for="result in results"
                            class="border-b border-blue-light-50 last:border-b-0 hover:bg-blue-light-20 transition-bg">
                            <a class="p-2 block w-full" :href="result.url" v-text="result.label"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const Loader = () => import('./Loader' /* webpackChunkName: "prefetch-loader" */)

export default {
    components: {Loader},

    data: () => ({
        searchText: '',
        showBox: false,
        loading: true,

        results: [],

        timeout: null,
    }),

    methods: {
        openSearch() {
            this.showBox = true;

            setTimeout(() => {
                this.$refs.modalSearch.focus();
            }, 50);
        },

        runSearch() {
            if (this.searchText === '') {
                return;
            }

            clearTimeout(this.timeout);

            setTimeout(() => {
                coeliac().request().post('/api/wheretoeat/quick-search', {
                    term: this.searchText
                }).then((response) => {
                    this.results = response.data;
                    this.loading = false;
                }).catch(() => {
                    coeliac().error('Sorry, an error has occurred');
                    this.showBox = false;
                })
            }, 500);
        },

        hide() {
            this.showBox = false;
        }
    },

    watch: {
        showBox: function () {
            if (this.showBox) {
                document.querySelector('body').style.overflow = 'hidden';
                return;
            }

            document.querySelector('body').style.overflow = 'auto';

        }
    }
}
</script>
