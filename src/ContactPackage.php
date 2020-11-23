<?php

declare(strict_types=1);

namespace Bone\Contact;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\Contact\Controller\ContactController;
use Bone\Contact\Form\ContactForm;
use Bone\Controller\Init;
use Bone\Mail\Service\MailService;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Bone\View\ViewRegistrationInterface;

class ContactPackage implements RegistrationInterface, RouterConfigInterface, ViewRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[ContactController::class] = $c->factory(function (Container $c) {
            $settings = [
                'sendThanksEmail' => true,
                'notificationEmailAddress' => 'info@thelonerganclinic.com',
                'emailLayout' => 'contact::mail-layout',
                'formClass' => ContactForm::class
            ];

            if ($c->has('bone-contact')) {
                $settings = $c->get('bone-contact');
            }

            $formClass = $settings['formClass'];
            $form = $c->has($formClass) ? $c->get($formClass) : new $formClass('contact');
            $mailService = $c->get(MailService::class);

            return Init::controller(new ContactController($form, $settings, $mailService), $c);
        });
    }

    /**
     * @return array
     */
    public function addViews(): array
    {
        return [
            'contact' => __DIR__ . '/View',
        ];
    }

    /**
     * @param Container $c
     * @return array
     */
    public function addViewExtensions(Container $c): array
    {
        return [];
    }


    /**
     * @param Container $c
     * @param Router $router
     * @return Router
     */
    public function addRoutes(Container $c, Router $router): Router
    {
        $router->map('GET', '/contact', [ContactController::class, 'index']);
        $router->map('POST', '/contact', [ContactController::class, 'index']);

        return $router;
    }
}
