<template>
    <div class="flex flex-col leading-none">
        <div class="py-1">
            <form-input required placeholder="Your Name" name="name" :value="formData.name"></form-input>
        </div>

        <div class="py-1">
            <form-input required type="email" placeholder="Your Email" name="email"
                        :value="formData.email"></form-input>
        </div>

        <div class="py-1">
            <form-input required type="email" placeholder="Confirm your Email" name="emailConfirmation"
                        :value="formData.emailConfirmation" :match="formData.email"></form-input>
        </div>

        <div class="py-1">
            <form-input type="tel" placeholder="Your Phone Number (Optional)" name="phone"
                        :value="formData.phone" :pattern="/[0-9\-+ ]+/"></form-input>
        </div>

        <div class="py-1 text-right">
            <button class="py-3 px-6 rounded-lg font-semibold"
                    :class="isDisabled ? 'bg-yellow-50 cursor-not-allowed' : 'bg-yellow'" :disabled="isDisabled"
                    @click="submitForm('user-details')">
                Next...
            </button>
        </div>
    </div>
</template>

<script>
    import CheckoutComponent from "@/Mixins/CheckoutComponent";

    export default {
        mixins: [CheckoutComponent],

        data: () => ({
            formData: {
                name: '',
                email: '',
                emailConfirmation: '',
                phone: '',
            },

            validity: {
                name: false,
                email: false,
                emailConfirmation: false,
                phone: true,
            }
        }),
    }
</script>
