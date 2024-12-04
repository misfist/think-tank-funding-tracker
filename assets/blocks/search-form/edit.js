/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Dashicon, PanelBody, TextControl, ToggleControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( {
	attributes: { description, ajax },
	setAttributes,
} ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Search Settings', 'ttft' ) }>
					<TextControl
						label={ __( 'Description', 'ttft' ) }
						value={ description || '' }
						onChange={ ( value ) =>
							setAttributes( { description: value } )
						}
					/>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Ajax Search', 'ttft' ) }
						help={
							ajax
								? __( 'Use AJAX Search', 'ttft' )
								: __( 'Use Default Search', 'ttft' )
						}
						checked={ ajax || false  }
						onChange={ ( value ) =>
							setAttributes( { ajax: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<Dashicon icon="search" />{ ' ' }{ description || __( 'Search Form', 'ttft' ) }
			</div>
		</>
	);
}
