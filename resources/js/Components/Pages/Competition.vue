<template>
    <div>
        <div class="bg-blue-gradient-30 border border-blue rounded-lg p-4 m-2 lg:mx-auto" style="max-width: 1000px;">
            <div v-if="!hasEntered">
                <p class="font-semibold text-lg mb-5 text-center">
                    To enter our competition just enter your name and email below!
                </p>

                <div class="mb-5 flex-1">
                    <form-input required name="name" :value="form.data.name"
                                placeholder="Your Name..."></form-input>
                </div>

                <div class="mb-5 flex-1">
                    <form-input required name="email" type="email" :value="form.data.email"
                                placeholder="Your email..."></form-input>
                </div>

                <div class="mb-5 flex-1">
                    <p>
                        By entering this competition you agree to the competition <a
                        class="font-semibold hover:text-blue-dark hover:underline cursor-pointer" @click="viewTerms">Terms
                        and Conditions</a>.
                    </p>
                </div>

                <div class="w-full flex justify-center">
                    <button
                        class="mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20"
                        @click.prevent="submitForm()" :disabled="isSubmitting"
                        style="width: 305px; height: 65px;">
                        <loader v-if="isSubmitting" show background-position="relative" width="30px"
                                height="30px"></loader>
                        <span v-else>Enter Competition!</span>
                    </button>
                </div>
            </div>

            <div v-else>
                <p class="text-xl font-semibold text-center">
                    Thanks for entering our competition, good luck!
                </p>

                <div v-if="hasMoreEntries && extraEntriesCount() > 0" class="mt-2">
                    <p class="font-semibold text-center">
                        Do you want up to {{ extraEntriesCount() }} more chances to win?
                    </p>

                    <ul class="mt-4">
                        <li v-for="entry in extraEntryOptions()" class="flex items-center p-2 cursor-pointer"
                            :class="entry.classes"
                            v-show="!additionalEntries.includes(entry.id)" @click="entry.click()">
                            <span class="text-5xl mr-2 sm:mr-4 leading-none" style="width: 42px">
                                <font-awesome-icon v-if="entry.icon" :icon="entry.icon"></font-awesome-icon>
                                <component v-if="entry.component" :is="entry.component"></component>
                            </span>
                            <span class="flex-1">{{ entry.label }}</span>
                            <div class="flex flex-col justify-center items-center leading-none">
                                <span class="text-3xl">+1</span>
                                <span class="text-xs font-semibold">ENTRY</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="viewTermsModal">
            <modal modal-classes="w-full">
                <div class="h-48" v-if="!terms">
                    <loader show></loader>
                </div>
                <div v-else class="text-xs main-body" v-html="terms"></div>
            </modal>
        </portal>
    </div>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        'form-input': FormInput,
        loader: Loader,
        modal: Modal,
    },

    props: {
        uuid: {
            required: true,
            type: String,
        },
        facebookLike: {
            required: true,
            type: Boolean | Number,
        },
        facebookShare: {
            required: true,
            type: Boolean | Number,
        },
        twitterFollow: {
            required: true,
            type: Boolean | Number,
        },
        twitterTweet: {
            required: true,
            type: Boolean | Number,
        },
        shopPurchase: {
            required: true,
            type: Boolean | Number,
        },
    },

    data: () => ({
        entryId: null,
        hasEntered: false,
        isSubmitting: false,
        viewTermsModal: false,
        terms: null,

        additionalEntries: [],

        form: {
            data: {
                name: '',
                email: '',
            },
            validation: {
                name: false,
                email: false,
            }
        },
    }),

    mounted() {
        Object.keys(this.form.validation).forEach((key) => {
            this.$root.$on(`${key}-error`, () => {
                this.form.validation[key] = false;
            });

            this.$root.$on(`${key}-valid`, () => {
                this.form.validation[key] = true;
            });

            this.$root.$on(`${key}-change`, (value) => {
                this.form.data[key] = value;
            });

            this.$root.$on(`${key}-value`, (value) => {
                this.form.data[key] = value;
            });
        });

        this.$root.$on('modal-closed', () => this.viewTermsModal = false);
    },

    methods: {
        viewTerms() {
            this.viewTermsModal = true;

            if (this.terms) {
                return;
            }

            coeliac().request().get(`/api/competition/${this.uuid}/terms`)
                .then((response) => {
                        this.terms = response.data;
                    }
                );
        },

        submitForm() {
            if (!this.validateForm()) {
                coeliac.error('Please complete your entry form!');
                return;
            }

            this.isSubmitting = true;

            coeliac().request().post(`/api/competition/${this.uuid}`, this.form.data)
                .then((response) => {
                    this.entryId = response.data.id;
                    this.hasEntered = true;
                })
                .catch((err) => {
                    let error = 'There was an error submitting your entry.'

                    if (err.response.data.error === 'duplicate entry') {
                        error = "You've already entered this competition!"
                    }

                    coeliac().error(error);
                })
                .finally(() => {
                    this.isSubmitting = false;
                })
        },

        addAdditionalEntry(entryType) {
            coeliac().request().put(`/api/competition/${this.uuid}`, {
                id: this.entryId,
                type: entryType,
            })
                .then(() => {
                    coeliac().success("Thanks, you've now got an additional chance in our competition!")
                    this.additionalEntries.push(entryType);
                })
                .catch(() => {
                    coeliac().error('Sorry, there was an error processing your additional entry');
                });
        },

        validateForm() {
            Object.keys(this.form.validation).forEach((key) => {
                this.$root.$emit(`${key}-get-value`)
            });

            let isValid = true;

            Object.keys(this.form.validation).forEach((key) => {
                if (this.form.validation[key] === false) {
                    isValid = false;
                }
            });

            return isValid;
        },

        openPopup(link, title) {
            window.open(link, title, 'height=480,width=640,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no')
        },

        extraEntryOptions() {
            let options = [];

            if (this.facebookLike) {
                options.push({
                    id: 'facebook_like',
                    label: 'Visit and like our Facebook Page',
                    icon: ['fab', 'facebook-square'],
                    classes: ['text-grey-off-light hover:text-white bg-social-facebook-light hover:bg-social-facebook transition-bg'],
                    click: () => {
                        window.open('https://www.facebook.com/coeliacsanctuary');
                        this.addAdditionalEntry('facebook_like');
                    }
                })
            }

            if (this.twitterFollow) {
                options.push({
                    id: 'twitter_follow',
                    label: 'Visit and follow us on our Twitter Page',
                    icon: ['fab', 'twitter-square'],
                    classes: ['text-grey-off-light hover:text-white bg-social-twitter-light hover:bg-social-twitter transition-bg'],
                    click: () => {
                        window.open('https://twitter.com/coeliacsanc');
                        this.addAdditionalEntry('twitter_follow');
                    }
                })
            }

            if (this.facebookShare) {
                options.push({
                    id: 'facebook_share',
                    label: 'Share our competition on Facebook',
                    icon: ['fab', 'facebook-square'],
                    classes: ['text-grey-off-light hover:text-white bg-social-facebook-light hover:bg-social-facebook transition-bg'],
                    click: () => {
                        this.openPopup(
                            'https://www.facebook.com/sharer.php?u=' + window.location.href,
                            'Share On Facebook'
                        );

                        this.addAdditionalEntry('facebook_share');
                    }
                })
            }

            if (this.twitterTweet) {
                options.push({
                    id: 'twitter_tweet',
                    label: 'Share our competition on Twitter',
                    icon: ['fab', 'twitter-square'],
                    classes: ['text-grey-off-light hover:text-white bg-social-twitter-light hover:bg-social-twitter transition-bg'],
                    click: () => {
                        this.openPopup(
                            'https://twitter.com/intent/tweet?text=' + document.querySelector('meta[name=description]').getAttribute('content') + '&via=CoeliacSanc&url=' + window.location.href,
                            'Share on Twitter'
                        );

                        this.addAdditionalEntry('twitter_tweet');
                    }
                })
            }

            if (this.shopPurchase) {
                options.push({
                    id: 'shop_purchase',
                    label: 'Purchase from the Coeliac Sanctuary Shop',
                    component: 'coeliac-icon',
                    classes: ['text-grey-off-light hover:text-white bg-yellow-50 hover:bg-yellow transition-bg'],
                    click: () => {
                        window.open('https://www.coeliacsanctuary.co.uk/shop');
                        this.addAdditionalEntry('shop_purchase');
                    }
                })
            }

            return options;
        },

        extraEntriesCount() {
            const checks = [
                {key: 'facebook_like', value: this.facebookLike},
                {key: 'facebook_share', value: this.facebookShare},
                {key: 'twitter_tweet', value: this.twitterTweet},
                {key: 'twitter_follow', value: this.twitterFollow},
                {key: 'shop_purchase', value: this.shopPurchase},
            ];

            return checks
                .filter(item => item.value === 1)
                .filter(item => !this.additionalEntries.includes(item.key))
                .length
        }
    },

    computed: {
        hasMoreEntries() {
            const checks = [
                this.facebookLike,
                this.facebookShare,
                this.twitterTweet,
                this.twitterFollow,
                this.shopPurchase
            ];

            return checks.includes(1);
        },
    }
}
</script>
