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
Create `config/bone-contact.php` to your `config` folder, and tweak as required:
```php
<?php

return [
    'bone-contact' => [
        'sendThanksEmail' => true,
        'notificationEmailAddress' => 'your-email-address@example.com',
        'emailLayout' => 'contact::mail-layout',
        'formClass' => \Bone\Contact\Form\ContactForm::class
    ],
];
```
You can reach the contact page by browsing to `/contact`. You can add a custom class for the form which will
be called from the Container, or a new one instantiated if not.
### overriding view files
Add to your `config/views.php`:
```php
return [
    'views' => [
        // other views here 
        'contact' => 'path/to/replacement/views',
    ],
];
```
