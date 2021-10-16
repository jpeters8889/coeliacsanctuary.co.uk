<template>
  <div>
    <div class="hidden border-r-8 border-blue mr-2 md:flex flex-col">
      <nav class="flex-1 flex items-center">
        <ul class="list-none flex flex-col w-full">
          <li
            v-for="(link, index) in links"
            :key="index"
          >
            <a
              v-if="!link.mobileOnly"
              class="block py-2 pl-2 border-b border-blue hover:bg-blue-light hover:text-white transition-all"
              :href="link.link"
            >
              {{ link.label }}
            </a>
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
    ],
  }),
};
</script>
