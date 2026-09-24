import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{vue,js}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f0fdf4',   // Very Soft Green
                    100: '#dcfce7',  // Soft Green
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#15803d',  // Secondary Green
                    700: '#166534',  // Primary Green (#166534)
                    800: '#14532d',  // Deep Green (#14532D)
                    900: '#0a2e1e',
                    950: '#052e16',  // Dark Green (#052E16)
                },
                accent: {
                    amber: '#d97706',
                    gold: '#f59e0b',
                    light: '#fef3c7',
                }
            },
            boxShadow: {
                card: '0 4px 12px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03)',
                'card-hover': '0 12px 24px -4px rgba(15, 23, 42, 0.10), 0 4px 8px -2px rgba(15, 23, 42, 0.04)',
                dropdown: '0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.04)',
            },
            borderRadius: {
                xl: '16px',
                '2xl': '20px',
            }
        },
    },

    plugins: [forms],
};
