Content Bundle
==============

.. toctree::
    :titlesonly:
    :maxdepth: 1
    :glob:

    *

..

Introduction
------------

ContentBundle provides components that help displaying and working with products, categories and content.

Content twig functions
----------------------

.. code-block:: twig

    {{ snippet('home-page', 'AcmeDemoBundle:Default:index.html.twig') }}

..

This would render content from a document that has a slug property set to `'home-page'`. 

.. note::  Template parameter is optional. `Default <https://github.com/ongr-io/ContentBundle/blob/master/Resources/views/Content/plain_cms_snippet.html.twig>`_ would be used.

You can also retrieve multiple contents:

.. code-block:: twig

    {{ getContentsBySlugs(['home-page', 'about-us']) }}

..

But this function does not render into a view, it only retrieves array of content documents that matched the one of the given slugs.

Category twig functions
-----------------------

.. code-block:: twig

    {{ getCategoryTree('AcmeDemoBundle:Category:tree.html.twig', 2, 'category_id') }}

..

This function renders category tree. Parameters:
 - ``template`` (optional): Twig template used for rendering view. Default: *ONGRContentBundle:Category:inc/categorytree.html.twig*
 - ``maxLevel`` (optional): Maximum tree level. Unlimited if zero. Default: *0*.
 - ``selectedCategory`` (optional): Selected category id. Default: *null*

.. note:: When rendering new tree selected category will have a property ``current`` with a value of true.

.. code-block:: twig

    {{ renderCategoryTree(tree, selectedCategory, currentCategory, template) }}

..

Renders tree from given tree array. Parameters:
 - ``tree``: Array of category documents.
 - ``selectedCategory`` (optional): Selected category id. Default: *null*
 - ``currentCategory`` (optional): Current category document. Default: *null*
 - ``template`` (optional): Twig template used for rendering view.

If no template is passed it would check if it has saved from last call. It is saved when ``getCategoryTree`` function is called.

.. code-block:: twig

    {{ getCategoryChildTree(template, maxLevel, selectedCategory, fromCategory) }}

..

Renders tree starting from particular category. Parameters:
 - ``template`` (optional): Twig template used for rendering view. Default *ONGRCategoryBundle:Category:inc/categorytree.html.twig*
 - ``maxLevel`` (optional): Maximum tree level. Default: *0*
 - ``selectedCategory`` (optional): Selected category id. Default: *null*
 - ``fromCategory`` (optional): Creates tree from this particular category id. Default: *null*
