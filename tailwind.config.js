/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php", "./controllers/**/*.php", "./index.php"],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: ["light"],
  },
};
