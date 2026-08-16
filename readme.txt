=== Naked Cat Logo for Livro de Reclamações Eletrónico ===
Contributors: nakedcatplugins, webdados
Tags: livro de reclamações, complaints book, portugal, legal, compliance
Requires at least: 6.2
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 1.0
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

The `[livro_reclamacoes]` shortcode accepts the following optional arguments, all shown here at their default value:

* `letters_filled="no"`: set to `"yes"` to paint the “LIVRO DE” lettering inside the circle in a solid color instead of leaving it as transparent cutouts
* `color="red"`: `red`, `blue`, `black`, `white`, or any hex color code (e.g. `color="#123456"`)
* `letter_color=""`: hex color code for the inner lettering; only used when `letters_filled="yes"` **and** `color` is a custom hex code rather than one of the 4 named colors above (for those, the letter color is chosen automatically for contrast). Defaults to white when left empty
* `width=""`: any CSS width value (e.g. `width="150px"`, `width="10em"`); leave empty for natural size. Height always scales automatically and the logo never exceeds the width of its container
* `target="_blank"`: set to `"_self"` to open the link in the same tab instead of a new one

Example: `[livro_reclamacoes letters_filled="yes" color="blue" width="150px" target="_self"]`

= Legal disclaimer =

This plugin helps you display the official “Livro de Reclamações Eletrónico” logo, linked to livroreclamacoes.pt. It does not guarantee that your site is legally compliant. Compliance depends on factors beyond this plugin’s scope (where and how the logo is displayed, your business’s own legal obligations, and any future changes to the law). Naked Cat Plugins and Webdados accept no legal responsibility for your site’s compliance. If in doubt, consult a legal professional.

= Our other free plugins for the Portuguese market =

* [Multibanco, MB WAY, Credit card, Apple Pay, Google Pay, Payshop, Cofidis Pay, and PIX (ifthenpay) for WooCommerce](https://wordpress.org/plugins/multibanco-ifthen-software-gateway-for-woocommerce/) - Receive payments on your WooCommerce store through the Portuguese payment methods offered by ifthenpay
* [Invoicing with InvoiceXpress for WooCommerce – Free](https://wordpress.org/plugins/woo-billing-with-invoicexpress/) - Automatically issue invoices directly from the WooCommerce order
* [Payment Multibanco and MB WAY for FluentCart via ifthenpay](https://wordpress.org/plugins/payment-multibanco-for-fluent-cart-via-ifthenpay/) - Receive Multibanco and MB WAY payments on your FluentCart store
* [Portugal DPD Pickup and Lockers network for WooCommerce](https://wordpress.org/plugins/portugal-chronopost-pickup-woocommerce/) - Deliver your orders on the DPD Portugal network of pickup points and lockers
* [Feed KuantoKusta for WooCommerce – Free](https://wordpress.org/plugins/feed-kuantokusta-for-woocommerce/) - Publish your products on KuantoKusta with this easy to use feed generator
* [NIF (Num. de Contribuinte Português) for WooCommerce](https://wordpress.org/plugins/nif-num-de-contribuinte-portugues-for-woocommerce/) - Add the Portuguese VAT ID (NIF/NIPC) field to the checkout and to the orders
* [Portugal States (Distritos) for WooCommerce](https://wordpress.org/plugins/portugal-states-distritos-for-woocommerce/) - Add the Portuguese districts, with proper address formatting
* [Portugal VASP Expresso Kios network for WooCommerce](https://wordpress.org/plugins/portugal-vasp-kios-woocommerce/) - Deliver your orders on the VASP Expresso Kios network of pickup points
* [PT AO90](https://wordpress.org/plugins/pt-ao90/) - Set the WordPress interface language to Portuguese with the AO90 orthography

= Our other premium plugins for the Portuguese market =

* [Multibanco, MB WAY, Credit card, Apple Pay, Google Pay, Payshop, Cofidis Pay, and PIX (ifthenpay) for WooCommerce – PRO add-on](https://nakedcatplugins.com/product/multibanco-mbway-credit-card-payshop-ifthenpay-woocommerce-pro-add-on/) - Extra features for the plugin you already trust to receive payments on your WooCommerce store
* [Invoicing with InvoiceXpress for WooCommerce – Pro](https://nakedcatplugins.com/product/invoicing-with-invoicexpress-for-woocommerce-pro/) - Automatically issue invoices directly from the WooCommerce order, with all the advanced features
* [DPD Portugal for WooCommerce](https://nakedcatplugins.com/product/dpd-portugal-for-woocommerce/) - Create shipping and return guides in the DPD webservice directly from the WooCommerce order
* [DPD / Geopost Pickup and Lockers network for WooCommerce](https://nakedcatplugins.com/product/dpd-seur-geopost-pickup-and-lockers-network-for-woocommerce/) - Deliver your orders on the DPD and Geopost network of pickup points and lockers in 25 European countries
* [Feed KuantoKusta for WooCommerce PRO add-on](https://nakedcatplugins.com/product/feed-kuantokusta-for-woocommerce-pro/) - Extra features for the KuantoKusta feed generator you already trust
* [Portuguese Postcodes for WooCommerce](https://nakedcatplugins.com/product/portuguese-postcodes-for-woocommerce-technical-support/) - Automatic filling of the address details at the checkout, including street name and neighbourhood, based on the postal code

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

= 1.1 - 2026-08-16 =
* Fix the logo being displayed cut off: the `viewBox` attribute was being stripped from the SVG, leaving it without a coordinate system to scale to
* New block icon, showing the logo itself in the block editor, and a more fitting icon on the WordPress.org plugin page

= 1.0 - 2026-08-16 =
* Initial release
