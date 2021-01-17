<template>
    <modal modal-classes="w-3/4">
        <loader :show="loading"></loader>

        <div class="w-full flex flex-col">
            <div class="mb-2">
                <p>
                    Lucky enough to have a discount code? Enter it below and we'll validate it and add it to your order!
                </p>
            </div>
            <div class="mb-2">
                <form-input name="code" placeholder="Enter your discount code..." :value="discountCode" required/>
            </div>
            <div class="text-center">
                <button class="w-full bg-yellow rounded-lg py-2 px-4 font-semibold" @click="validateCode()">
                    Validate Discount Code
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
    import GoogleEvents from "../Mixins/GoogleEvents";
    const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)

    const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)
    const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)

    export default {
        mixins: [GoogleEvents],

        components: {
            'loader': Loader,
            'modal': Modal,
            'form-input': FormInput,
        },

        data: () => ({
            discountCode: '',
            loading: false,
        }),

        mounted() {
            this.googleEvent('event', 'checkout-progress', {
                event_category: 'opened-discount-modal',
            });

            this.$root.$on('code-change', (value) => {
                this.discountCode = value;
            });
        },

        methods: {
            validateCode() {
                this.loading = true;
                coeliac().request().post('/api/shop/basket/discount', {
                    code: this.discountCode,
                }).then((response) => {
                    if (response.status === 200) {
                        this.googleEvent('event', 'checkout-progress', {
                            event_category: 'applied-discount',
                            event_label: this.discountCode,
                        });

                        coeliac().success(`Yay! We've validated your ${response.data.name} discount code and added it to your order!`);
                        this.$root.$emit('basket-discount-code-validated');

                        return;
                    }

                    this.reportError();
                }).catch(() => {
                    this.reportError();
                });
            },

            reportError() {
                this.googleEvent('event', 'checkout-progress', {
                    event_category: 'invalid-discount',
                    event_label: this.discountCode,
                });

                this.loading = false;
                coeliac().error('Sorry, there was an error validating your discount code, please check your code and try again.');
            }
        }
    }
</script>
