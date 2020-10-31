<template>
    <div>
        <portal to="modal" v-if="showModal">
            <modal small>
                <a @click.prevent="clickedPopup($event)" :href="modal.link" class="flex flex-col">
                    <div>
                        <img :src="modal.image" :alt="modal.text"/>
                    </div>
                    <div class="flex justify-center">
                        <div class="w-3/4 text-center" v-html="modal.text"></div>
                    </div>
                </a>
            </modal>
        </portal>
    </div>
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
            modal: {
                id: '',
                text: '',
                link: '',
                image: '',
            },
        }),

        mounted() {
            coeliac().request().get('/api/popup').then((response) => {
                if (response.status === 200 && Object.values(response.data).length > 0) {
                    this.modal = response.data;

                    setTimeout(() => {
                        this.showModal = true
                        this.googleEvent('event', 'view-promotion', {
                            event_label: 'loaded',
                        });

                    }, 6000);
                }
            });

            this.$root.$on('modal-closed', () => {
                this.showModal = false;

                if (this.modal.id) {
                    coeliac().request().patch(`/api/popup/${this.modal.id}`);
                }
            })
        },

        methods: {
            clickedPopup($event) {
                this.googleEvent('event', 'view-promotion', {
                    event_label: 'clicked',
                });

                window.location.href = modal.link;
            }
        }
    }
</script>
