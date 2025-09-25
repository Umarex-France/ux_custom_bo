# ux_custom_bo — UX Custom BackOffice

## Présentation

Module PrestaShop 9 visant à harmoniser l’interface du Back Office par de légères personnalisations visuelles (branding, couleur d’en-tête, badge de version). Aucune page de configuration ni modification de base de données.

## Ce que fait le module

- Charge une feuille de style dédiée au Back Office.
- Remplace le logo de l’en‑tête BO via le sélecteur `#header_logo` par `views/img/LogoUX_Prestashop.svg`.
- Applique une couleur d’en‑tête via la variable CSS `--cdk-header-bg` sur `#header.bootstrap` (legacy) et `.main-header` (pages modernes).
- Stylise le badge de version du BO (`#shop_version` et `.main-header #shop_version`) : fond semi‑transparent, padding, bords arrondis.

## Détails CSS (views/css/admin.css)

- En‑tête BO (legacy + moderne)
  - Déclare `--cdk-header-bg: #ee0000 !important;` sur `#header.bootstrap, .main-header`.
  - Effet attendu selon le thème admin (utilisation de la variable CSS si supportée).
- Logo Back Office
  - `#header_logo` → image `../img/LogoUX_Prestashop.svg`, `background-size: contain`, largeur ~12rem, hauteur 40px, marges ajustées.
- Badge version
  - `#shop_version, .main-header #shop_version` → fond `#66666666`, padding `0.25rem 0.75rem`, `border-radius: 5rem`.

## Hooks et services utilisés

- Hook `displayBackOfficeHeader` (fichier `ux_custom_bo.php`)
  - Injection du CSS avec `$this->context->controller->addCSS('/modules/ux_custom_bo/views/css/admin.css', 'all');`.
  - Couvre les écrans legacy du Back Office.
- Service `prestashop.assets` (fichier `config/services.yml`)
  - Déclare l’asset `modules/ux_custom_bo/views/css/admin.css` en tant que `stylesheet` avec `priority: 150`.
  - Garantit le chargement sur les pages Symfony/modernes via le système d’assets de PrestaShop 9.

Ces deux mécanismes se complètent afin d’assurer le chargement du CSS sur l’ensemble du Back Office (legacy et moderne).

## Structure du module

- `ux_custom_bo.php` : classe principale du module, enregistrement du hook `displayBackOfficeHeader`, système de traduction moderne activé (`isUsingNewTranslationSystem`).
- `config/config.xml` : métadonnées du module (nom, version, auteur, etc.).
- `config/services.yml` : déclaration de l’asset Back Office via le tag `prestashop.assets`.
- `views/css/admin.css` : règles CSS appliquées au Back Office.
- `views/img/LogoUX_Prestashop.svg` : logo utilisé dans l’en‑tête BO.
- `logo.png` : icône du module.

## Installation

Option 1 — Directement dans PrestaShop
- Copier le dossier généré `modules/ux_custom_bo` dans votre instance.
- Activer le module depuis le BO (`Modules > Module Manager`).

Option 2 — Depuis les sources `.dev`
- Générer le module à partir des sources: `php .dev/buildModule.php ux_custom_bo --dev` (ou `--prod` pour produire un zip dans `.dev/build`).
- Le module est copié dans `modules/ux_custom_bo`, puis activer dans le BO.

Après installation ou modification du CSS, vider le cache PrestaShop si nécessaire et recharger le navigateur.

## Compatibilité

- PrestaShop ≥ 9.0.0 (déclaré via `ps_versions_compliancy`).

## Limitations et notes

- Aucune page de configuration ni stockage en base : les ajustements (couleur, logo) se font via `views/css/admin.css` et `views/img`.
- Sur certains thèmes/admin personnalisés, les sélecteurs ou la variable `--cdk-header-bg` peuvent ne pas être pris en compte.
- Le CSS est chargé de deux façons (hook + service) pour maximiser la couverture des écrans BO.

## Développement

- Domaine de traduction: `Modules.Ux_custom_bo.Admin` (chaînes dans `ux_custom_bo.php`).
- Build des sources via `php .dev/buildModule.php ux_custom_bo [--dev|--prod]`.

---

Module interne de branding Back Office — léger, sans surcouche fonctionnelle.
