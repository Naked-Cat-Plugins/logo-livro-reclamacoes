/**
 * Livro de Reclamações Eletrónico logo block
 */

import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
// Named export, not the default one: @wordpress/scripts pipes .svg through url-loader before
// @svgr/webpack, so the default export is a data-URI string and only ReactComponent is the
// actual component.
import { ReactComponent as Icon } from './icon.svg';
import './style.scss';

registerBlockType( metadata.name, {
	// Editor-only. block.json's "icon" stays a Dashicon slug because that field is typed as a
	// string: it's what WordPress.org renders in the plugin page's Blocks section, and the
	// fallback anywhere this script doesn't run. Only the editor ever sees this SVG.
	icon: <Icon />,
	edit: Edit,
	save: () => null, // Dynamic block, rendered server-side via render_callback.
} );
