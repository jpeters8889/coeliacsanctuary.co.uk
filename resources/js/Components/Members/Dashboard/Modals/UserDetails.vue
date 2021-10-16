<template>
  <div class="flex flex-col">
    <intro-form
      :name="name"
      :email="email"
      :phone="phone"
    />
    <address-details />
    <password-form />
  </div>
</template>

<script>
import DashboardUserDetailsIntroForm from '~/Members/Dashboard/UserDetails/IntroForm';
import DashboardUserDetailsPasswordForm from '~/Members/Dashboard/UserDetails/PasswordForm';
import DashboardUserDetailsAddressDetails from '~/Members/Dashboard/UserDetails/AddressDetails';

export default {
  components: {
    'intro-form': DashboardUserDetailsIntroForm,
    'address-details': DashboardUserDetailsAddressDetails,
    'password-form': DashboardUserDetailsPasswordForm,
  },

  props: {
    name: {
      required: true,
      type: String,
    },
    email: {
      required: true,
      type: String,
    },
    phone: {
      required: false,
      type: String,
      default: '',
    },
  },
};
</script>
