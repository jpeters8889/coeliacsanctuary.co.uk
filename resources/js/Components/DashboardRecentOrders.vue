<template>
    <div>
        <pagination :current="currentPage"
                    :lastPage="lastPage"
                    :can-go-back="currentPage > 1"
                    :can-go-forward="currentPage < lastPage"
        ></pagination>

        <div class="main-body" ref="items">
            <div class="my-4 border-2 border-blue rounded-lg flex flex-col leading-none lg:hidden"
                 v-for="order in results"
                 :key="order.reference">
                <div class="flex" v-for="(params, index) in orderParameters()"
                     v-if="!params.condition ||params.condition(order)">
                    <div class="w-1/2 bg-blue text-white font-semibold p-2 border-white"
                         :class="index === orderParameters().length - 1 ? 'border-0' : 'border-b'">
                        {{ params.label }}
                    </div>
                    <div class="w-1/2 p-2 border-blue"
                         :class="index === orderParameters().length - 1 ? 'border-0' : 'border-b'"
                         v-html="params.format ? params.format(order[params.prop]) : order[params.prop]">
                    </div>
                </div>
                <div
                    class="bg-blue text-white font-semibold p-2 hover:bg-blue-light cursor-pointer text-lg text-center border-t border-white transition-bg"
                    @click="showOrderDetails = order.reference">
                    More Info
                </div>
            </div>

            <table class="lg:table order-dashboard mt-4">
                <thead>
                <tr>
                    <th v-for="params in orderParameters()">
                        {{ params.label }}
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in results" :key="order.reference">
                    <td v-for="params in orderParameters()"
                        v-html="!params.condition || params.condition(order) ? params.format ? params.format(order[params.prop]) : order[params.prop] : ''"></td>
                    <td>
                        <div class="bg-blue rounded px-3 py-1 text-white font-semibold cursor-pointer"
                             @click="showOrderDetails = order.reference">
                            More Info
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <pagination :current="currentPage"
                    :lastPage="lastPage"
                    :can-go-back="currentPage > 1"
                    :can-go-forward="currentPage < lastPage"
        ></pagination>

        <portal to="modal" v-if="showOrderDetails">
            <modal modal-classes="w-full" small>
                <dashboard-order-details :id="showOrderDetails"></dashboard-order-details>
            </modal>
        </portal>
    </div>
</template>

<script>
import FormatsDates from "../Mixins/FormatsDates";
import FormatsPrices from "../Mixins/FormatsPrices";

const Pagination = () => import('./Pagination' /* webpackChunkName: "chunk-pagination" */);
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */);
const DashboardOrderDetails = () => import('./DashboardOrderDetails' /* webpackChunkName: "chunk-dashboard-order-details" */)

export default {
    components: {
        'pagination': Pagination,
        'modal': Modal,
        'dashboard-order-details': DashboardOrderDetails,
    },

    mixins: [FormatsDates, FormatsPrices],

    data: () => ({
        error: false,
        results: [],
        currentPage: 1,
        lastPage: 1,
        loading: true,

        showOrderDetails: false,
    }),

    mounted() {
        this.getData();

        this.$root.$on('pagination-click', (page) => {
            if (page === 'next') {
                page = this.currentPage + 1;
            }

            if (page === 'prev') {
                page = this.currentPage - 1;
            }

            this.currentPage = page;

            this.getData();
            this.$scrollTo(this.$refs.items, 500, {
                offset: -200,
            });
        });

        this.$root.$on('modal-closed', () => {
            this.showOrderDetails = false;
        });
    },

    methods: {
        getData() {
            coeliac().request().get(`/api/member/dashboard/orders?page=${this.currentPage}`)
                .then((response) => {
                    this.results = response.data.data;
                    this.lastPage = response.data.last_page;
                })
                .catch(() => {
                    this.error = true;
                })
                .finally(() => {
                    this.loading = false;
                })
        },

        orderParameters: function () {
            return [
                {
                    label: 'Order Date',
                    prop: 'order_date',
                    format: value => this.formatDate(value, 'D MMMM YYYY HH:mm'),
                },
                {
                    label: 'Reference',
                    prop: 'reference',
                },
                {
                    label: 'Number of Items',
                    prop: 'number_of_items',
                },
                {
                    label: 'Order Status',
                    prop: 'state',
                },
                {
                    label: 'Shipped On',
                    prop: 'shipped_at',
                    condition: order => order.shipped_at,
                    format: value => this.formatDate(value, 'D MMMM YYYY HH:mm'),
                },
                {
                    label: 'Total Cost',
                    prop: 'total_cost',
                    format: value => this.formatPrice(value)
                },
            ];
        }
    }
}
</script>
