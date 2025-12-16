/**
 * Webpack config
 * Extends @wordpress/scripts default configuration
 */

const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
	...defaultConfig,
	entry: {
		'product-card': path.resolve(__dirname, 'blocks/src/product-card/index.js'),
		// Add more blocks here as needed
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(__dirname, 'blocks/build'),
	},
};
