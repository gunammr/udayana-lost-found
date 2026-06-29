import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {

            colors: {

                primary: '#00459C',
                'primary-hover': '#295BB2',
                'primary-dark': '#0D1C2E',

                background: '#F8F9FF',

                'soft-blue': '#CFDCFF',

                footer: '#D5E3FC',

                warning: '#FFD967',
                'warning-dark': '#765E00',

                danger: '#93000A',
                'danger-soft': '#FFDAD6',

                body: '#434752',

            },

            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },

            borderRadius: {
                xl: '16px',
                '2xl': '20px',
            },

            boxShadow: {
                card: '0 10px 35px rgba(0,0,0,.06)',
            },

        },
    },

    plugins: [forms],
};