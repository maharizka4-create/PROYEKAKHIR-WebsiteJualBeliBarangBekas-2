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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                coklat: {
                    50:  '#faf6f1',
                    100: '#f1e7da',
                    200: '#e2cdb2',
                    300: '#cfae86',
                    400: '#bc8d5e',
                    500: '#a8733f',
                    600: '#8f5c33',
                    700: '#744729',
                    800: '#5f3b26',
                    900: '#4e3222',
                    950: '#2b1a11',
                },
            },
        },
    },

    plugins: [forms],
};