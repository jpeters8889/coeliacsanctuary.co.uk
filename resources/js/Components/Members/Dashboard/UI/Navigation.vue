<template>
    <div>
        <!-- mobile trigger -->
        <div
            class="md:hidden fixed bottom-1 right-1 rounded-full bg-yellow p-3 text-xl text-white shadow-lg leading-none z-50"
            @click="showNav = true">
            <font-awesome-icon :icon="['fas', 'user-cog']"></font-awesome-icon>
        </div>

        <!-- mobile nav -->
        <div
            class="md:hidden h-screen bg-blue fixed overflow-scroll top-0 left-0 w-full h-full flex flex-col z-max text-white text-3xl"
            v-show="showNav">
            <div class="p-1 flex justify-end text-3xl p-2 js-mobile-nav-close-trigger" @click="showNav = false">
                <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
            </div>
            <nav class="flex-1 flex items-center">
                <ul class="flex flex-col w-full">
                    <li v-for="link in links" class="text-center p-1">
                        <a :href="link.link">{{ link.label }}</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="hidden border-r-8 border-blue mr-2 md:flex flex-col">
            <nav class="flex-1 flex items-center">
                <ul class="list-none flex flex-col w-full">
                    <li v-for="link in links" v-if="!link.mobileOnly">
                        <a class="block py-2 pl-2 border-b border-blue hover:bg-blue-light hover:text-white transition-both"
                           :href="link.link">{{ link.label }}</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        showNav: false,

        links: [
            {
                label: 'Scrapbooks',
                link: '/member/dashboard/scrapbooks',
            },

            {
                label: 'Purchase History',
                link: '/member/dashboard/orders',
            },
            {
                label: 'Daily Updates',
                link: '/member/dashboard/daily-updates',
            },
            {
                label: 'My Details',
                link: '/member/dashboard/details',
            },
            {
                label: 'Logout',
                link: '/member/logout',
                mobileOnly: true,
            },
        ]
    })
}
</script>
