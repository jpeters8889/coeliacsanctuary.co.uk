<template>
    <div :class="inline ? 'inline-block' : ''">
        <div :class="inline ? 'inline-block' : ''"n @click="showContact = true">
            <slot></slot>
        </div>

        <portal to="modal" v-if="showContact">
            <modal>
                <contact-form></contact-form>
            </modal>
        </portal>
    </div>
</template>

<script>
    import GoogleEvents from "../Mixins/GoogleEvents";
    import ContactForm from "./ContactForm";
    import Modal from "./Modal";

    export default {
        mixins: [GoogleEvents],

        components: {
            'contact-form': ContactForm,
            'modal': Modal,
        },

        props: {
            open: {
                type: Boolean,
                default: false,
            },
            redirect: {
                type: String,
                default: null,
            },
            inline: {
                type: Boolean,
                default: false
            }
        },

        data: () => ({
            showContact: false,
        }),

        mounted() {
            if(this.open) {
                this.showContact = true;
            }

            this.$root.$on('hide-contact-form', () => {
                this.closeModal();
            })

            this.$root.$on('modal-closed', () => {
                this.closeModal();
            });
        },

        methods: {
            closeModal() {
                this.showContact = false;

                if(this.redirect) {
                    window.location.href = this.redirect;
                }
            }
        },

        watch: {
            showContact: function() {
                if(this.showContact) {
                    this.googleEvent('event', 'contact-form', {
                        event_category: 'toggled',
                    });
                }
            }
        }
    }
</script>
