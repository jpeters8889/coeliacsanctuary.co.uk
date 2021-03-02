<template>
    <div>
        <div v-if="isLoading" class="relative w-full h-32">
            <loader :show="true"></loader>
        </div>

        <div v-else class="mt-2 flex flex-col space-y-2 sm:flex-wrap sm:flex-row justify-between sm:-mx-1">
            <div v-for="subscription in subscriptions" class="bg-blue-gradient-30 rounded p-2 flex">
                <div class="flex flex-col flex-1">
                    <h2 class="text-lg font-semibold">{{ subscription.type.name }}</h2>
                    <p class="mb-2">{{ subscription.type.description }}</p>
                    <p class="text-sm">
                        <strong>Subscribed To: </strong>
                        <a :href="subscription.updatable.link" target="_blank" class="font-semibold text-blue-dark hover:underline">
                            {{ subscription.updatable.name }}
                        </a>
                    </p>
                    <p class="text-sm">
                        <strong>Subscribed Since:</strong>
                        {{ formatDate(subscription.created_at, 'DD/MM/YY HH:mm') }}
                    </p>
                </div>
                <div @click="confirmUnsubscribe = subscription" class="ml-2 flex flex-col items-center cursor-pointer pt-2 text-grey opacity-50 hover:opacity-100 hover:text-blue-dark transition-colour">
                    <font-awesome-icon class="text-5xl" :icon="['far', 'trash-alt']"></font-awesome-icon>
                    <span class="text-xs pt-1 font-semibold">Unsubscribe</span>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="confirmUnsubscribe">
            <modal small name="delete-scrapbook">
                <p>Are you sure you want to delete your {{ confirmUnsubscribe.type.name}} daily update subscription to '{{ confirmUnsubscribe.subscribable.name }}'?</p>
                <div class="flex space-x-4 justify-center mt-2">
                    <a class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
                       @click="closeConfirmationModal">
                        No
                    </a>

                    <a class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
                       @click="unsubscribe()">
                        Yes
                    </a>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
import FormatsDates from "../Mixins/FormatsDates";

const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    mixins: [FormatsDates],

    components: {
        loader: Loader,
        modal: Modal,
    },

    data: () => ({
        isLoading: true,
        subscriptions: [],
        confirmUnsubscribe: null,
    }),

    mounted() {
        this.loadSubscriptions();
    },

    methods: {
        closeConfirmationModal()
        {
            this.confirmUnsubscribe = null;
            document.querySelector('body').classList.remove('overflow-hidden');
        },

        loadSubscriptions() {
            coeliac().request().get('/api/member/dashboard/daily-updates')
                .then((response) => {
                    this.subscriptions = response.data;
                })
                .catch(() => {
                    //
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        unsubscribe() {
            coeliac().request().delete(`/api/member/dashboard/daily-updates/${this.confirmUnsubscribe.id}`)
            .then(() => {
                coeliac().success(`You're now unsubscribed from getting daily updates about ${this.confirmUnsubscribe.type.name} ${this.confirmUnsubscribe.subscribable.name}`);
                this.loadSubscriptions();
            })
            .catch(() => {
                coeliac().error(`There was an error unsubscribing you from ${this.confirmUnsubscribe.subscribable.name}`)
            })
            .finally(() => {
                this.confirmUnsubscribe = null;
            })
        }
    },
}
</script>
