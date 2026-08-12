<?php
/**
 * Plugin Name:          Naked Cat Plugins Logo for Livro de Reclamações Eletrónico
 * Plugin URI:           https://nakedcatplugins.com/free-wordpress-plugins/logo-livro-de-reclamacoes-eletronico/
 * Description:          Adds the official “Livro de Reclamações Eletrónico” logo, linked to livroreclamacoes.pt, via a shortcode and a block, helping you comply with the disclosure requirement in Decreto-Lei 156/2005 (as amended by DL 74/2017, Art. 9.º-A).
 * Version:              0.1
 * Author:               Naked Cat Plugins (by Webdados)
 * Author URI:           https://nakedcatplugins.com
 * Text Domain:          nakedcat-logo-livro-reclamacoes
 * Requires at least:    6.2
 * Tested up to:         7.1
 * Requires PHP:         7.2
 * License:              GPLv3
 **/

namespace NakedCatPlugins\Nakedcat_Logo_Livro_Reclamacoes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set the plugin's main file constant.
define( 'NAKEDCATPLUGINS_LOGO_LIVRO_RECLAMACOES_FILE', __FILE__ );

/**
 * Initialize the plugin.
 *
 * This function serves as the main entry point for the plugin. It ensures
 * the class is loaded and returns the singleton instance.
 *
 * @since 1.0
 * @return Nakedcat_Logo_Livro_Reclamacoes The singleton instance of the plugin class.
 */
function init_plugin() {
	// Load the main class.
	require_once 'includes/class-nakedcat-logo-livro-reclamacoes.php';
	// Return the singleton instance.
	return Nakedcat_Logo_Livro_Reclamacoes::get_instance();
}

// Initialize the plugin.
init_plugin();

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */
