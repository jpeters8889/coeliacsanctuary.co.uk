<template>
    <div class="w-full">
        <div class="z-max w-full px-2 py-0 text-white text-3xl md:p-0 z-10"
             id="top-bar"
             :class="backgroundClasses"
             :style="stickyNav ? 'position: fixed!important;' : ''">
            <div class="flex justify-between items-center inner-wrapper md:relative py-2 md:py-0">
                <mobile-nav class="mr-2 md:hidden"/>
                <a href="/">
                    <coeliac-icon class="js-mob-icon text-white md:hidden" style="height: 1.875rem"/>
                </a>
                <coeliac-nav class="hidden md:block" v-if="width > 500"/>
                <div class="flex md:absolute md:right-0 md:top-0 md:mr-2 leading-none h-full">
                    <user-manager class="mr-2"/>
                    <header-search class="h-full flex items-center "/>
                </div>
            </div>
        </div>
        <div id="top-bar-check"></div>
    </div>
</template>

<script>
const CoeliacNav = () => import("./CoeliacNav" /* webpackChunkName: "preload-coeliac-nav" */);
const UserManager = () => import("./UserManager" /* webpackChunkName: "preload-user-manager" */);

export default {
    props: {
        transparent: {
            required: false,
            type: Boolean,
            default: () => false,
        }
    },

    data: () => ({
        stickyNav: false,
    }),

    components: {
        'coeliac-nav': CoeliacNav,
        'user-manager': UserManager,
    },

    mounted() {
        new IntersectionObserver(entries => {
            if (window.scrollY === 0) {
                this.stickyNav = false;
                return;
            }
            this.stickyNav = entries[0].intersectionRatio === 0;
        }).observe(document.querySelector('#top-bar-check'));
    },

    computed: {
        backgroundClasses() {
            if (this.stickyNav) {
                return ['top-0', 'bg-blue', 'slide-down']
            }

            if (!this.transparent) {
                return ['bg-blue-80', 'md:bg-blue'];
            }

            return [];
        },

        width() {
            return window.innerWidth;
        }
    }
}
</script>
