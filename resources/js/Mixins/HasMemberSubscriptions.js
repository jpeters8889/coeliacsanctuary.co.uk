import InteractsWithUser from "./InteractsWithUser";

export default {
    mixins: [InteractsWithUser],

    data: () => ({
        showUserCta: false,
        isSubscribed: false,
        subscribable: null,
        type: null,
    }),

    mounted() {
        this.seeIfSubscribed();

        this.$root.$on('modal-closed', (name) => {
            if (name === 'userCta') {
                this.showUserCta = false;
            }
        });
    },

    methods: {
        toggleSubscription() {
            if (!this.isLoggedIn()) {
                this.showUserCta = true;
                return;
            }

            if (this.isSubscribed) {
                this.unsubscribe();
                return;
            }

            this.subscribe();
        },

        unsubscribe() {
            coeliac().request().delete(`/api/member/dashboard/subscriptions/${this.isSubscribed.id}`)
                .then(() => {
                    this.unsubscribeSuccess();
                    this.isSubscribed = false;
                })
                .catch(() => {
                    this.unsubscribeError();
                })
        },

        subscribe() {
            coeliac().request().post(`/api/member/dashboard/subscriptions`, {
                type: this.type,
                subscribable: this.subscribable,
            }).then(() => {
                this.subscribeSuccess();
                this.seeIfSubscribed();
            }).catch(() => {
                this.unsubscribeError();
            })
        },

        seeIfSubscribed() {
            return coeliac().request().post('/api/member/dashboard/subscriptions/search', {
                'type': this.type,
                'subscribable': this.subscribable,
            }).then((response) => {
                if (response.status === 200) {
                    this.isSubscribed = response.data;
                    return;
                }

                this.isSubscribed = false;
            }).catch(() => {
                this.isSubscribed = false;
            })
        },

        unsubscribeSuccess() {
        },

        unsubscribeError() {
        },

        subscribeSuccess() {
        },

        subscribeError() {
        },
    },

    computed: {
        icon() {
            return [this.isSubscribed ? 'fas' : 'far', 'bell'];
        },
    }
}
