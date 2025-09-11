import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Activation du dark mode basé sur la classe
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
                // Palette Light
                light: {
                    background: '#F8FAFC', // gris bleuté très clair
                    text: '#0F172A',      // bleu-noir profond
                    primary: '#2563EB',   // bleu royal
                    secondary: '#F59E0B', // orange doré
                },
                // Palette Dark
                dark: {
                    background: '#0F172A', // bleu-noir profond
                    text: '#E2E8F0',      // gris clair
                    primary: '#3B82F6',    // bleu lumineux
                    secondary: '#FBBF24',  // jaune-orangé
                },
            },
        },
    },

    plugins: [forms],
};