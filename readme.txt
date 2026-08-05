=== Logo Livro de Reclamações Eletrónico ===
Contributors: nakedcatplugins, webdados
Tags: livro de reclamações, complaints book, portugal, legal, compliance
Requires at least: 6.2
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 0.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Displays the official “Livro de Reclamações Eletrónico” logo, linked to livroreclamacoes.pt, via a shortcode or a block.

== Description ==

Portuguese law (Decreto-Lei n.º 156/2005, as amended by Decreto-Lei n.º 74/2017, art. 9.º-A) requires businesses selling goods or services to consumers to provide visible, prominent access to the “Livro de Reclamações Eletrónico” on their website. Displaying the official logo, linked to livroreclamacoes.pt, is the standard way businesses satisfy this requirement.

This plugin adds that logo to your site in two ways, a `[livro_reclamacoes]` shortcode and a matching block, both sharing the exact same rendering code so the result is identical everywhere you use it.

= Options =

* **Fill inner letters**: the “LIVRO DE” lettering inside the circle can be left as transparent cutouts (default) or painted in a solid color
* **Color**: official red (default), blue, black, white, or any custom color. When the inner letters are filled, their color is automatically paired for contrast (white on red/blue/black, black on white), or independently choosable when using a custom color
* **Width**: any CSS width value; height always scales automatically and the logo never exceeds the width of its container
* **Link target**: open in a new tab (default) or the same tab

This plugin works on any WordPress site, it has no dependency on WooCommerce or any other plugin.

== Installation ==

1. Install and activate the plugin.
2. Add the `[livro_reclamacoes]` shortcode, or insert the “Livro de Reclamações Eletrónico” block, anywhere on your site (footer widget area, a page, etc.).

== Frequently Asked Questions ==

= Does this work without WooCommerce? =

Yes. This plugin has no dependency on WooCommerce, it works on any WordPress site.

= Where do I report security vulnerabilities found in this plugin? =

You can report any security bugs found in the source code of this plugin through the Patchstack Vulnerability Disclosure Program. (link available soon)

== Screenshots ==

1. The block’s settings panel in the block editor
2. The logo rendered on the frontend

== Changelog ==

= 0.1 =
* Initial release
