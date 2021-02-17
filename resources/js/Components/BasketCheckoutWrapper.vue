<template>
    <div class="bg-blue-gradient w-full rounded-lg p-2 shadow mx-auto max-w-11/12">
        <div class="flex flex-col xs:flex-row xs:justify-between xs:pt-4 mb-4">
            <template v-for="item in sections" v-if="item.enabled">
                <div class="flex xs:flex-col xs:flex-1" :class="item.canVisit ? 'cursor-pointer' : ''"
                     @click="switchSection(item)">
                    <div class="px-4 relative xs:px-0">
                        <div class="w-5 h-5 rounded-full absolute text-white" :class="headerCircleBackground(item)"
                             style="left: 50%; top: 50%; transform: translate(-50%, -50%)">

                        </div>
                        <div class="border-4 border-yellow h-full"></div>
                    </div>
                    <div class="flex-1 py-3 xs:text-center"
                         :class="item.completed || item.active || item.canVisit ? 'font-semibold text-black' : 'text-grey'">
                        {{ item.title }}
                    </div>
                </div>
            </template>
        </div>

        <div>
            <component :is="activeComponent" :default-data="currentData" :country-id="countryId"></component>
        </div>
    </div>
</template>

<script>
import GoogleEvents from "../Mixins/GoogleEvents";
import UserDetails from "./Checkout/UserDetails";
import ShippingDetails from "./Checkout/ShippingDetails";
import PaymentDetails from "./Checkout/PaymentDetails";
import InteractsWithUser from "../Mixins/InteractsWithUser";

export default {
    mixins: [GoogleEvents, InteractsWithUser],

    props: {
        countryId: {
            type: Number,
            required: true,
        }
    },

    components: {
        'basket-checkout-user-details': UserDetails,
        'basket-checkout-shipping-details': ShippingDetails,
        'basket-checkout-payment-details': PaymentDetails,
    },

    mounted() {
        if (this.isLoggedIn()) {
            this.sections[0].enabled = false;
            this.sections[0].active = false;
            this.sections[1].active = true;
        }

        if (sessionStorage.getItem('checkout-data')) {
            this.sections = JSON.parse(sessionStorage.getItem('checkout-data'));
        } else {
            sessionStorage.setItem('checkout-data', JSON.stringify(this.sections));
        }

        this.$root.$on('checkout-continue', (data) => {
            this.completeSection(data)
        });

        this.$root.$on('checkout-back', () => {
            this.goBack();
        });

        this.$root.$on('set-customer-name', (name) => {
            this.sections[0].data.name = name;
        })
    },

    data: () => ({
        sections: [
            {
                id: 'user-details',
                title: 'Your Details',
                component: 'basket-checkout-user-details',
                enabled: true,
                completed: true,
                active: true,
                canVisit: false,
                data: {
                    name: '',
                    email: '',
                    emailConfirmation: '',
                    phone: '',
                }
            },
            {
                id: 'shipping-address',
                title: 'Shipping Address',
                component: 'basket-checkout-shipping-details',
                enabled: true,
                completed: false,
                active: false,
                canVisit: false,
                data: {
                    id: null,
                    postcode: '',
                    address1: '',
                    address2: '',
                    address3: '',
                    town: '',
                    billingAddress: true,
                }
            },
            {
                id: 'payment',
                title: 'Payment',
                component: 'basket-checkout-payment-details',
                enabled: true,
                completed: false,
                active: false,
                canVisit: false,
                data: {
                    provider: '',
                    shippingAddress: '1',
                    billingId: null,
                    billingName: '',
                    billingAddress1: '',
                    billingAddress2: '',
                    billingAddress3: '',
                    billingTown: '',
                    billingPostcode: '',
                    billingCountry: '',
                }
            },
            {
                id: 'confirmation',
                title: 'Confirmation',
                component: '',
                enabled: true,
                completed: false,
                active: false,
                canVisit: false,
                data: {},
            }
        ]
    }),

    methods: {
        headerCircleBackground(item) {
            if (item.completed || item.active) {
                return 'bg-yellow';
            }

            if (item.canVisit) {
                return 'bg-white';
            }

            return 'bg-grey-off-dark';
        },

        completeSection(data) {
            const currentSectionId = this.sections.findIndex((item) => item.id === data.id);

            this.sections[currentSectionId].data = data.data;
            this.sections[currentSectionId].completed = true;
            this.sections[currentSectionId].active = false;
            this.sections[currentSectionId].canVisit = true;

            this.sections[currentSectionId + 1].active = true;
            this.sections[currentSectionId + 1].canVisit = true;

            if (this.sections[currentSectionId].id === 'shipping-address' && this.sections[2].completed === false) {
                this.sections[2].data = {
                    provider: '',
                    shippingAddress: '1',
                    billingName: this.sections[0].data.name,
                    billingAddress1: this.sections[1].data.address1,
                    billingAddress2: this.sections[1].data.address2,
                    billingAddress3: this.sections[1].data.address3,
                    billingTown: this.sections[1].data.town,
                    billingPostcode: this.sections[1].data.postcode,
                    billingCountry: sessionStorage.getItem('checkout-country'),
                }
            }

            sessionStorage.setItem('checkout-data', JSON.stringify(this.sections));
        },

        goBack() {
            const currentSectionId = this.sections.findIndex((item) => item.active === true);

            if (currentSectionId === 0) {
                return;
            }

            this.sections[currentSectionId].active = false;
            this.sections[currentSectionId - 1].active = true;
        },

        switchSection(section) {
            if (section.canVisit === true) {
                this.sections.find((item) => item.active === true).active = false;
                this.sections.find((item) => item.id === section.id).active = true;

                this.googleEvent('event', 'checkout-progress', {
                    event_label: section.title,
                })
            }
        }
    },

    computed: {
        activeComponent() {
            return this.sections.find((section) => section.active === true).component;
        },

        currentData() {
            return this.sections.find((section) => section.active === true).data;
        }
    }
}
</script>
