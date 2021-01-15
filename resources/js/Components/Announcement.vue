<template>
    <slot></slot>

    <portal to="modal" v-if="showModal">
        <modal modal-classes="text-center">
            <h2 class="text-lg mb-2 font-semibold">
                <slot name="title" class="mb-2 font-semibold"></slot>
            </h2>

            <div>
                <slot name="body"></slot>
            </div>
        </modal>
    </portal>
</template>

<script>
import GoogleEvents from "../Mixins/GoogleEvents";
import Modal from "./Modal";

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
        showModal: function () {
            if (this.showModal) {
                this.googleEvent('event', 'viewed-announcement');
            }
        }
    }
}
</script>
