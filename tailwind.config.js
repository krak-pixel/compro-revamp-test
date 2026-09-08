import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                'tvip-blue': '#0f4c81',
                'tvip-blue-dark': '#0a3254',
                'tvip-heading': '#101828',
                'tvip-body': '#4a5565',
                'tvip-nav': '#364153',
                'tvip-black': '#000000',
                'tvip-cta-secondary': '#333333',
                'tvip-light-card': '#ecf5ff',
                'tvip-light-section': '#e6eef5',
                'tvip-social-bg': '#f3f4f6',
                'tvip-outline': '#d1d5dc',
                'tvip-divider': '#e5e7eb',
            },
            fontFamily: {
                inter: ['Inter', 'sans-serif'],
            },
            borderRadius: {
                'tvip-hero': '40px',
                'tvip-card-lg': '24px',
                'tvip-card': '16px',
                'tvip-button': '8px',
                'tvip-button-lg': '10px',
                'tvip-full': '9999px',
            },
            boxShadow: {
                'tvip-hero': '0px 25px 50px -12px rgba(0,0,0,0.25)',
                'tvip-floating': '0px 10px 7.5px rgba(0,0,0,0.1), 0px 4px 3px rgba(0,0,0,0.1)',
                'tvip-info-card': '0px 16px 32px -4px rgba(12,12,13,0.1), 0px 4px 4px -4px rgba(12,12,13,0.05)',
                'tvip-contact': '0px 1px 1.5px rgba(0,0,0,0.1), 0px 1px 1px rgba(0,0,0,0.1)',
                'tvip-navbar': '0px 1px 1.5px rgba(0,0,0,0.1), 0px 1px 1px rgba(0,0,0,0.1)',
            },
            backgroundImage: {
                'tvip-primary': 'linear-gradient(to right, #0a3254, #0f4c81)',
            },
            maxWidth: {
                'tvip-content': '1280px',
            },
        },
    },
    plugins: [forms],
};
