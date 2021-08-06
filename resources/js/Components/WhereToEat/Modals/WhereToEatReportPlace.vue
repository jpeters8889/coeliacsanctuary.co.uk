<template>
    <div>
        <h2 class="text-lg font-semibold mb-2">
            Report a problem with {{ place.name }}
        </h2>

        <p class="mb-2">
            Has {{ place.name }} closed down? Or does it no longer do gluten free, or does it not do gluten free
            properly? Or have the gluten free options changed?
        </p>

        <p class="mb-2">
            Whatever it is, let us know below, and we'll check it out!
        </p>

        <div class="flex flex-col">
            <div class="flex flex-col">
                <div class="mb-5 flex-1">
                    <form-textarea required name="details" :value="details" :rows="5"></form-textarea>
                </div>
                <div class="mb-5 flex-1 text-center">
                    <button
                        class="mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20"
                        @click.prevent="submitForm()"
                    >
                        Report Place
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */)

export default {
    components: {
        'form-textarea': FormTextarea,
    },

    props: {
        place: {
            required: true,
            type: Object,
        }
    },

    data: () => ({
        details: '',
    }),

    mounted() {
        this.$root.$on(`details-change`, (value) => {
            this.details = value;
        });
    },

    methods: {
        submitForm() {
            if (this.submitted) {
                return;
            }

            if (this.details === '') {
                this.$root.$emit(`details-validate`);

                coeliac().error('Please enter the details before reporting the place!');

                return;
            }

            coeliac().request().post(`/api/wheretoeat/${this.place.id}/report`, {
                details: this.details
            }).then((response) => {
                if (response.status === 200) {
                    this.closeModal();

                    coeliac().success(`Thanks, we've received your report about ${this.place.name} and we'll check it out ASAP!!`);
                    return;
                }

                coeliac().error('Sorry, there was an error submitting your report, please try again.');
            }).catch(() => {
                coeliac().error('Sorry, there was an error submitting your report, please try again.');
            });
        },

        closeModal() {
            this.$root.$emit('close-modal', 'report-place');
        }
    },
}
</script>
