# Naked Cat Logo for Livro de Reclamações Eletrónico

Adds the official "Livro de Reclamações Eletrónico" logo, linked to livroreclamacoes.pt, via a
`[livro_reclamacoes]` shortcode and a matching block. See `readme.txt` for the WordPress.org
listing content (description, FAQ, changelog); this file covers development tooling only and is
excluded from the plugin ZIP via `.distignore`.

## Prerequisites

- Node.js and npm
- A local WordPress install for testing
- WP-CLI, if you want to run PHPCS/Plugin Check/i18n commands the same way this repo's own
  tooling does

## Development setup

```bash
npm install
npm run start   # watches src/ and rebuilds on change
```

## Building

```bash
npm run build
```

This runs `wp-scripts build` against `src/` into `build/`, then copies `src/index.php` (a plain
directory-listing guard) into `build/index.php` too, since `build/` ships in the release and is
publicly web-accessible once installed, just like `assets/` and `includes/`.

`build/` is git-ignored; it's generated fresh both locally and by the deploy workflow, never
committed.

## Code standards

```bash
phpcs --standard=.phpcs.xml.dist
```

`.phpcs.xml.dist` enforces the WordPress ruleset plus `PHPCompatibilityWP` against
`testVersion="7.2-"` (matching the `Requires PHP` header), so it also flags anything that isn't
actually compatible with the plugin's declared PHP floor.

## Building a local test ZIP

```bash
./createzip.command
```

Reads `.distignore`, converts it into `zip -x` exclusions, and zips the plugin folder (from its
parent directory) into `../nakedcat-logo-livro-reclamacoes.zip`, with the plugin's files nested inside a
`nakedcat-logo-livro-reclamacoes/` folder in the ZIP (not loose at the root), matching what WordPress.org's
SVN deploy produces. Run `npm run build` first, since `build/` isn't excluded and needs to already
exist for the ZIP to be functional.

### Testing that ZIP with Plugin Check

If you extract the ZIP into `wp-content/plugins/` while this repo's own checkout is already
installed under the same folder name, the OS will auto-rename the extracted copy (e.g. to
`nakedcat-logo-livro-reclamacoes 2`), and WordPress.org's [Plugin Check](https://wordpress.org/plugins/plugin-check/)
will report a false-positive `textdomain_mismatch` (it compares the `Text Domain` header against
the actual install folder name). To test cleanly: temporarily move the dev checkout aside, extract
the ZIP under the exact real slug name, run the check, then move the dev checkout back.

```bash
wp plugin deactivate nakedcat-logo-livro-reclamacoes
mv wp-content/plugins/nakedcat-logo-livro-reclamacoes wp-content/plugins/nakedcat-logo-livro-reclamacoes-dev-backup
unzip nakedcat-logo-livro-reclamacoes.zip -d wp-content/plugins/
wp plugin check nakedcat-logo-livro-reclamacoes
# restore afterwards
rm -rf wp-content/plugins/nakedcat-logo-livro-reclamacoes
mv wp-content/plugins/nakedcat-logo-livro-reclamacoes-dev-backup wp-content/plugins/nakedcat-logo-livro-reclamacoes
wp plugin activate nakedcat-logo-livro-reclamacoes
```

## Releasing to WordPress.org

Push a tag to trigger `.github/workflows/deploy-on-pushing-a-new-tag.yml`: it runs
`npm install && npm run build`, then deploys via `10up/action-wordpress-plugin-deploy@stable` to
the WordPress.org SVN repo. Requires the org-level `NAKEDCAT_WPROG_SVN_USERNAME` /
`NAKEDCAT_WPROG_SVN_PASSWORD` secrets (shared across `Naked-Cat-Plugins`, not per-repo).

Deleting a tag triggers `.github/workflows/delete-release.yml`, which deletes the corresponding
GitHub Release.

## Publishing the WordPress.org listing assets

`.wordpress-org/` holds the banner, icon, and screenshots shown on the plugin's WordPress.org
page. Filenames must match exactly what WordPress.org's SVN assets scanner looks for, or they'll
upload to SVN but simply never display:

- `banner-1544x500.jpg`
- `banner-772x250.jpg`
- `icon.svg` (or `icon-128x128.png` / `icon-256x256.png`)
- `screenshot-1.png`, `screenshot-2.png`, ...

A push to `main` touching `.wordpress-org/**` (or any workflow file) triggers
`.github/workflows/deploy-asset-readme-update.yml`, which runs
`10up/action-wordpress-plugin-asset-update@stable` to push those files (and `readme.txt`) to SVN.
Can also be run manually via `workflow_dispatch` from the Actions tab.

## Reporting security issues

Through the Patchstack Vulnerability Disclosure Program, once this plugin has a listed VDP entry
(see `readme.txt`'s FAQ for the current status).
