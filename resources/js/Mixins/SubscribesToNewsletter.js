export default {
    data: () => ({
        email: ''
    }),

    methods: {
        submit() {
            if (this.email === '') {
                coeliac().error('Please enter your email address');
                return;
            }

            coeliac().request().post('/api/newsletter', {
                email: this.email,
                url: window.location.href,
            }).then((response) => {
                if (response.status === 200) {
                    this.email = '';

                    coeliac().success('Thanks for subscribing to our newsletter!');
                    return;
                }

                if (response.status === 409) {
                    coeliac().error('You\'re already subscribed to our newsletter!');
                    return;
                }

                coeliac().error('There was an error subscribing you to our newsletter, please try again...');
            }).catch(() => {
                coeliac().error('There was an error subscribing you to our newsletter, please try again...');
            });
        }
    }
}
