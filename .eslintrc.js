module.exports = {
	extends: [
		'plugin:@wordpress/eslint-plugin/recommended-with-formatting',
		'plugin:prettier/recommended',
	],
	parserOptions: {
		ecmaVersion: 2021,
	},
	root: true,
	env: {
		browser: true,
		es6: true,
		jquery: true,
	},
	rules: {
		'@wordpress/no-global-event-listener': 0, // Disable. We don't use React-based components.
		'no-unused-vars': 0,
		'array-callback-return': 0,
		'prefer-const': 1,
		'object-shorthand': 0,
		'import/no-extraneous-dependencies': 0,
		'no-console': 0,
		'no-undef': 0,
		'selector-id-pattern': 0,
		camelcase: 1,
	},
};
