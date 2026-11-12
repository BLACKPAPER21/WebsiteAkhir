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
                brand: {
                    navy: '#2A2A2B', // Deep Charcoal / Midnight - Very Elegant
                    coral: '#BFA896', // Warm Cashmere / Muted Taupe - Luxurious Aesthetic
                    light: '#F8F6F4', // Alabaster / Oat - Clean Off-white
                }
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'marquee': 'marquee 25s linear infinite',
                'float': 'float 6s ease-in-out infinite',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                }
            }
        },
    },

    plugins: [forms],
};
