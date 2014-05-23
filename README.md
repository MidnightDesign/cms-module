CMS Module for Zend Framework 2
===============================
Installation
------------
1. Install the module via Composer.
2. Add the following dependencies to your `config/application.config.php`:

        'Midnight\Wysiwyg',
        'ZfcAdmin',
        'AssetManager',
        'Midnight\AdminModule',
        'DoctrineModule',
        'DoctrineORMModule',
        'Midnight\UserModule',
        'ZfcRbac',
        'Midnight\CmsModule',

3. Make sure the directories `data/cms/pages` and `data/cms/blocks` exist and are writable.
4. Make sure your Doctrine connection (orm_default) is set up correctly.
5. Create the new tables by running "vendor/bin/doctrine-module orm:schema:update --force"
6. Create a new user programmatically: (Yes, this is awful and should be handled differently)

        $this
            ->getServiceLocator()
            ->get('user.service')
            ->register('jim@example.com', 'password-here');
            
7. Make sure you load jQuery in your layout.
        
Now you can go to `/admin/cms` and log in with the user you've just created.

