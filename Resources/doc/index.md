
## Introduction

ContentBundle provides components that help displaying and working with products, categories and content.

### Setup

Setup documentation for the Content bundle can be found [here](setup.md).

###Content twig functions

```php
{{ snippet('home-page', 'AcmeDemoBundle:Default:index.html.twig') }}
```
This would render content from a document that has a slug property set to `'home-page'`. 

> Template parameter is optional. [Default](https://github.com/ongr-io/ContentBundle/blob/master/Resources/views/Content/plain_cms_snippet.html.twig) would be used.

You can also retrieve multiple contents:

```php
{{ getContentsBySlugs(['home-page', 'about-us']) }}
```

But this function does not render into a view, it only retrieves array of content documents that matched the one of the given slugs.

###Category twig functions

```php
{{ getCategoryTree('AcmeDemoBundle:Category:tree.html.twig', 2, 'category_id') }}
```

This function renders category tree. Parameters:
- `template` (optional): Twig template used for rendering view.
- `maxLevel` (optional): Maximum tree level.
- `selectedCategory` (optional): Selected category id.

> When rendering new tree selected category will have a property `current` with a value of true.

```php
{{ renderCategoryTree(tree, selectedCategory, currentCategory, template) }}
```
Renders tree from given tree array. Parameters:
- `tree`: Array of category documents.
- `selectedCategory` (optional): Selected category id.
- `currentCategory` (optional): Current category document.
- `template` (optional): Twig template used for rendering view.

If no template is passed it would check if it has saved from last call. It is saved when `getCategoryTree` function is called.

```php
{{ getCategoryChildTree(template, maxLevel, selectedCategory, fromCategory) }}
```

Renders tree starting from particular category. Parameters:
- `template` (optional): Twig template used for rendering view.
- `maxLevel` (optional): Maximum tree level.
- `selectedCategory` (optional): Selected category id.
- `fromCategory` (optional): Creates tree from this particular category id.