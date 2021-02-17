<template>
    <div class="flex flex-col">
        <div
            class="flex justify-between items-center p-2 text-2xl bg-blue-gradient-30 border-b-4 border-yellow rounded-t-lg leading-none">
            <h1 class="font-semibold font-coeliac pt-2">Coeliac Sanctuary {{ title }}</h1>
            <a class="pt-1 text-social-rss" :href="feedUrl" target="_blank"
                  v-tooltip.left="{content: 'RSS Feed', classes: ['bg-social-rss', 'text-white', 'rounded-lg', 'text-sm']}">
                <font-awesome-icon :icon="['fas', 'rss-square']"></font-awesome-icon>
            </a>
        </div>

        <div class="w-full flex my-2 flex-col sm:flex-row">
            <div class="w-full flex items-center mb-1 sm:w-1/2 sm:mr-2 sm:mb-0 lg:w-1/3" v-if="showFilterBar">
                <input type="search" placeholder="Search..." v-model="searchText"
                       class="text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded"/>
            </div>

            <div class="flex justify-between items-center flex-1">
                <div class="w-auto hidden md:block">
                    <div class="flex">
                        <div class="text-sm leading-none flex rounded-l-lg"
                             :class="layout === 'tiles' ? 'bg-blue text-grey-lightest': 'bg-white text-grey border border-blue cursor-pointer'"
                             @click="changeLayout('tiles')">
                            <span class="p-2 border-r"
                                  :class="layout === 'tiles' ? 'border-grey-lightest' : 'border-blue'">Grid View</span>
                            <span class="p-2"><font-awesome-icon :icon="['fas', 'th']"></font-awesome-icon></span>
                        </div>

                        <div class="flex text-sm leading-none rounded-r-lg"
                             :class="layout === 'list' ? 'bg-blue text-grey-lightest': 'bg-white text-grey border border-blue cursor-pointer'"
                             @click="changeLayout('list')">
                            <span class="p-2 border-r"
                                  :class="layout === 'list' ? 'border-grey-lightest' : 'border-blue'">List View</span>
                            <span class="p-2"><font-awesome-icon :icon="['fas', 'th-list']"></font-awesome-icon></span>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:text-right md:w-auto md:p-2">
                    <button v-if="showFilterBar" class="w-full inline-block leading-none p-2 bg-blue rounded sm:w-auto" @click.prevent="toggleFilter()">
                        Filter {{ title }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
        data: () => ({
            layout: 'tiles',
            searchText: '',
            searchTimeout: null,
        }),

        props: {
            title: {
                required: true,
                type: String,
            },
            currentLayout: {
                type: String,
                default: 'tiles',
                validator: (value) => {
                    return ['tiles', 'list'].indexOf(value) !== -1;
                }
            },
            currentSearch: {
                type: String,
                default: '',
            },
            urlPrefix: {
                required: true,
                type: String,
            },
            showFilterBar: {
                type: Boolean,
                default: () => false,
            }
        },

        mounted() {
            this.layout = this.currentLayout;

            this.searchText = this.currentSearch;

            this.$root.$on('reset-search', () => {
                this.searchText = '';
            });
        },

        methods: {
            changeLayout(layout) {
                this.layout = layout;
                this.$root.$emit('layout-change', layout);
            },

            toggleFilter() {
                this.$root.$emit('toggle-filter-bar');
            }
        },

        watch: {
            searchText: function (value) {
                clearTimeout(this.searchTimeout);

                this.searchTimeout = setTimeout(() => {
                    this.$root.$emit('module-search', value);
                }, 500);
            },
            currentSearch: function (value) {
                this.searchText = value;
            }
        },

        computed: {
            feedUrl() {
                return `/${this.urlPrefix}/feed`
            }
        }
    }
</script>
