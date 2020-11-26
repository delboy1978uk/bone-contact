<?php

declare(strict_types=1);

namespace Bone\Contact;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Contact\Controller\ContactController;
use Bone\Contact\Form\ContactForm;
use Bone\Controller\Init;
use Bone\Mail\Service\MailService;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Bone\View\ViewRegistrationInterface;
use Doctrine\ORM\EntityManager;

class ContactPackage implements RegistrationInterface, RouterConfigInterface, ViewRegistrationInterface, EntityRegistrationInterface
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
            $entityManager = $c->get(EntityManager::class);

            return Init::controller(new ContactController($form, $settings, $mailService, $entityManager), $c);
        });
    }

    /**
     * @return string
     */
    public function getEntityPath(): string
    {
        return __DIR__ . '/Entity';
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
        $router->map('GET', '/admin/messages', [ContactController::class, 'messageIndex']);
        $router->map('GET', '/admin/messages/{id:number}', [ContactController::class, 'view']);
        $router->map('GET', '/admin/messages/{id:number}/delete', [ContactController::class, 'delete']);
        $router->map('POST', '/admin/messages/{id:number}/delete', [ContactController::class, 'delete']);
        $router->map('GET', '/admin/messages/{id:number}/reply', [ContactController::class, 'reply']);
        $router->map('POST', '/admin/messages/{id:number}/reply', [ContactController::class, 'reply']);

        return $router;
    }
}
