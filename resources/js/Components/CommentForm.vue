<template>
    <div class="page-box p-3 mt-3">
        <h2 class="text-2xl my-2 font-semibold font-coeliac">Submit a Comment</h2>

        <p>Want to leave a comment on this {{ area }}? Feel free to join the discussion!</p>

        <div class="flex mt-2 flex-col">
            <div class="mb-5 flex-1">
                <form-input required name="name" :value="formData.name" placeholder="Your name..."></form-input>
            </div>
            <div class="mb-5 flex-1">
                <form-input required name="email" type="email" :value="formData.email"
                            placeholder="Your email..."></form-input>
            </div>
            <div class="mb-5 flex-1">
                <form-textarea required name="comment" :value="formData.comment" :rows="10"
                               placeholder="Your comment..."></form-textarea>
            </div>
        </div>

        <p class="-mt-2 text-sm italic">
            Note, your email address will never be displayed with your comment, it is only
            required to alert you when your comment has been approved or if the Coeliac Sanctuary team reply to your
            comment.
        </p>

        <button
            class="mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20"
            @click.prevent="submitForm()">
            Submit Comment
        </button>
    </div>
</template>

<script>
import FormInput from "./Forms/FormInput";
import FormTextarea from "./Forms/FormTextarea";

export default {
    components: {
        'form-input': FormInput,
        'form-textarea': FormTextarea,
    },

    props: {
        area: {
            type: String,
            required: true,
        },
        id: {
            type: Number,
            required: true,
        }
    },

    data: () => ({
        formData: {
            name: '',
            email: '',
            comment: '',
        },

        validity: {
            name: false,
            email: false,
            comment: false,
        }
    }),

    mounted() {
        Object.keys(this.validity).forEach((key) => {
            this.$root.$on(`${key}-error`, () => {
                this.validity[key] = false;
            });

            this.$root.$on(`${key}-valid`, () => {
                this.validity[key] = true;
            });

            this.$root.$on(`${key}-value`, (value) => {
                this.formData[key] = value;
            });
        });
    },

    methods: {
        submitForm() {
            if (this.validateForm()) {
                coeliac().request().post('/api/comments', {
                    area: this.area,
                    id: this.id,
                    ...this.formData,
                }).then((response) => {
                    if (response.status === 200) {
                        Object.keys(this.validity).forEach((key) => {
                            this.formData[key] = '';
                            this.$root.$emit(`${key}-reset`);
                        });

                        coeliac().success('Thanks, your comment has been submitted and is awaiting approval!');
                        return;
                    }

                    coeliac().error('Sorry, there was an error submitting your comment, please try again.');
                });
            }
        },

        validateForm() {
            Object.keys(this.validity).forEach((key) => {
                this.$root.$emit(`${key}-get-value`)
            });

            let isValid = true;

            Object.keys(this.validity).forEach((key) => {
                if (this.validity[key] === false) {
                    isValid = false;
                }
            });

            return isValid;
        }
    }
}
</script>
