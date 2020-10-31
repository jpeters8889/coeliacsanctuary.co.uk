<template>
    <div class="w-full">
        <div class="z-max bg-blue-80 w-full px-2 py-0 text-white text-3xl md:bg-blue md:p-0 z-10"
             id="top-bar"
             :class="stickyNav ? 'top-0 bg-blue slide-down' : ''"
             :style="stickyNav ? 'position: fixed!important;' : ''">
            <div class="flex justify-between items-center inner-wrapper md:relative">
                <mobile-nav class="mr-2 md:hidden"></mobile-nav>
                <a href="/">
                    <coeliac-icon class="js-mob-icon text-white md:hidden" style="height: 1.875rem"></coeliac-icon>
                </a>
                <coeliac-nav class="hidden md:block"></coeliac-nav>
                <header-search class="md:absolute md:right-0 md:top-0 md:mr-2"></header-search>
            </div>
        </div>
        <div id="top-bar-check"></div>
    </div>
</template>

<script>

    import CoeliacNav from "./CoeliacNav";

    export default {
        data: () => ({
            stickyNav: false,
        }),

        components: {
            'coeliac-nav': CoeliacNav,
        },

        mounted() {
            new IntersectionObserver(entries => {
                if (window.scrollY === 0) {
                    this.stickyNav = false;
                    return;
                }
                this.stickyNav = entries[0].intersectionRatio === 0;
            }).observe(document.querySelector('#top-bar-check'));
        }
    }
</script>
