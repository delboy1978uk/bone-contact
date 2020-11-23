<?php

declare(strict_types=1);

namespace Bone\Contact;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\Contact\Controller\ContactController;
use Bone\Controller\Init;
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
            return Init::controller(new ContactController(), $c);
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
        $router->map('GET', '/contact', [ContactController::class, 'indexAction']);

        return $router;
    }
}
