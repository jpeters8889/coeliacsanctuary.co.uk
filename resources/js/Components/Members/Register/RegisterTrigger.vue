<template>
    <div>
        <a @click.prevent="showModal = true" :class="classes">
            <slot></slot>
        </a>

        <portal to="modal" v-if="showModal">
            <modal>
                <member-register-form></member-register-form>
            </modal>
        </portal>
    </div>
</template>

<script>
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        'modal': Modal,
    },

    data: () => ({
        showModal: false,
    }),

    props: ['classes'],

    mounted() {
        this.$root.$on('modal-closed', () => {
            this.showModal = false;
        });
    }
}
</script>
