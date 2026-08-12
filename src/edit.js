import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
	ColorPicker,
	Disabled,
	PanelBody,
	SelectControl,
	ToggleControl,
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

const SIZE_UNITS = [
	{ value: 'px', label: 'px', default: 0 },
	{ value: 'em', label: 'em', default: 0 },
	{ value: 'rem', label: 'rem', default: 0 },
	{ value: '%', label: '%', default: 0 },
];

const COLOR_PRESET_KEYS = [ 'red', 'blue', 'black', 'white' ];

export default function Edit( { attributes, setAttributes } ) {
	const { lettersFilled, color, letterColor, width, openInNewTab } = attributes;

	const normalizedColor = ( color || '' ).toLowerCase();
	const isPreset = COLOR_PRESET_KEYS.includes( normalizedColor );
	const isCustomColor = ! isPreset;

	// Gives the editor canvas the same wrapper (class, align, custom className from the
	// Advanced panel, ...) that a save()-based block would get automatically. Without this,
	// the block renders at full canvas width in the editor instead of the theme's normal
	// content width, and the alignment toolbar has nothing to actually apply itself to.
	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Livro de Reclamações Settings', 'nakedcat-logo-livro-reclamacoes' ) }
					initialOpen={ true }
				>
					<ToggleControl
						label={ __( 'Fill inner letters', 'nakedcat-logo-livro-reclamacoes' ) }
						help={ __(
							'When on, the “LIVRO DE” lettering inside the circle is painted in a solid color instead of left as transparent cutouts.',
							'nakedcat-logo-livro-reclamacoes'
						) }
						checked={ !! lettersFilled }
						onChange={ ( value ) => setAttributes( { lettersFilled: value } ) }
					/>
					<SelectControl
						label={ __( 'Color', 'nakedcat-logo-livro-reclamacoes' ) }
						value={ isPreset ? normalizedColor : 'custom' }
						options={ [
							{ label: __( 'Red (official)', 'nakedcat-logo-livro-reclamacoes' ), value: 'red' },
							{ label: __( 'Blue (official)', 'nakedcat-logo-livro-reclamacoes' ), value: 'blue' },
							{ label: __( 'Black (official)', 'nakedcat-logo-livro-reclamacoes' ), value: 'black' },
							{ label: __( 'White', 'nakedcat-logo-livro-reclamacoes' ), value: 'white' },
							{ label: __( 'Custom…', 'nakedcat-logo-livro-reclamacoes' ), value: 'custom' },
						] }
						onChange={ ( value ) =>
							setAttributes( {
								color: 'custom' === value ? ( isCustomColor && color ? color : '#000000' ) : value,
							} )
						}
					/>
					{ isCustomColor && (
						<ColorPicker
							color={ color || '#000000' }
							onChangeComplete={ ( value ) => setAttributes( { color: value.hex } ) }
							disableAlpha
						/>
					) }
					{ lettersFilled && isCustomColor && (
						<>
							<p>
								{ __(
									'Letter color (only used with a custom logo color):',
									'nakedcat-logo-livro-reclamacoes'
								) }
							</p>
							<ColorPicker
								color={ letterColor || '#FFFFFF' }
								onChangeComplete={ ( value ) => setAttributes( { letterColor: value.hex } ) }
								disableAlpha
							/>
						</>
					) }
					<UnitControl
						label={ __( 'Width', 'nakedcat-logo-livro-reclamacoes' ) }
						help={ __(
							'Leave empty for natural size (always capped at 100% of its container; height is always automatic).',
							'nakedcat-logo-livro-reclamacoes'
						) }
						placeholder={ __( 'auto', 'nakedcat-logo-livro-reclamacoes' ) }
						units={ SIZE_UNITS }
						value={ width }
						onChange={ ( value ) => setAttributes( { width: value ?? '' } ) }
					/>
					<ToggleControl
						label={ __( 'Open in new tab', 'nakedcat-logo-livro-reclamacoes' ) }
						checked={ !! openInNewTab }
						onChange={ ( value ) => setAttributes( { openInNewTab: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ /*
			 * <figure> to match core/image's own wrapper tag (and the frontend markup
			 * block_render() produces): our output is conceptually the same shape as a linked
			 * image.
			 */ }
			<figure { ...blockProps }>
				{ /*
				 * The rendered <a> should stay in the markup as-is (same render_html() PHP
				 * output as the frontend), but must not actually navigate away while editing.
				 * <Disabled> makes everything inside it inert (pointer-events, focusability)
				 * without stripping any markup, the standard block editor pattern for previewing
				 * content that contains real interactive elements (links, buttons, form
				 * fields).
				 */ }
				<Disabled>
					<ServerSideRender block="nakedcat-logo-livro-reclamacoes/logo" attributes={ attributes } />
				</Disabled>
			</figure>
		</>
	);
}
