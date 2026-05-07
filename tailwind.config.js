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
                midnight: {
                    950: '#020617',
                    900: '#0f172a',
                    800: '#1e293b',
                    700: '#334155',
                },
                deepMidnight: '#1a1d29',
                sunrise: {
                    orange: '#FF6B35',
                    yellow: '#FFD93D',
                    300: '#FF6B35',
                    400: '#FF8C42',
                    500: '#FFD93D',
                },
            },
            backgroundImage: {
                'deep-midnight': 'linear-gradient(180deg, #020617 0%, #0f172a 100%)',
                'sunrise-gradient': 'linear-gradient(135deg, #FF6B35 0%, #FFD93D 100%)',
                'midnight-sunrise': 'linear-gradient(to bottom right, #020617, #0f172a, #1e3a5f)',
            },
        },
    },

    plugins: [forms],
};
