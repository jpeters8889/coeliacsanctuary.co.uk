<template>
  <div class="js-contact-form p-3">
    <div class="flex mt-2 flex-col space-y-5">
      <p>
        Need to get in touch with the Coeliac Sanctuary team? Complete this form and we'll get back to you as
        soon as we can!
      </p>

      <p>
        Before you complete this form why not check our frequently asked questions, your question may have
        already been answered!
      </p>

      <p>
        Are you suggesting a location to add to our Eating Out guide? Please use our
        <a
          href="/wheretoeat/recommend-a-place"
          class="font-semibold text-blue-dark hover:text-black"
        >recommend a place</a> form instead.
      </p>

      <form-input
        required
        name="name"
        :value="formData.name"
        label="Name"
      />

      <form-input
        required
        name="email"
        type="email"
        :value="formData.email"
        label="Email Address"
      />

      <form-input
        required
        name="subject"
        :value="formData.subject"
        label="Subject"
      />

      <form-textarea
        required
        name="message"
        :value="formData.message"
        :rows="10"
        label="Message"
      />

      <button
        class="-mt-3 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20"
        @click.prevent="submitForm()"
      >
        Send Message
      </button>
    </div>
  </div>
</template>

<script>
import InteractsWithUser from '@/Mixins/InteractsWithUser';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */);

export default {

  components: {
    'form-input': FormInput,
    'form-textarea': FormTextarea,
  },
  mixins: [InteractsWithUser],

  data: () => ({
    formData: {
      name: '',
      subject: '',
      email: '',
      message: '',
    },

    validity: {
      name: false,
      subject: false,
      email: false,
      message: false,
    },
  }),

  mounted() {
    if (this.isLoggedIn()) {
      this.formData.name = window.config.user.name;
      this.formData.email = window.config.user.email;
    }

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
        coeliac().request().post('/api/contact', this.formData)
          .then((response) => {
            if (response.status === 200) {
              Object.keys(this.validity).forEach((key) => {
                this.formData[key] = '';
                this.$root.$emit(`${key}-reset`);
              });

              coeliac().success('Thanks, your message has been sent!');
              return;
            }

            coeliac().error('Sorry, there was an error submitting your message, please try again.');
          })
          .catch(() => {
            coeliac().error('Sorry, there was an error submitting your message, please try again.');
          });
      }
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
