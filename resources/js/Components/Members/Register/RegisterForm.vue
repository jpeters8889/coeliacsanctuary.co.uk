<template>
  <div class="flex justify-center items-center">
    <form
      v-if="!alreadyHasAccount"
      class="rounded-lg p-4 flex flex-col space-y-4 w-full max-w-lg"
      @submit.prevent="submitRegistration"
    >
      <div
        class="mx-auto"
        style="width: 50px;"
      >
        <global-layout-coeliac-icon colour="#80CCFC" />
      </div>

      <p>
        Register an account on Coeliac Sanctuary today and get access to our member dashboard where you can
        create lists of your favourite recipes and blogs, subscribe to get notified when we add places to eat
        near you, view your order history in our shop, plus much more!
      </p>

      <form-input
        type="text"
        required
        name="name"
        label="Your Name"
        :value="fields.name"
        autocomple="name"
      />

      <form-input
        type="email"
        required
        name="email"
        label="Email Address"
        :value="fields.email"
        autocomple="email"
      />

      <form-input
        type="password"
        required
        name="password"
        label="Password"
        :value="fields.password"
        autocomplete="password"
      />

      <form-input
        type="password"
        required
        name="password_confirmation"
        label="Confirm your password"
        :match="fields.password"
        :value="fields.password_confirmation"
        autocomplete="password_confirmation"
      />

      <form-checkbox
        required
        name="terms"
        input-size="text-base"
        label="I accept the <a href='/terms-of-use' target='_blank' class='font-semibold text-blue-dark hover:text-black'>Terms and Conditions</a>"
        :value="fields.terms"
      />

      <button
        class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center"
        style="height: 42px;"
        :class="isSubmitting ? 'py-2' : 'py-3'"
        :disabled="isSubmitting"
        @click.prevent="submitRegistration"
      >
        <loader
          v-if="isSubmitting"
          background-position=""
          :show="true"
          height="25px"
          width="25px"
          border-width="3px"
          faded-border-color="border-white border-opacity-50"
          primary-border-color="white"
        />
        <span v-else>Join now!</span>
      </button>

      <div class="flex justify-end text-xs mt-2 font-semibold">
        <a
          class="text-blue hover:text-grey"
          href="/member/forgot-password"
        >Forgotten Password?</a>
      </div>
    </form>
    <div
      v-else
      class="rounded-lg border border-blue p-4 flex flex-col space-y-4 w-full max-w-basket-sidebar bg-grey-lightest text-lg text-center"
    >
      <p>
        Your email {{ fields.email }} is already associated with an account!
      </p>
      <p class="mt-2">
        <member-login-trigger
          class="text-blue cursor-pointer text-semibold hover:text-blue-dark transition-all"
        >
          Login now!
        </member-login-trigger>
      </p>
    </div>
  </div>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "prefetch-form-input" */);
const FormCheckbox = () => import('~/Forms/Checkbox' /* webpackChunkName: "prefetch-form-checkbox" */);
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);

export default {
  components: {
    'form-input': FormInput,
    'form-checkbox': FormCheckbox,
    loader: Loader,
  },

  data: () => ({
    isSubmitting: false,
    alreadyHasAccount: false,

    fields: {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      terms: false,
    },

    validity: {
      name: false,
      email: false,
      password: false,
      password_confirmation: false,
      terms: false,
    },

    errors: {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      generic: '',
    },
  }),

  mounted() {
    Object.keys(this.fields).forEach((field) => {
      this.$root.$on(`${field}-error`, () => {
        this.validity[field] = false;
      });

      this.$root.$on(`${field}-valid`, () => {
        this.validity[field] = true;
      });

      this.$root.$on(`${field}-value`, (value) => {
        this.fields[field] = value;
      });
    });

    this.$root.$on('terms-change', (value) => {
      this.fields.terms = value;
      this.validity.terms = value;
    });
  },

  methods: {
    submitRegistration() {
      if (!this.validateForm()) {
        coeliac().error('Please complete all fields!');
        return;
      }

      this.isSubmitting = true;

      coeliac().request().post('/api/member/register', this.fields)
        .then(() => {
          window.location = '/member/dashboard';
        })
        .catch((err) => {
          if (err.response.status === 422 && err.response.data.errors.email && err.response.data.errors.email[0] === 'Your email is already associated with an account!') {
            this.alreadyHasAccount = true;
            return;
          }

          coeliac().error('Please correct any errors before continuing!');

          this.fields.password = '';
          this.validity.password = false;
          this.fields.password_confirmation = '';
          this.validity.password_confirmation = false;
          this.fields.terms = false;
          this.validity.terms = false;

          this.$root.$emit('password-set-value', (''));
          this.$root.$emit('password_confirmation-set-value', (''));
          this.$root.$emit('terms-set-value', false);
        })
        .finally(() => {
          this.isSubmitting = false;
        });
    },

    validateForm() {
      Object.keys(this.validity).forEach((key) => {
        this.$root.$emit(`${key}-get-value`);
      });

      let isValid = true;

      Object.keys(this.validity).forEach((key) => {
        if (this.validity[key] === false) {
          isValid = false;
        }
      });

      return isValid;
    },
  },
};
</script>
