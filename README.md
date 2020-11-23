# contact
Contact package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-contact
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Contact\ContactPackage;

return [
    'packages' => [
        // packages here...,
        ContactPackage::class,
    ],
    // ...
];
```