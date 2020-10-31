<template>
    <div id="heros" class="inner-wrapper flex flex-col shadow-xl" @mouseenter="resetTimeout" @mouseleave="createTimeout">
        <div class="flex flex-col h-full relative" v-if="heros.length > 0">
            <div class="flex-1 flex flex-col md:flex-row">
                <div class="md:w-3/5">
                    <img class="w-full" :src="heros[currentIndex].first_image"
                         :alt="heros[currentIndex].title"/>
                </div>

                <div class="bg-blue-light flex justify-center items-center pb-4 md:pb-0 md:w-2/5">
                    <div class="p-4 text-center">
                        <h2 class="font-semibold mb-4 text-lg lg:text-xl">
                            {{ heros[currentIndex].title }}
                        </h2>
                        <p class="mb-4 text-sm lg:text-base">
                            {{ heros[currentIndex].description }}
                        </p>
                        <link-button class="px-6 py-3 text-lg lg:text-xl rounded-lg"
                                     :href="heros[currentIndex].link">
                            Find out more
                        </link-button>
                    </div>
                </div>
            </div>

            <div class="absolute top-auto bottom-0 w-full">
                <!-- Navigation Circles -->
                <div class="flex justify-center mt-4 mb-2 w-full">
                    <div v-for="(item, index) in heros">
                        <div class="w-3 h-3 rounded-full mx-1 cursor-pointer"
                             :class="index === currentIndex ? 'bg-yellow' : 'bg-white border border-grey-off'"
                             @click.prevent="currentIndex = index">
                        </div>
                    </div>
                </div>
                <!-- End Navigation Circles -->
            </div>
        </div>
    </div>
</template>

<script>
import inViewport from 'in-viewport';

export default {
    data: () => ({
        timeout: null,
        heros: [
            {
                image_url: '',
                link: '',
            }
        ],
        currentIndex: 0,
    }),

    mounted() {
        window.coeliac().request().get('/api/heros').then((response) => {
            this.heros = response.data;
            this.createTimeout();
        });

        window.addEventListener('scroll', () => {
            let headerInView = inViewport(document.getElementById('heros'));

            if (!headerInView) {
                this.resetTimeout();
                return;
            }

            if (!this.timeout && headerInView) {
                this.createTimeout();
            }
        }, {passive: true})
    },

    methods: {
        createTimeout() {
            this.timeout = setTimeout(() => {
                if (this.currentIndex + 1 >= this.heros.length) {
                    this.currentIndex = 0;
                    return;
                }

                this.currentIndex++;
            }, 5000)
        },

        resetTimeout() {
            clearTimeout(this.timeout);
            this.timeout = null;
        }
    },

    watch: {
        currentIndex: function () {
            this.resetTimeout();
            this.createTimeout();
        }
    }
}
</script>
