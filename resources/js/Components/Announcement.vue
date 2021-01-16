<template>
    <div>
        <div class="bg-red-dark p-1 text-center text-white">
            <div class="flex flex-col">
                <slot name="title" class="mb-2 font-semibold"></slot>
                <a class="cursor-pointer text-white-80 text-sm hover:text-white hover:underline transition-color">
                    Read more
                </a>
            </div>
        </div>


    </div>
</template>

<script>
    import GoogleEvents from "../Mixins/GoogleEvents";
    import Modal from "./Modal";

    export default {
        // mixins: [GoogleEvents],
        //
        // components: {
        //     'modal': Modal,
        // },
        //
        // data: () => ({
        //     showModal: false,
        // }),
        //
        // mounted() {
        //     this.$root.$on('modal-closed', () => {
        //         this.showModal = false;
        //     });
        // },
        //
        // watch: {
        //     showModal: function() {
        //         if(this.showModal) {
        //             this.googleEvent('event', 'viewed-announcement');
        //         }
        //     }
        // }
    }
</script>
