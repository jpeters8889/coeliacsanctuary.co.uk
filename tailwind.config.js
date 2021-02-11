const colours = {
    transparent: 'transparent',
    blue: {
        default: '#80CCFC',
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
        default: '#DBBC25',
        '40': 'rgba(219,188,37,0.4)',
        '50': 'rgba(219,188,37,0.5)',
        '80': 'rgba(219,188,37,0.8)',
    },
    gold: '#ffd700',
    green: '#0f0',
    red: {
        default: '#f00',
        dark: '#E53E3E',
        '20': 'rgba(255,0,0,0.2)',
    },
    black: {
        default: '#000',
        '80': 'rgba(0,0,0,0.8)',
        '50': 'rgba(0,0,0,0.5)',
    },
    grey: {
        default: '#666',
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
        default: '#fff',
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
};

const widths = {
    '1/2': '50%',
    '1/3': '33.333333%',
    '2/3': '66.666667%',
    '1/4': '25%',
    '2/4': '50%',
    '3/4': '75%',
    '1/5': '20%',
    '2/5': '40%',
    '3/5': '60%',
    '4/5': '80%',
    '1/6': '16.666667%',
    '2/6': '33.333333%',
    '3/6': '50%',
    '4/6': '66.666667%',
    '5/6': '83.333333%',
    '1/7': '14.285%',
    '1/12': '8.333333%',
    '2/12': '16.666667%',
    '3/12': '25%',
    '4/12': '33.333333%',
    '5/12': '41.666667%',
    '6/12': '50%',
    '7/12': '58.333333%',
    '8/12': '66.666667%',
    '9/12': '75%',
    '10/12': '83.333333%',
    '11/12': '91.666667%',
    '98': '98%',
    full: '100%',
    screen: '100vw',
};

const spacing = {
    px: '1px',
    '2px': '2px',
    '5px': '5px',
    '115px': '115px',
    '0': '0',
    '1': '0.25rem',
    '2': '0.5rem',
    '3': '0.75rem',
    '4': '1rem',
    '5': '1.25rem',
    '6': '1.5rem',
    '8': '2rem',
    '10': '2.5rem',
    '12': '3rem',
    '16': '4rem',
    '20': '5rem',
    '24': '6rem',
    '32': '8rem',
    '40': '10rem',
    '48': '12rem',
    '56': '14rem',
    '64': '16rem',
};

module.exports = {
    purge: [
        './resources/**/*.*'
    ],
    target: 'relaxed',
    prefix: '',
    important: false,
    separator: ':',
    theme: {
        screens: {
            xxs: '400px',
            xs: '500px',
            sm: '600px',
            md: '750px',
            lg: '900px',
            xl: '1200px',
            '2xl': '1500px',
        },
        colors: colours,
        spacing: spacing,
        backgroundColor: colours,
        backgroundPosition: {
            bottom: 'bottom',
            center: 'center',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        backgroundSize: {
            auto: 'auto',
            cover: 'cover',
            contain: 'contain',
        },
        borderColor: colours,
        borderRadius: {
            none: '0',
            sm: '0.125rem',
            default: '0.25rem',
            lg: '0.5rem',
            full: '9999px',
        },
        borderWidth: {
            default: '1px',
            '0': '0',
            '2': '2px',
            '4': '4px',
            '8': '8px',
        },
        boxShadow: {
            default: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
            md: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            xl: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
            inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
            outline: '0 0 0 3px rgba(66, 153, 225, 0.5)',
            none: 'none',
            'basket-sidebar': '0 0 5px 5px rgba(0,0,0,0.25)',
        },
        cursor: {
            auto: 'auto',
            default: 'default',
            pointer: 'pointer',
            wait: 'wait',
            text: 'text',
            move: 'move',
            'not-allowed': 'not-allowed',
        },
        fill: {
            current: 'currentColor',
        },
        flex: {
            '1': '1 1 0%',
            auto: '1 1 auto',
            initial: '0 1 auto',
            none: 'none',
        },
        flexGrow: {
            '0': '0',
            default: '1',
        },
        flexShrink: {
            '0': '0',
            default: '1',
        },
        fontFamily: {
            sans: ['Raleway', 'ui-sans-serif',
                'system-ui',
                '-apple-system',
                'BlinkMacSystemFont',
                '"Segoe UI"',
                'Roboto',
                '"Helvetica Neue"',
                'Arial',
                '"Noto Sans"',
                'sans-serif',
                '"Apple Color Emoji"',
                '"Segoe UI Emoji"',
                '"Segoe UI Symbol"',
                '"Noto Color Emoji"',],
            coeliac: ['Note This', 'ui-sans-serif',
                'system-ui',
                '-apple-system',
                'BlinkMacSystemFont',
                '"Segoe UI"',
                'Roboto',
                '"Helvetica Neue"',
                'Arial',
                '"Noto Sans"',
                'sans-serif',
                '"Apple Color Emoji"',
                '"Segoe UI Emoji"',
                '"Segoe UI Symbol"',
                '"Noto Color Emoji"',],
        },
        fontSize: {
            xxs: '0.6rem',
            xs: '0.75rem',
            sm: '0.875rem',
            base: '1rem',
            lg: '1.125rem',
            xl: '1.25rem',
            '2xl': '1.5rem',
            '3xl': '1.875rem',
            '4xl': '2.25rem',
            '5xl': '3rem',
            '6xl': '4rem',
        },
        fontWeight: {
            // hairline: '100',
            thin: '200',
            // light: '300',
            normal: '400',
            medium: '500',
            semibold: '600',
            bold: '700',
            // extrabold: '800',
            // black: '900',
        },
        height: {
            auto: 'auto',
            ...spacing,
            full: '100%',
            screen: '100vh',
            '200': '200px',
            '400': '400px',
            '600': '600px',
            '800': '800px',
            '3/4': '75%',

            '95vh': '95vh',
            '80vh': '80vh',
        },
        inset: {
            '0': '0',
            1: '0.5rem',
            '50px': '50px',
            '130px': '130px',
            auto: 'auto',
        },
        letterSpacing: {
            tighter: '-0.05em',
            tight: '-0.025em',
            normal: '0',
            wide: '0.025em',
            wider: '0.05em',
            widest: '0.1em',
        },
        lineHeight: {
            none: '1',
            tight: '1.25',
            snug: '1.375',
            normal: '1.5',
            relaxed: '1.625',
            loose: '2',
        },
        listStyleType: {
            none: 'none',
            disc: 'disc',
            decimal: 'decimal',
        },
        margin: (theme, {negative}) => ({
            auto: 'auto',
            ...spacing,
            ...negative(spacing),
        }),
        maxHeight: {
            full: '100%',
            '3/4': '75%',
            map: '300px',
            screen: '100vh',
            search: '22.5rem',
            hero: '750px',
            logo: '125px',
        },
        maxWidth: {
            ...widths,
            xs: '20rem',
            sm: '24rem',
            md: '28rem',
            lg: '32rem',
            xl: '36rem',
            '2xl': '42rem',
            '3xl': '48rem',
            '4xl': '56rem',
            '5xl': '64rem',
            '6xl': '72rem',
            full: '100%',
            'modal-small': '700px',
            'modal': '1000px',
            'recipe-feature': '60px',
            'basket-sidebar': '400px',
        },
        minHeight: {
            '0': '0',
            map: '300px',
            'map-small': '200px',
            full: '100%',
            screen: '100vh',
        },
        minWidth: {
            '0': '0',
            full: '100%',
        },
        objectPosition: {
            bottom: 'bottom',
            center: 'center',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        opacity: {
            '0': '0',
            '10': '0.1',
            '20': '0.2',
            '25': '0.25',
            '50': '0.5',
            '75': '0.75',
            '100': '1',
        },
        order: {
            first: '-9999',
            last: '9999',
            none: '0',
            '1': '1',
            '2': '2',
            '3': '3',
            '4': '4',
            '5': '5',
            '6': '6',
            '7': '7',
            '8': '8',
            '9': '9',
            '10': '10',
            '11': '11',
            '12': '12',
        },
        padding: spacing,
        placeholderColor: colours,
        stroke: {
            current: 'currentColor',
        },
        textColor: colours,
        width: {
            auto: 'auto',
            ...spacing,
            ...widths
        },
        zIndex: {
            auto: 'auto',
            '0': '0',
            '10': '10',
            '20': '20',
            '30': '30',
            '40': '40',
            '50': '50',
            'max': '999',
        },
    },
    variants: {
        accessibility: ['responsive', 'focus'],
        alignContent: ['responsive'],
        alignItems: ['responsive'],
        alignSelf: ['responsive'],
        appearance: ['responsive'],
        backgroundAttachment: ['responsive'],
        backgroundColor: ['responsive', 'hover', 'focus'],
        backgroundPosition: ['responsive'],
        backgroundRepeat: ['responsive'],
        backgroundSize: ['responsive'],
        borderCollapse: ['responsive'],
        borderColor: ['responsive', 'hover', 'focus'],
        borderRadius: ['responsive'],
        borderStyle: ['responsive'],
        borderWidth: ['responsive', 'hover', 'last'],
        boxShadow: ['responsive', 'hover', 'focus'],
        cursor: ['responsive'],
        display: ['responsive'],
        fill: ['responsive'],
        flex: ['responsive'],
        flexDirection: ['responsive'],
        flexGrow: ['responsive'],
        flexShrink: ['responsive'],
        flexWrap: ['responsive'],
        float: ['responsive'],
        fontFamily: ['responsive'],
        fontSize: ['responsive'],
        fontSmoothing: ['responsive'],
        fontStyle: ['responsive'],
        fontWeight: ['responsive', 'hover', 'focus'],
        height: ['responsive'],
        inset: ['responsive'],
        justifyContent: ['responsive'],
        letterSpacing: ['responsive'],
        lineHeight: ['responsive'],
        listStylePosition: ['responsive'],
        listStyleType: ['responsive'],
        margin: ['responsive'],
        maxHeight: ['responsive'],
        maxWidth: ['responsive'],
        minHeight: ['responsive'],
        minWidth: ['responsive'],
        objectFit: ['responsive'],
        objectPosition: ['responsive'],
        opacity: ['responsive', 'hover', 'focus'],
        order: ['responsive'],
        outline: ['responsive', 'focus'],
        overflow: ['responsive'],
        padding: ['responsive', 'last'],
        placeholderColor: ['responsive', 'focus'],
        pointerEvents: ['responsive'],
        position: ['responsive'],
        resize: ['responsive'],
        stroke: ['responsive'],
        tableLayout: ['responsive'],
        textAlign: ['responsive'],
        textColor: ['responsive', 'hover', 'focus'],
        textDecoration: ['responsive', 'hover', 'focus'],
        textTransform: ['responsive'],
        userSelect: ['responsive'],
        verticalAlign: ['responsive'],
        visibility: ['responsive'],
        whitespace: ['responsive'],
        width: ['responsive'],
        wordBreak: ['responsive'],
        zIndex: ['responsive'],
    },
    corePlugins: {},
    plugins: [],
};
