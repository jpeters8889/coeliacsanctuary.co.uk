<template>
    <div class="flex-1 flex flex-col">
        <div class="flex flex-col justify-center items-center -mt-4 mb-4 space-y-2">
            <img class="w-1/2 max-h-logo" src="/assets/svg/logo.svg" alt="Coeliac Sanctuary"/>
            <h1 class="text-4xl font-medium font-coeliac mb-2 text-center">Coeliac Sanctuary</h1>
        </div>

        <div class="flex-1 flex flex-col justify-center items-center inner-wrapper" @mouseenter="clearTimeout()"
             @mouseleave="setTimeout()">
            <div class="bg-white-80 p-4 w-full md:w-3/4">
                <h2 class="mb-2 text-2xl font-semibold text-center">
                    {{ slides[currentIndex].title }}
                </h2>
                <p class="mb-2">{{ slides[currentIndex].description }}</p>
                <div class="flex justify-center">
                    <a :href="slides[currentIndex].cta.link"
                       class="bg-yellow px-6 py-2 font-semibold leading-none inline-block text-xl transition-width">
                        {{ slides[currentIndex].cta.label }}
                    </a>
                </div>
            </div>

            <div class="flex justify-center mt-4 w-full">
                <div v-for="(item, index) in slides">
                    <div class="w-4 h-4 rounded-full mx-1 cursor-pointer border border-white-80"
                         :class="index === currentIndex ? 'bg-white-80' : ''"
                         @click.prevent="currentIndex = index">
                    </div>
                </div>
            </div>
        </div>

        <div class="items-baseline flex justify-center mt-4 w-full">
            <div class="text-3xl leading-none text-white-80 pulse">
                <font-awesome-icon :icon="['fas', 'chevron-down']"></font-awesome-icon>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        timeout: null,
        slides: [
            {
                title: 'Coeliac Sanctuary Shop',
                description: `Check out our online shop for some great coeliac related goodies, including our fantastic travel cards for when
                you go abroad, our 'Gluten Free' stickers, our wristbands, and much more too!`,
                cta: {
                    link: '/shop',
                    label: 'Visit our Shop',
                }
            },

            {
                title: 'Coeliac Sanctuary Blogs',
                description: `Our blogs are part our heart and soul, covering a wide range of subjects across the gluten free world, from new
                products, news, guides, always something for everyone!`,
                cta: {
                    link: '/blog',
                    label: 'Checkout our Blogs',
                }
            },

            {
                title: 'Coeliac Sanctuary Recipes',
                description: `We keep all of our recipes simple and use simple ingredients you can get from most supermarkets, and more importantly
                they're all tried and tested by us!`,
                cta: {
                    link: '/recipe',
                    label: 'Checkout our Recipes',
                }
            },

            {
                title: 'Places to Eat',
                description: `We've got over 1500 independent places to eat out listed in our eating out guide spread all over the UK, and all
                contributed to and rated by other Coeliacs!`,
                cta: {
                    link: '/wheretoeat',
                    label: 'Visit our Eating Out guide',
                }
            }
        ],
        currentIndex: 0,
    }),

    mounted() {
        this.setTimeout();
    },

    methods: {
        setTimeout() {
            this.timeout = setTimeout(() => {
                if (this.currentIndex === this.slides.length - 1) {
                    this.currentIndex = 0;
                    return;
                }

                this.currentIndex++;
            }, 4000);
        },

        clearTimeout() {
            clearTimeout(this.timeout);
        }
    },

    watch: {
        currentIndex: function () {
            this.clearTimeout();
            this.setTimeout();
        }
    }
}
</script>
