/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./application/views/**/*.{php,html,js}",
		"./node_modules/flowbite/**/*.js",
	],
	theme: {
		extend: {
			colors: {
				primary: "rgb(14 165 233)",
				second: "#effafc",
				// second: "#98E4FF"
			},
			fontFamily: {
				popins:  'Poppins',
			}
		},
	},
	plugins: [require("flowbite/plugin")],
};
