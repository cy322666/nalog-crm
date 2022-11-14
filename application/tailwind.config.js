const colors = require('tailwindcss/colors')

module.exports = {
    content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                // primary: {
                //     '50':  withOpacityValue('--color-primary-50'),
                //     '100': withOpacityValue('--color-primary-100'),
                //     '200': withOpacityValue('--color-primary-200'),
                //     '300': withOpacityValue('--color-primary-300'),
                //     '400': withOpacityValue('--color-primary-400'),
                //     '500': withOpacityValue('--color-primary-500'),
                //     '600': withOpacityValue('--color-primary-600'),
                //     '700': withOpacityValue('--color-primary-700'),
                //     '800': withOpacityValue('--color-primary-800'),
                //     '900': withOpacityValue('--color-primary-900')
                // },
                danger: colors.blue,
                // success: colors.green,
                // warning: colors.amber,
                // danger: colors.rose,
                primary: colors.green,
                // primary: 'rgb(var(--color-primary) / <alpha-value>)',
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
