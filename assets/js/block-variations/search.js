import { registerBlockVariation } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

const NAMESPACE = `ttft/search`;

const variations = [
	{
		name: NAMESPACE,
		title: __('Custom Search', 'ttft'),
		description: __('Display authors for post.', 'ttft'),
		icon: 'code-standards',
		attributes: {
			className: 'custom-search',
			namespace: NAMESPACE,
			ajax: true,
		},
		scope: ['block', 'inserter', 'transform'],
		isActive: ['namespace'],
	},
];

variations.forEach((variation) => {
	registerBlockVariation('core/search', variation);
});
