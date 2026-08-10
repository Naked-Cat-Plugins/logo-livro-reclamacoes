=== Compliance Logo and Link for Livro de Reclamações Eletrónico ===
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

This is an independent third-party plugin and is not affiliated with, endorsed by, or developed by the Direção-Geral do Consumidor or the Portuguese Government. “Livro de Reclamações Eletrónico” is the official name of the Portuguese electronic complaints book service.

= Options =

* **Fill inner letters**: the “LIVRO DE” lettering inside the circle can be left as transparent cutouts (default) or painted in a solid color
* **Color**: official red (default), blue, black, white, or any custom color. When the inner letters are filled, their color is automatically paired for contrast (white on red/blue/black, black on white), or independently choosable when using a custom color
* **Width**: any CSS width value; height always scales automatically and the logo never exceeds the width of its container
* **Link target**: open in a new tab (default) or the same tab

This plugin works on any WordPress site, it has no dependency on WooCommerce or any other plugin.

= Shortcode arguments =

`[livro_reclamacoes]` accepts the following optional arguments, all shown here at their default value:

* `letters_filled="no"`: set to `"yes"` to paint the “LIVRO DE” lettering inside the circle in a solid color instead of leaving it as transparent cutouts
* `color="red"`: `red`, `blue`, `black`, `white`, or any hex color code (e.g. `color="#123456"`)
* `letter_color=""`: hex color code for the inner lettering; only used when `letters_filled="yes"` **and** `color` is a custom hex code rather than one of the 4 named colors above (for those, the letter color is chosen automatically for contrast). Defaults to white when left empty
* `width=""`: any CSS width value (e.g. `width="150px"`, `width="10em"`); leave empty for natural size. Height always scales automatically and the logo never exceeds the width of its container
* `target="_blank"`: set to `"_self"` to open the link in the same tab instead of a new one

Example: `[livro_reclamacoes letters_filled="yes" color="blue" width="150px" target="_self"]`

== Installation ==

1. Install and activate the plugin.
2. Add the `[livro_reclamacoes]` shortcode, or insert the “Livro de Reclamações Eletrónico” block, anywhere on your site (footer widget area, a page, etc.).

= Legal disclaimer =

This plugin helps you display the official “Livro de Reclamações Eletrónico” logo, linked to livroreclamacoes.pt. It does not guarantee that your site is legally compliant. Compliance depends on factors beyond this plugin's scope (where and how the logo is displayed, your business's own legal obligations, and any future changes to the law). Naked Cat Plugins and Webdados accept no legal responsibility for your site's compliance. If in doubt, consult a legal professional.

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
