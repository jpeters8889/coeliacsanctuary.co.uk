<template>
  <div class="p-3">
    <div
      v-if="!submitted"
      class="flex flex-col"
    >
      <div class="flex flex-col">
        <div class="mb-5 flex-1">
          <form-input
            required
            name="name"
            :value="name"
            placeholder="Your name..."
          />
        </div>
        <div class="mb-5 flex-1">
          <form-input
            required
            name="email"
            type="email"
            :value="email"
            placeholder="Your email..."
          />
        </div>
        <div class="mb-5 flex-1">
          <form-textarea
            required
            name="comment"
            :value="comment"
            :rows="5"
            :max="500"
            placeholder="Your comment..."
          />
          <span class="text-xs">
            {{ usedCharacters }} / {{ characterLimit }}
          </span>
        </div>
        <div class="mb-5 flex-1 text-center">
          <button
            class="mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20"
            @click.prevent="submitRating()"
          >
            Submit Comment
          </button>
        </div>
      </div>

      <p class="mb-4">
        We require your email in case we need to contact you about your comment, your email address is NEVER
        displayed publicly with your comment.
      </p>

      <p>
        All comments need to be approved before they are shown on the website, this usually takes no longer than
        24 hours.
      </p>
    </div>

    <div v-else>
      <p>Thank you for rating this place!</p>
      <div class="mb-5 flex-1 text-center">
        <button
          class="mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20"
          @click.prevent="closeModal()"
        >
          Close
        </button>
      </div>
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

  props: {
    id: {
      type: Number,
      required: true,
    },
    rating: {
      type: Number,
      required: true,
    },
  },

  data: () => ({
    submitted: false,

    name: '',
    email: '',
    comment: '',
    characterLimit: 500,

    fields: [
      'name',
      'email',
      'comment',
    ],
  }),

  computed: {
    usedCharacters() {
      return this.comment.length;
    },
  },

  mounted() {
    if (this.isLoggedIn()) {
      this.name = window.config.user.name;
      this.email = window.config.user.email;
    }

    this.$root.$on('modal-closed', (modal) => {
      if (modal === 'showCreate') {
        this.name = '';
        this.email = '';
        this.comment = '';

        this.submitRating(false);
      }
    });

    this.fields.forEach((key) => {
      this.$root.$on(`${key}-change`, (value) => {
        this[key] = value;
      });
    });
  },

  methods: {
    submitRating() {
      if (this.submitted) {
        return;
      }

      const hasValue = {
        name: false,
        email: false,
        comment: false,
      };

      this.fields.forEach((field) => {
        if (this[field] !== '') {
          hasValue[field] = true;
        }
      });

      if (Object.values(hasValue).indexOf(true) > -1 && Object.values(hasValue).indexOf(false) > -1) {
        this.fields.forEach((field) => {
          this.$root.$emit(`${field}-validate`);
        });

        coeliac().error('Please complete all form fields to submit a review!');

        return;
      }

      coeliac().request().post(`/api/wheretoeat/${this.id}/reviews`, {
        rating: this.rating,
        name: this.name !== '' ? this.name : null,
        email: this.email !== '' ? this.email : null,
        comment: this.comment !== '' ? this.comment : null,
      }).then((response) => {
        if (response.status === 200) {
          this.submitted = true;

          this.$root.$emit('rated-place', this.id);

          coeliac().success('Thanks, your comment has been submitted and is awaiting approval!');
          return;
        }

        coeliac().error('Sorry, there was an error submitting your comment, please try again.');
      })
        .catch(() => {
          coeliac().error('Sorry, there was an error submitting your comment, please try again.');
        });
    },

    closeModal() {
      this.$root.$emit('close-modal', 'showCreate');
    },
  },
};
</script>
