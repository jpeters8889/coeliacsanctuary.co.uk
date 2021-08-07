export default {
    methods: {
        currentSize() {
            let currentSize = '';

            Object.keys(this.breakpoints).forEach((breakpoint) => {
                if (window.innerWidth >= this.breakpoints[breakpoint].from && window.innerWidth < this.breakpoints[breakpoint].to) {
                    currentSize = breakpoint;
                }
            });

            return currentSize
        },

        isLte(breakpoint) {
            if (!Object.keys(this.breakpoints).includes(breakpoint)) {
                return true;
            }

            return window.innerWidth <= this.breakpoints[breakpoint].from;
        },

        isLt(breakpoint) {
            if (!Object.keys(this.breakpoints).includes(breakpoint)) {
                return true;
            }

            return window.innerWidth < this.breakpoints[breakpoint].from;
        },

        is(breakpoint) {
            if (!Object.keys(this.breakpoints).includes(breakpoint)) {
                return true;
            }

            const sizes = this.breakpoints[breakpoint];

            return window.innerWidth >= sizes.from && window.innerWidth < sizes.to;
        },

        isGt(breakpoint) {
            if (!Object.keys(this.breakpoints).includes(breakpoint)) {
                return true;
            }

            return window.innerWidth > this.breakpoints[breakpoint].from;
        },

        isGte(breakpoint) {
            if (!Object.keys(this.breakpoints).includes(breakpoint)) {
                return true;
            }

            return window.innerWidth >= this.breakpoints[breakpoint].from;
        },
    },

    computed: {
        breakpoints() {
            return {
                xxs: {
                    from: 0,
                    to: 499,
                },
                xs: {
                    from: 500,
                    to: 599,
                },
                sm: {
                    from: 600,
                    to: 749,
                },
                md: {
                    from: 750,
                    to: 899,
                },
                lg: {
                    from: 900,
                    to: 1199,
                },
                xl: {
                    from: 1200,
                    to: 1499,
                },
                '2xl': {
                    from: 1500,
                    to: 99999
                },
            };
        },
    }
}
