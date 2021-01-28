<template>
    <div v-if="showBox"
         class="js-search-modal z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center px-4"
         @click.self="hide()">
        <div class="w-full max-w-modal-small max-h-full bg-white rounded-lg">
            <div class="flex flex-col">
                <div class="flex items-center justify-between p-2">
                    <div>
                        <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
                    </div>
                    <div class="flex-1">
                        <input v-model="searchText" ref="searchText" type="search" class="w-full border-0 text-lg pl-2"
                               maxlength="50" max="50" placeholder="What are you looking for?" @keyup.enter="search()"/>
                    </div>
                    <div>
                        <a class="bg-yellow hover:bg-blue-light leading-none px-3 py-1 rounded shadow transition-bg"
                           @click="search()">
                            Search
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GoogleEvents from "../Mixins/GoogleEvents";

export default {
    mixins: [GoogleEvents],

    data: () => ({
        showBox: false,
        searchText: '',
    }),

    mounted() {
        this.$root.$on('show-quick-search', () => {
            this.googleEvent('event', 'search', {
                event_label: 'opened',
            });

            this.show();
        });
    },

    methods: {
        search() {
            this.googleEvent('event', 'search', {
                event_label: this.searchText,
            });

            window.location.href = `/search?q=${this.searchText}`;
        },

        show() {
            document.querySelector('body').classList.add('overflow-hidden');
            this.showBox = true;

            setTimeout(() => {
                this.$refs['searchText'].focus();
            }, 100);
        },

        hide() {
            this.showBox = false;
            document.querySelector('body').classList.remove('overflow-hidden');
        }
    },
}
</script>
