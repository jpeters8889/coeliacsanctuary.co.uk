<template>
  <div class="flex flex-col leading-none space-y-3">
    <h3 class="text-xl font-semibold">
      Your Details
    </h3>

    <p class="leading-normal">
      To start the checkout process we just need some basic details from you including your name, the email
      address for your order confirmation, and optionally, a telephone number.
    </p>

    <form-input
      required
      label="Your Name"
      name="name"
      :value="formData.name"
      border-class="border-grey-off"
    />

    <form-input
      required
      type="email"
      label="Your Email"
      name="email"
      border-class="border-grey-off"
      :value="formData.email"
    />

    <form-input
      required
      type="email"
      label="Confirm your Email"
      name="emailConfirmation"
      border-class="border-grey-off"
      :value="formData.emailConfirmation"
      :match="formData.email"
    />

    <form-input
      type="tel"
      label="Your Phone Number"
      name="phone"
      border-class="border-grey-off"
      :value="formData.phone"
      :pattern="/[0-9\-+ ]+/"
    />

    <button
      class="py-3 px-6 rounded-lg font-semibold"
      :class="isDisabled ? 'bg-blue bg-opacity-50 cursor-not-allowed' : 'bg-blue'"
      :disabled="isDisabled"
      @click="submitForm('user-details')"
    >
      Next...
    </button>
  </div>
</template>

<script>
import CheckoutComponent from '@/Mixins/CheckoutComponent';

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
    },
  }),
};
</script>
