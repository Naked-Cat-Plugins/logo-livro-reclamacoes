<?php
/**
 * Main plugin class for Logo Livro de Reclamações Eletrónico
 *
 * Registers the [livro_reclamacoes] shortcode and the matching Gutenberg block, both of
 * which build their markup through the same private render_html() method so the output is
 * always identical regardless of how the logo was placed on the page.
 *
 * @since 1.0
 */

namespace NakedCatPlugins\LogoLivroReclamacoes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Our main class
 */
final class Logo_Livro_Reclamacoes {

	/**
	 * The Livro de Reclamações Eletrónico platform URL. Always fixed, never configurable.
	 *
	 * @var string
	 */
	const URL = 'https://www.livroreclamacoes.pt/';

	/**
	 * The singleton instance.
	 *
	 * @var Logo_Livro_Reclamacoes|null
	 */
	protected static $instance = null;

	/**
	 * Official color presets.
	 *
	 * @var array
	 */
	private $color_presets = array(
		'red'   => '#b71c1c',
		'blue'  => '#009CDE',
		'black' => '#010101',
		'white' => '#FFFFFF',
	);

	/**
	 * Inner "LIVRO DE" lettering color for each preset, used only when the filled logo variant
	 * is requested. Not used for a custom color, where the letter color is a separate,
	 * independently chosen value instead.
	 *
	 * @var array
	 */
	private $letter_color_map = array(
		'red'   => '#FFFFFF',
		'blue'  => '#FFFFFF',
		'black' => '#FFFFFF',
		'white' => '#010101',
	);

	/**
	 * Per-request cache of the bundled SVG source files, keyed by variant ('1' or '2'), so
	 * multiple shortcode/block instances on one page don't each re-read the file from disk.
	 *
	 * @var array
	 */
	private $svg_cache = array();

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	private function __construct() {
		// Hooks
		$this->init_hooks();
	}

	/**
	 * Prevent cloning of the instance.
	 *
	 * @since 1.0
	 */
	private function __clone() {}

	/**
	 * Prevent unserialization of the instance.
	 *
	 * @since 1.0
	 * @throws \Exception When attempting to unserialize the singleton instance.
	 */
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize singleton' );
	}

	/**
	 * Get the singleton instance.
	 *
	 * @since 1.0
	 * @return Logo_Livro_Reclamacoes The singleton instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize WordPress hooks.
	 *
	 * @since 1.0
	 */
	public function init_hooks() {
		add_shortcode( 'livro_reclamacoes', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'register_block' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue the small frontend stylesheet unconditionally on every frontend request.
	 *
	 * The shortcode can appear anywhere WordPress renders shortcodes (post content, widgets,
	 * ACF fields, etc.), so there's no reliable way to detect its presence ahead of
	 * `wp_enqueue_scripts` time to conditionally load this only when needed. Enqueuing late
	 * from inside render_html() doesn't work either: WordPress core only auto-reprints
	 * scripts queued after `wp_head`, not styles, so a style enqueued during `the_content`
	 * processing (which runs after `wp_head` already printed) never actually gets output.
	 * Given the stylesheet is a handful of bytes, always loading it is the simplest correct
	 * fix. The block doesn't need this call: block.json's own "style" field makes core
	 * auto-enqueue it whenever the block itself is present on the page.
	 *
	 * @since 1.0
	 */
	public function enqueue_assets() {
		$file = plugin_dir_path( NAKEDCATPLUGINS_LOGO_LIVRO_RECLAMACOES_FILE ) . 'build/style-index.css';
		if ( ! is_readable( $file ) ) {
			return;
		}
		wp_enqueue_style(
			'logo-livro-reclamacoes',
			plugins_url( 'build/style-index.css', NAKEDCATPLUGINS_LOGO_LIVRO_RECLAMACOES_FILE ),
			array(),
			filemtime( $file )
		);
	}

	/**
	 * Register the Gutenberg block, using the same block_render() render callback the
	 * shortcode ultimately shares logic with (see render_html()).
	 *
	 * @since 1.0
	 */
	public function register_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$build_dir = plugin_dir_path( NAKEDCATPLUGINS_LOGO_LIVRO_RECLAMACOES_FILE ) . 'build';

		// Guards against a fatal error if the plugin is checked out but `npm run build` hasn't
		// been run yet (build/block.json doesn't exist).
		if ( ! file_exists( $build_dir . '/block.json' ) ) {
			return;
		}

		register_block_type(
			$build_dir,
			array(
				'render_callback' => array( $this, 'block_render' ),
			)
		);
	}

	/**
	 * Shortcode handler for [livro_reclamacoes].
	 *
	 * @since 1.0
	 *
	 * @example [livro_reclamacoes letters_filled="yes" color="blue" width="150px" target="_self"]
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'letters_filled' => 'no',
				'color'          => 'red',
				'letter_color'   => '',
				'width'          => '',
				'target'         => '_blank',
			),
			$atts,
			'livro_reclamacoes'
		);

		return $this->render_html( $atts );
	}

	/**
	 * Block render_callback. Normalizes the block's camelCase attribute names to the same
	 * snake_case keys the shortcode uses, then delegates to the same render_html().
	 *
	 * @since 1.0
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function block_render( $attributes ) {
		$attributes = is_array( $attributes ) ? $attributes : array();

		return $this->render_html(
			array(
				'letters_filled' => isset( $attributes['lettersFilled'] ) ? $attributes['lettersFilled'] : false,
				'color'          => isset( $attributes['color'] ) ? $attributes['color'] : 'red',
				'letter_color'   => isset( $attributes['letterColor'] ) ? $attributes['letterColor'] : '',
				'width'          => isset( $attributes['width'] ) ? $attributes['width'] : '',
				'target'         => ( array_key_exists( 'openInNewTab', $attributes ) && ! $attributes['openInNewTab'] )
					? '_self'
					: '_blank',
			)
		);
	}

	/**
	 * Shared HTML builder - the single source of truth for both the shortcode and the block.
	 *
	 * @since 1.0
	 *
	 * @param array $args {
	 *     Arguments describing how to render the logo.
	 *
	 *     @type mixed  $letters_filled Truthy value (bool, or 'yes'/'true'/'1') to use the
	 *                                  filled logo variant, falsy for the unfilled/cutout one.
	 *                                  Default false.
	 *     @type string $color          Preset key ('red'|'blue'|'black'|'white') or any hex
	 *                                  color. Default 'red'.
	 *     @type string $letter_color   Hex color for the inner lettering, only used when
	 *                                  $letters_filled is truthy AND $color isn't a known
	 *                                  preset. Default '' (falls back to white).
	 *     @type string $width          Any CSS length/percentage (e.g. '150px', '10em',
	 *                                  '100%'), or '' for natural size.
	 *     @type string $target         '_blank' or '_self'. Default '_blank'.
	 * }
	 * @return string
	 */
	private function render_html( $args ) {
		$defaults = array(
			'letters_filled' => false,
			'color'          => 'red',
			'letter_color'   => '',
			'width'          => '',
			'target'         => '_blank',
		);
		$args     = wp_parse_args( $args, $defaults );

		$filled = $this->to_bool( $args['letters_filled'] );

		// Resolve the main color: known preset key wins, else strictly validate as hex, else
		// fall back to red.
		$color_key = is_string( $args['color'] ) ? strtolower( trim( $args['color'] ) ) : '';
		if ( isset( $this->color_presets[ $color_key ] ) ) {
			$color = $this->color_presets[ $color_key ];
		} else {
			$color = sanitize_hex_color( is_string( $args['color'] ) ? $args['color'] : '' );
			if ( ! $color ) {
				$color_key = 'red';
				$color     = $this->color_presets['red'];
			}
		}

		// Resolve the inner lettering color (only rendered when $filled is true). Fixed pairing
		// for the 4 presets; a separately chosen (or default white) color for a custom hex.
		if ( isset( $this->letter_color_map[ $color_key ] ) ) {
			$letter_color = $this->letter_color_map[ $color_key ];
		} else {
			$letter_color = sanitize_hex_color( is_string( $args['letter_color'] ) ? $args['letter_color'] : '' );
			if ( ! $letter_color ) {
				$letter_color = '#FFFFFF';
			}
		}

		// Width: allow any CSS length/function (px, em, %, calc(), clamp(), ...) via a safe
		// character whitelist rather than a strict unit regex, height always stays auto and
		// max-width:100% is always applied regardless of what width is requested.
		$wrapper_style = 'max-width:100%;';
		$width         = is_string( $args['width'] ) ? trim( $args['width'] ) : '';
		if ( '' !== $width && preg_match( '/^[a-zA-Z0-9.\-%(),\s]+$/', $width ) ) {
			$wrapper_style = 'width:' . $width . ';' . $wrapper_style;
		}

		$target = '_self' === $args['target'] ? '_self' : '_blank';
		$rel    = '_blank' === $target ? ' rel="noopener"' : '';

		$unique_id = wp_unique_id( 'livro-reclamacoes-logo-' );
		$svg       = $this->get_svg_markup( $filled, $color, $letter_color, $unique_id );
		if ( '' === $svg ) {
			return '';
		}

		return sprintf(
			'<a href="%1$s" target="%2$s"%3$s class="livro-reclamacoes-link" aria-label="%4$s" style="%5$s">%6$s</a>',
			esc_url( self::URL ),
			esc_attr( $target ),
			$rel,
			esc_attr__( 'Livro de Reclamações Eletrónico', 'logo-livro-reclamacoes' ),
			esc_attr( $wrapper_style ),
			$svg
		);
	}

	/**
	 * Loads one of the two bundled SVGs and makes it safe to reuse multiple times on the same
	 * page: gives this instance's <svg> a unique id (the class name itself has no per-instance
	 * placeholder, only the id does), then rewrites the fill-color CSS rule(s) - which are
	 * page-global scoped even though they live inside an inline <svg> - so they're scoped to
	 * that id instead of the bare class name.
	 *
	 * Only the two bundled, developer-controlled SVG files are ever read here, never a
	 * user-supplied path, and the only dynamic values interpolated into the raw markup are
	 * already-validated hex color strings and a wp_unique_id() suffix, so this is safe without
	 * needing wp_kses on the whole markup.
	 *
	 * @since 1.0
	 *
	 * @param bool   $filled       True for the filled variant (assets/livro-reclamacoes-2.svg),
	 *                             false for the unfilled/cutout one (assets/livro-reclamacoes-1.svg).
	 * @param string $color        Already-validated hex color for the circle + outer wordmark.
	 * @param string $letter_color Already-validated hex color for the inner lettering, only
	 *                             applied when $filled is true.
	 * @param string $unique_id    Unique id for this instance's <svg> root.
	 * @return string SVG markup, or '' if the source file couldn't be read.
	 */
	private function get_svg_markup( $filled, $color, $letter_color, $unique_id ) {
		$variant = $filled ? '2' : '1';

		if ( ! isset( $this->svg_cache[ $variant ] ) ) {
			$file = plugin_dir_path( NAKEDCATPLUGINS_LOGO_LIVRO_RECLAMACOES_FILE ) . 'assets/livro-reclamacoes-' . $variant . '.svg';

			if ( ! is_readable( $file ) ) {
				return '';
			}

			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local bundled plugin asset, not remote/user-supplied.
			$this->svg_cache[ $variant ] = (string) file_get_contents( $file );
		}

		$svg = $this->svg_cache[ $variant ];
		if ( '' === $svg ) {
			return '';
		}

		// Unique id on the <svg> root (keep the fixed "livro-reclamacoes-logo" class as-is) and
		// mark it decorative for assistive tech - the wrapping <a> already carries a text
		// aria-label, and the mark itself has no real text nodes for a screen reader.
		$svg = str_replace(
			'id="livro-reclamacoes-logo-x"',
			'id="' . esc_attr( $unique_id ) . '" aria-hidden="true" focusable="false"',
			$svg
		);

		// Scope + recolor the shared fill rule (circle + outer wordmark) to this instance only.
		$svg = preg_replace(
			'/\.livro-reclamacoes-fill\{fill:#[0-9a-fA-F]{3,6}\}/',
			'#' . $unique_id . ' .livro-reclamacoes-fill{fill:' . $color . '}',
			$svg,
			1
		);

		// Filled variant only: scope + recolor the inner "LIVRO DE" lettering rule.
		if ( $filled ) {
			$svg = preg_replace(
				'/\.livro-reclamacoes-fill-letters-circle\{fill:#[0-9a-fA-F]{3,6}\}/',
				'#' . $unique_id . ' .livro-reclamacoes-fill-letters-circle{fill:' . $letter_color . '}',
				$svg,
				1
			);
		}

		return $svg;
	}

	/**
	 * Normalize a shortcode-string or block-boolean truthy value to a real boolean.
	 *
	 * @since 1.0
	 *
	 * @param mixed $value Value to normalize.
	 * @return bool
	 */
	private function to_bool( $value ) {
		if ( is_bool( $value ) ) {
			return $value;
		}
		if ( is_string( $value ) ) {
			return in_array( strtolower( trim( $value ) ), array( 'yes', 'true', '1' ), true );
		}
		return (bool) $value;
	}
}
