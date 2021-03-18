<template>
    <div>
        <div class="bg-red-dark p-1 text-center text-white">
            <div class="flex flex-col">
                <slot name="title" class="mb-2 font-semibold"></slot>
                <a class="cursor-pointer text-white-80 text-sm hover:text-white hover:underline transition-color" @click="showModal = true">
                    Read more
                </a>
            </div>
        </div>

        <portal to="modal" v-if="showModal">
            <modal modal-classes="text-center">
                <h2 class="text-lg mb-2 font-semibold">
                    <slot name="title" class="mb-2 font-semibold"></slot>
                </h2>

                <div>
                    <slot></slot>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    import GoogleEvents from "@/Mixins/GoogleEvents";
    const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

    export default {
        mixins: [GoogleEvents],

        components: {
            'modal': Modal,
        },

        data: () => ({
            showModal: false,
        }),

        mounted() {
            this.$root.$on('modal-closed', () => {
                this.showModal = false;
            });
        },

        watch: {
            showModal: function() {
                if(this.showModal) {
                    this.googleEvent('event', 'viewed-announcement');
                }
            }
        }
    }
</script>
