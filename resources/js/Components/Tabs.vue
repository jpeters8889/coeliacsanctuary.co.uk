<template>
    <div>
        <ul class="flex flex-col leading-none xs:flex-row">
            <li v-for="tab in tabs" class="w-full cursor-pointer py-3 px-6 border-2 w-full block transition-bg xs:w-auto xs:rounded-t-lg xs:mr-1"
                @click="activeTab = tab"
                :class="tab.isActive ? 'bg-yellow-50 border-yellow hover:bg-yellow-40' : 'bg-blue-light-50 border-blue-light hover:bg-blue-light-40'">
                {{ tab.title }}
            </li>
        </ul>

        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            baseUrl: {
                type: String,
                required: true,
            },
        },

        data: () => ({
            tabs: [],
            activeTab: null
        }),

        mounted() {
            this.tabs = this.$children;
            this.setInitialActiveTab();

            this.$root.$on('active-tab', (tab) => {
                this.activeTab = tab;
            });

            this.$root.$on('link-change', (link) => {
                this.update(link);
            });
        },

        methods: {
            setInitialActiveTab() {
                const path = window.location.pathname.split('/').slice(-1)[0];

                this.tabs.forEach((tab) => {
                    if(path === tab.url) {
                        this.activeTab = tab;
                    }
                });

                if (!this.activeTab && window.innerWidth <= 500) {
                    this.activeTab = this.tabs.find(tab => tab.mobileDefault) || null;
                }

                if (!this.activeTab) {
                    this.activeTab = this.tabs.find(tab => tab.active) || this.tabs[0];
                }
            },

            updateUrl(location) {
                window.history.pushState(null, null, window.location.origin + '/' + this.baseUrl + '/' + location);
            }
        },

        watch: {
            activeTab(activeTab) {
                this.tabs.map((tab) => {
                    if(tab === activeTab) {
                        tab.isActive = true;
                        this.updateUrl(tab.url);
                        return;
                    }

                    tab.isActive = false;
                });
            }
        },
    }
</script>
