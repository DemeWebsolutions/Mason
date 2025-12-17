/**
 * Product Card Block
 * React-based custom block for WooCommerce products
 * 
 * @package StoneMason
 */

import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

import './editor.css';
import './style.css';
import metadata from './block.json';

/**
 * Block Edit Component
 */
const Edit = ({ attributes, setAttributes }) => {
	const blockProps = useBlockProps();
	const { productId, showPrice, showButton, buttonText } = attributes;

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title={__('Product Settings', 'stone-mason')}>
					<TextControl
						label={__('Product ID', 'stone-mason')}
						value={productId}
						onChange={(value) => setAttributes({ productId: parseInt(value, 10) || 0 })}
						type="number"
						help={__('Enter the WooCommerce product ID', 'stone-mason')}
					/>
					<ToggleControl
						label={__('Show Price', 'stone-mason')}
						checked={showPrice}
						onChange={(value) => setAttributes({ showPrice: value })}
					/>
					<ToggleControl
						label={__('Show Button', 'stone-mason')}
						checked={showButton}
						onChange={(value) => setAttributes({ showButton: value })}
					/>
					{showButton && (
						<TextControl
							label={__('Button Text', 'stone-mason')}
							value={buttonText}
							onChange={(value) => setAttributes({ buttonText: value })}
						/>
					)}
				</PanelBody>
			</InspectorControls>

			{productId > 0 ? (
				<ServerSideRender
					block="stone-mason/product-card"
					attributes={attributes}
				/>
			) : (
				<div className="mason-product-card-placeholder">
					<p>{__('Please select a product ID in the block settings', 'stone-mason')}</p>
				</div>
			)}
		</div>
	);
};

/**
 * Register Block Type
 */
registerBlockType(metadata.name, {
	edit: Edit,
	save: () => null, // Server-side rendered
});
