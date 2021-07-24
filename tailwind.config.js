module.exports = {
    purge: [
        './resources/**/*.*'
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            blue: {
                DEFAULT: '#80CCFC',
                '80': 'rgba(128,204,252,0.8)',
                '50': 'rgba(128,204,252,0.5)',
                '20': 'rgba(128,204,252,0.2)',
                light: '#addaf9',
                'light-80': 'rgba(173,218,249,0.8)',
                'light-50': 'rgba(173,218,249,0.5)',
                'light-40': 'rgba(173,218,249,0.4)',
                'light-20': 'rgba(173,218,249,0.2)',
                lightest: '#eleef7',
                dark: '#29719f',
                darkest: '#237cbd',
                other: '#186ba3',
                shopping: '#f4f9fd',
            },
            yellow: {
                light: '#ecd14a',
                DEFAULT: '#DBBC25',
                '40': 'rgba(219,188,37,0.4)',
                '50': 'rgba(219,188,37,0.5)',
                '80': 'rgba(219,188,37,0.8)',
            },
            gold: '#ffd700',
            green: '#0f0',
            red: {
                DEFAULT: '#f00',
                light: '#ff6060',
                dark: '#E53E3E',
                '20': 'rgba(255,0,0,0.2)',
            },
            black: {
                DEFAULT: '#000',
                '80': 'rgba(0,0,0,0.8)',
                '50': 'rgba(0,0,0,0.5)',
                '20': 'rgba(0,0,0,0.2)',
            },
            grey: {
                DEFAULT: '#666',
                light: '#f7f7f7',
                lightest: '#fbfbfb',
                dark: '#787878',
                darker: '#595959',
                darkest: '#222',
                off: '#ccc',
                'off-light': '#e8e8e8',
                'off-dark': '#bbb',
            },
            white: {
                DEFAULT: '#fff',
                '80': 'rgba(255,255,255,0.8)',
                '50': 'rgba(255,255,255,0.5)',
                '20': 'rgba(255,255,255,0.2)',
            },

            social: {
                facebook: '#3b5998',
                'facebook-light': 'rgba(59,89,152, 0.5)',
                twitter: '#00aced',
                'twitter-light': 'rgba(0,172,237, 0.5)',
                pinterest: '#bd081c',
                reddit: '#ff4500',
                rss: '#f26522',
            }
        },
        screens: {
            xxs: '400px',
            xs: '500px',
            sm: '600px',
            md: '750px',
            lg: '900px',
            xl: '1200px',
            '2xl': '1500px',
        },
        fontFamily: {
            sans: ['Raleway', 'ui-sans-serif'],
            coeliac: ['Note This', 'ui-sans-serif'],
        },
        extend: {
            spacing: {
                '2px': '2px',
                '5px': '5px',
                '115px': '115px',
            },
            width: {
                '98': '98%',
            },
            boxShadow: {
                DEFAULT: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                'basket-sidebar': '0 0 5px 5px rgba(0,0,0,0.25)',
            },
            fontSize: {
                xxs: '0.6rem',
            },
            height: {
                '200': '200px',
                '400': '400px',
                '600': '600px',
                '800': '800px',
                '3/4': '75%',
                '95vh': '95vh',
                '80vh': '80vh',
            },
            inset: {
                1: '0.5rem',
                '50px': '50px',
                '130px': '130px',
            },
            maxHeight: {
                '3/4': '75%',
                map: '300px',
                search: '22.5rem',
                hero: '750px',
                logo: '125px'
            },
            maxWidth: {
                '250': '250px',
                'modal-small': '700px',
                'modal': '1000px',
                'recipe-feature': '60px',
                'basket-sidebar': '400px',
            },
            minHeight: {
                map: '300px',
                'map-small': '200px',
            },
            zIndex: {
                max: '999',
            }
        },
    },
    variants: {
        extend: {
            fontWeight: ['hover']
        }
    },
    plugins: [],
}
