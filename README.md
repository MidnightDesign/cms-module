CMS Module for Zend Framework 2
===============================
Installation
------------
1. Install the module via Composer.
2. Add the following dependencies to your `config/application.config.php`:

        'ZfcAdmin',
        'AssetManager',
        'Midnight\AdminModule',
        'Midnight\Wysiwyg',
        'Midnight\CmsModule',

3. Make sure the directories `data/pages` and `data/blocks` are writable.

In your browser, go to `/admin/cms`.

