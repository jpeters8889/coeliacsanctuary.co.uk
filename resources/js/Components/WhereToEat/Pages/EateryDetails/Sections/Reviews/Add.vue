<template>
  <div class="page-box flex flex-col space-y-3">
    <p>
      Have you visited <strong>{{ name }}</strong>? How would you rate your experience from 1 to 5 stars?
    </p>

    <form-step
      name="rating"
      :value="form.rating"
      :options="stars"
      :icon="['fas', 'star']"
      :unselected-icon="null"
      hide-option-text
    />

    <template v-if="form.rating">
      <p>
        You're about to give a <strong>{{ form.rating }} star</strong> rating to <strong>{{ name }}</strong>.
      </p>

      <p v-if="!showReviewForm">
        Do you want to also write a short review about your experience at <strong>{{ name }}</strong>, or
        just submit your <strong>{{ form.rating }} star</strong> rating?
      </p>

      <div
        v-if="!showReviewForm"
        class="flex flex-col space-y-2 sm:flex-row sm:justify-between sm:space-y-0 lg:justify-start lg:space-x-3"
      >
        <button
          class="bg-blue rounded p-3 border border-blue hover:bg-opacity-50 transition-all font-semibold"
          @click.prevent="submitRating()"
        >
          No, just save my rating
        </button>

        <button
          class="bg-yellow rounded p-3 border border-yellow hover:bg-opacity-50 transition-all font-semibold"
          @click.prevent="showReviewForm = true"
        >
          Yes, I want to leave a review
        </button>
      </div>

      <div
        v-if="showReviewForm"
        class="flex flex-col space-y-4"
      >
        <div class="flex-1">
          <form-input
            required
            name="name"
            :value="form.name"
            label="Your Name"
          />
        </div>
        <div class="flex-1">
          <form-input
            required
            name="email"
            type="email"
            :value="form.email"
            label="Your Email"
          />
        </div>
        <div class="flex-1">
          <form-step
            name="food"
            label="How would you rate your food?"
            :value="form.food"
            :options="ratings"
            icon-classes="px-1"
          />
        </div>
        <div class="flex-1">
          <form-step
            name="service"
            label="How would you rate the service?"
            :value="form.service"
            :options="ratings"
            icon-classes="px-1"
          />
        </div>
        <div class="flex-1">
          <form-step
            name="expense"
            label="How expensive is it to eat here?"
            :value="form.expense"
            :options="howExpensiveValues"
            :icon="['fas', 'pound-sign']"
            :unselected-icon="null"
            icon-classes="px-1"
          />
        </div>
        <div class="flex-1">
          <form-textarea
            required
            name="comment"
            :value="form.comment"
            :rows="5"
            :max="500"
            label="Your Comment"
          />
          <span
            class="text-xs text-right"
            :class="characterLimit === usedCharacters ? 'text-red font-semibold' : ''"
          >
            {{ usedCharacters }} / {{ characterLimit }}
          </span>
        </div>
        <div class="flex-1 text-center">
          <button
            class="mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20"
            @click.prevent="submitRating()"
          >
            Submit Review
          </button>
        </div>

        <p class="text-sm">
          We require your email in case we need to contact you about your comment, your email address is NEVER
          displayed publicly with your comment.
        </p>

        <p class="text-sm">
          All comments need to be approved before they are shown on the website, this usually takes no longer than
          48 hours.
        </p>
      </div>

      <div v-if="submittedReviewForm">
        <p>
          Thank you for leaving your <strong>{{ form.rating }} star</strong> rating
          {{ showReviewForm ? 'and review' : '' }} of <strong>{{ name }}</strong>!
        </p>
      </div>
    </template>
  </div>
</template>

<script>
import InteractsWithUser from '@/Mixins/InteractsWithUser';
import HasWhereToEatPriceRange from '@/Mixins/HasWhereToEatHowExpensiveValues';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormStep = () => import('~/Forms/Step' /* webpackChunkName: "chunk-form-step" */);
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */);

export default {

  components: {
    'form-input': FormInput,
    'form-step': FormStep,
    'form-textarea': FormTextarea,
  },

  mixins: [InteractsWithUser, HasWhereToEatPriceRange],

  props: {
    id: {
      type: Number,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
  },

  data: () => ({
    hoveringOn: null,

    showReviewForm: false,

    submittedReviewForm: false,

    form: {
      rating: 0,
      name: '',
      email: '',
      food: '',
      service: '',
      expense: '',
      comment: '',
    },

    characterLimit: 1500,
  }),

  computed: {
    usedCharacters() {
      return this.form.comment.length;
    },

    formKeys() {
      return Object.keys(this.form);
    },

    stars() {
      return [
        { value: 1 },
        { value: 2 },
        { value: 3 },
        { value: 4 },
        { value: 5 },
      ];
    },

    ratings() {
      return [
        {
          value: 'poor',
          label: 'Poor',
        },
        {
          value: 'good',
          label: 'Good',
        },
        {
          value: 'excellent',
          label: 'Excellent',
        },
      ];
    },
  },

  destroyed() {
    this.showReviewForm = false;
    this.form.rating = null;
    this.form.name = '';
    this.form.email = '';
    this.form.food = '';
    this.form.service = '';
    this.form.expense = '';
    this.form.comment = '';

    this.submitRating();
  },

  mounted() {
    if (this.isLoggedIn()) {
      this.form.name = window.config.user.name;
      this.form.email = window.config.user.email;
    }

    this.formKeys.forEach((key) => {
      this.$root.$on(`${key}-change`, (value) => {
        this.form[key] = value;
      });
    });
  },

  methods: {
    submitRating() {
      if (this.submitted) {
        return;
      }

      if (!this.validateForm()) {
        coeliac().error('Please complete all form fields to submit a review!');

        return;
      }

      coeliac().request().post(`/api/wheretoeat/${this.id}/reviews`, {
        rating: this.form.rating,
        name: this.form.name !== '' ? this.form.name : null,
        email: this.form.email !== '' ? this.form.email : null,
        food: this.form.food !== '' ? this.form.food : null,
        service: this.form.service !== '' ? this.form.service : null,
        expense: this.form.expense !== '' ? parseInt(this.form.expense) : null,
        comment: this.form.comment !== '' ? this.form.comment : null,
      }).then((response) => {
        if (response.status === 200) {
          this.submitted = true;

          this.$root.$emit('rated-place', this.id);

          coeliac().success('Thanks, your rating has been submitted and is awaiting approval!');
          return;
        }

        coeliac().error('Sorry, there was an error submitting your rating, please try again.');
      })
        .catch(() => {
          coeliac().error('Sorry, there was an error submitting your rating, please try again.');
        });
    },

    validateForm() {
      if (!this.showReviewForm) {
        return true;
      }

      if (!this.form.rating) {
        return false;
      }

      const isValid = {
        name: false,
        email: false,
        comment: false,
      };

      this.formKeys.forEach((field) => {
        if (this.form[field] !== '') {
          isValid[field] = true;
        }
      });

      if (Object.values(isValid).indexOf(true) > -1 && Object.values(isValid).indexOf(false) > -1) {
        this.formKeys.forEach((field) => {
          this.$root.$emit(`${field}-validate`);
        });

        return false;
      }

      return true;
    },

    closeModal() {
      this.$root.$emit('close-modal', 'showCreate');
    },
  },
};
</script>
