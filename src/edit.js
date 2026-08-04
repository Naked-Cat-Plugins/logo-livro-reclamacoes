import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
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

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Livro de Reclamações Settings', 'logo-livro-reclamacoes' ) }
					initialOpen={ true }
				>
					<ToggleControl
						label={ __( 'Fill inner letters', 'logo-livro-reclamacoes' ) }
						help={ __(
							'When on, the “LIVRO DE” lettering inside the circle is painted in a solid color instead of left as transparent cutouts.',
							'logo-livro-reclamacoes'
						) }
						checked={ !! lettersFilled }
						onChange={ ( value ) => setAttributes( { lettersFilled: value } ) }
					/>
					<SelectControl
						label={ __( 'Color', 'logo-livro-reclamacoes' ) }
						value={ isPreset ? normalizedColor : 'custom' }
						options={ [
							{ label: __( 'Red (official)', 'logo-livro-reclamacoes' ), value: 'red' },
							{ label: __( 'Blue', 'logo-livro-reclamacoes' ), value: 'blue' },
							{ label: __( 'Black', 'logo-livro-reclamacoes' ), value: 'black' },
							{ label: __( 'White', 'logo-livro-reclamacoes' ), value: 'white' },
							{ label: __( 'Custom…', 'logo-livro-reclamacoes' ), value: 'custom' },
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
									'logo-livro-reclamacoes'
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
						label={ __( 'Width', 'logo-livro-reclamacoes' ) }
						help={ __(
							'Leave empty for natural size (always capped at 100% of its container; height is always automatic).',
							'logo-livro-reclamacoes'
						) }
						placeholder={ __( 'auto', 'logo-livro-reclamacoes' ) }
						units={ SIZE_UNITS }
						value={ width }
						onChange={ ( value ) => setAttributes( { width: value ?? '' } ) }
					/>
					<ToggleControl
						label={ __( 'Open in new tab', 'logo-livro-reclamacoes' ) }
						checked={ !! openInNewTab }
						onChange={ ( value ) => setAttributes( { openInNewTab: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			{ /*
			 * The rendered <a> should stay in the markup as-is (same render_html() PHP output as
			 * the frontend), but must not actually navigate away while editing. <Disabled> makes
			 * everything inside it inert (pointer-events, focusability) without stripping any
			 * markup, which is the standard Gutenberg pattern for previewing content that
			 * contains real interactive elements (links, buttons, form fields).
			 */ }
			<Disabled>
				<ServerSideRender block="logo-livro-reclamacoes/logo" attributes={ attributes } />
			</Disabled>
		</>
	);
}
