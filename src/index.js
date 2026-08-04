/**
 * Livro de Reclamações Eletrónico logo block
 */

import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
import './style.scss';

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null, // Dynamic block, rendered server-side via render_callback.
} );
