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
use Bone\User\Http\Middleware\SessionAuth;
use Bone\View\ViewRegistrationInterface;
use Doctrine\ORM\EntityManager;
use League\Route\RouteGroup;

class ContactPackage implements RegistrationInterface, RouterConfigInterface, ViewRegistrationInterface, EntityRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[ContactController::class] = $c->factory(function (Container $c) {
            $defaultLayout = $c->get('default_layout');
            $adminLayout = $c->has('admin_layout') ? $c->get('admin_layout') : $defaultLayout;

            $settings = [
                'sendThanksEmail' => true,
                'notificationEmailAddress' => 'info@thelonerganclinic.com',
                'emailLayout' => 'contact::mail-layout',
                'formLayout' => $defaultLayout,
                'adminLayout' => $adminLayout,
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

        if ($c->has(SessionAuth::class) && $c->has('bone-contact')) {
            $settings = $c->has('bone-contact') ? $c->get('bone-contact') : ['adminPages' => true];

            if ($settings['adminPages'] === true) {
                $auth = $c->get(SessionAuth::class);
                $group = $router->group('/admin/messages', function (RouteGroup $route) {
                    $route->map('GET', '/', [ContactController::class, 'messageIndex']);
                    $route->map('GET', '/{id:number}', [ContactController::class, 'view']);
                    $route->map('GET', '/{id:number}/delete', [ContactController::class, 'delete']);
                    $route->map('POST', '/{id:number}/delete', [ContactController::class, 'delete']);
                    $route->map('GET', '/{id:number}/reply', [ContactController::class, 'reply']);
                    $route->map('POST', '/{id:number}/reply', [ContactController::class, 'reply']);
                });
                $group->middlewares([$auth]);
            }
        }


        return $router;
    }
}
