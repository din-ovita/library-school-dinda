/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./application/views/**/*.{php,html,js}",
		"./node_modules/flowbite/**/*.js",
	],
	theme: {
		extend: {
			colors: {
				primary: "#0ea5e9",
				second: "#effafc",
			},
			fontFamily: {
				popins:  'Poppins',
			},
			borderRadius: {
				primary: ['41% 59% 39% 61%', '72% 44% 56% 28%'],
			}
		},
	},
	plugins: [require("flowbite/plugin")],
};
