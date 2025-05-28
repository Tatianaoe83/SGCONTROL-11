import preset from '../../../../vendor/filament/filament/tailwind.config.preset'
import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
/** @type {import('tailwindcss').Config} */

export default {
    presets: [preset],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.blue,
            },
        },
    },
    plugins: [
        forms,
        typography
    ],
}
  

