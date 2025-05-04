# ProjetNormandiePageBundle

A Symfony bundle for managing pages with multi-language support, status management, and API Platform integration.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/projet-normandie/page-bundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/projet-normandie/page-bundle/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/projet-normandie/page-bundle/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/projet-normandie/page-bundle/?branch=develop)

## Features

- Page management with multi-language support (EN/FR) using A2lix Translation Bundle
- Page status management (PUBLIC/PRIVATE)
- Automatic slug generation using Gedmo extensions
- Integration with Sonata Admin for backend management
- API Platform support with read endpoints
- Rich text editor for page content
- Search functionality through API filters

## Installation

1. Install the bundle using composer:
```bash
composer require projet-normandie/page-bundle
```

2. Enable the bundle in your `config/bundles.php`:
```php
return [
    // ...
    ProjetNormandie\PageBundle\ProjetNormandiePageBundle::class => ['all' => true],
];
```

3. Update your database schema:
```bash
php bin/console doctrine:schema:update --force
```

Or create a migration:
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Configuration

### Required Dependencies

This bundle requires the following dependencies:
- PHP ^8.3
- Symfony 6.4+ or 7.2+
- Doctrine ORM 3.3+
- A2lix Translation Form Bundle
- API Platform 4.0+
- Sonata Admin Bundle 4.0+
- Gedmo Doctrine Extensions

### Database Tables

The bundle creates the following tables:
- `pnp_page` - Main page table
- `pnp_page_translation` - Page translations

### API Endpoints

The bundle exposes the following API endpoints:

- `GET /api/pages` - Get collection of pages
- `GET /api/pages/{id}` - Get specific page
- Filter by slug: `/api/pages?slug=my-page`

## Usage

### Creating a Page

#### Via Sonata Admin

1. Navigate to the Pages admin section
2. Click "Add new"
3. Fill in the page details:
    - Name
    - Status (PUBLIC/PRIVATE)
    - Enabled (yes/no)
    - Translations (title and text for each language)

#### Via Code

```php
use ProjetNormandie\PageBundle\Entity\Page;
use ProjetNormandie\PageBundle\ValueObject\PageStatus;

$page = new Page();
$page->setName('My Page');
$page->setStatus(PageStatus::PUBLIC);
$page->setEnabled(true);

// Add translations
$page->translate('en')->setTitle('English Title');
$page->translate('en')->setText('English content...');
$page->translate('fr')->setTitle('Titre Français');
$page->translate('fr')->setText('Contenu français...');

$entityManager->persist($page);
$entityManager->flush();
```

### Page Status

The bundle supports two page statuses:
- `PageStatus::PUBLIC` - Visible to all users
- `PageStatus::PRIVATE` - Not visible in public API

### API Usage

#### Get all public pages
```http
GET /api/pages
```

Response:
```json
{
  "@context": "/api/contexts/Page",
  "@id": "/api/pages",
  "@type": "hydra:Collection",
  "hydra:member": [
    {
      "@id": "/api/pages/1",
      "@type": "Page",
      "id": 1,
      "slug": "my-page",
      "text": "Page content..."
    }
  ]
}
```

#### Get page by slug
```http
GET /api/pages?slug=my-page
```

### Rich Text Editor

The bundle includes a custom form type `RichTextEditorType` for editing page content with rich text capabilities.

## Events

The bundle includes an entity listener that automatically updates the page's `updatedAt` timestamp when translations are modified.

## Internationalization

The bundle supports the following languages:
- English (en)
- French (fr)

Translation files are located in:
- `src/Resources/translations/messages.en.yml`
- `src/Resources/translations/messages.fr.yml`

## Development

### Running Tests

```bash
composer lint:phpcs
composer lint:phpstan
```

## License

This bundle is under the Apache-2.0 license. See the complete license in the bundle:

```
LICENSE
```

## Credits

- [Benard David](mailto:magicbart@gmail.com) - Developer

## Support

For support, please open an issue in the GitHub repository.