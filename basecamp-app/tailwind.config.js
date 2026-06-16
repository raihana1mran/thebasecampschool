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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                heading: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                label: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: 'var(--background)',
                foreground: 'var(--foreground)',
                'surface': 'var(--surface)',
                'surface-container-low': 'var(--surface-container-low)',
                'surface-container': 'var(--surface-container)',
                'surface-container-highest': 'var(--surface-container-highest)',
                'surface-container-lowest': 'var(--surface-container-lowest)',
                'surface-variant': 'var(--surface-variant)',
                'primary': 'var(--primary)',
                'on-primary': 'var(--on-primary)',
                'on-surface': 'var(--on-surface)',
                'on-surface-variant': 'var(--on-surface-variant)',
                'primary-container': 'var(--primary-container)',
                // Existing variables mapped for backward compatibility 
                'educational-green': 'var(--educational-green)',
                'educational-mint': 'var(--educational-mint)',
                'glass-bg': 'var(--glass-bg)',
                'glass-border': 'var(--glass-border)',
            },
            backgroundImage: {
                'page-gradient': 'var(--page-gradient)',
            },
            animation: {
                blob: "blob 7s infinite",
            },
            keyframes: {
                blob: {
                    "0%": {
                        transform: "translate(0px, 0px) scale(1)",
                    },
                    "33%": {
                        transform: "translate(30px, -50px) scale(1.1)",
                    },
                    "66%": {
                        transform: "translate(-20px, 20px) scale(0.9)",
                    },
                    "100%": {
                        transform: "translate(0px, 0px) scale(1)",
                    },
                },
            },
        },
    },

    plugins: [forms],
};
