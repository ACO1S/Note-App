/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        spartan: ['"League Spartan"', 'sans-serif'],
      },
      colors: {
        customcolor: {
          DEFAULT: '#7AB2D3',
          dark: '#4A628A',
        },
      },
    },
  },
  plugins: [],
}

