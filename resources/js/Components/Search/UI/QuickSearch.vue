<template>
    <transition
        enter-active-class="duration-300 ease-out"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-200 ease-in"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
        @enter="$root.$emit('background-entered')"
    >
        <div v-if="showBox"
             class="transition-all transform js-search-modal z-max fixed inset-0 w-full h-full bg-black bg-opacity-80 flex justify-center items-center px-4"
             @click.self="hide()">
            <transition
                enter-active-class="duration-400 ease-out"
                enter-class="scale-75 opacity-0"
                enter-to-class="scale-1 opacity-1"
                leave-active-class="duration-200 ease-in"
                leave-class="scale-1 opacity-1"
                leave-to-class="scale-75 opacity-0"
            >
                <div class="transition-all transform w-full max-w-modal-small max-h-full bg-white rounded-lg" v-if="hasBackground">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between p-2">
                            <div>
                                <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
                            </div>
                            <div class="flex-1">
                                <input v-model="searchText" ref="searchText" type="search"
                                       class="w-full border-0 text-lg pl-2 ring-0 outline-none"
                                       maxlength="50" max="50" placeholder="What are you looking for?"
                                       @keyup.enter="search()"/>
                            </div>
                            <div>
                                <a class="bg-yellow hover:bg-blue-light leading-none px-3 py-1 rounded shadow transition-all"
                                   @click="search()">
                                    Search
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
import GoogleEvents from "@/Mixins/GoogleEvents";

export default {
    mixins: [GoogleEvents],

    data: () => ({
        showBox: false,
        hasBackground: false,
        searchText: '',
    }),

    mounted() {
        this.$root.$on('show-quick-search', () => {
            this.googleEvent('event', 'search', {
                event_label: 'opened',
            });

            this.show();
        });

        this.$root.$on('background-entered', () => this.hasBackground = true)
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
            this.hasBackground = false;
            document.querySelector('body').classList.remove('overflow-hidden');
        }
    },
}
</script>
