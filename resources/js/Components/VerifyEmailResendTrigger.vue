<template>
    <div @click="resendEmail()" :class="classes">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: ['classes'],

    methods: {
        resendEmail() {
            coeliac().request().post('/api/member/verify-email')
            .then(() => {
                coeliac().success("We've just sent you another verification email, the link will expire in 60 minutes.");
            })
            .catch(() => {
                coeliac().error('There was an error resending your validation email, please try again.');
            })
        }
    }
}
</script>
