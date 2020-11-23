<?php

declare(strict_types=1);

namespace Bone\Contact;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Contact\Controller\ContactApiController;
use Bone\Contact\Controller\ContactController;
use Bone\Controller\Init;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Bone\View\ViewEngine;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class ContactPackage implements RegistrationInterface, RouterConfigInterface, EntityRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        /** @var ViewEngine $viewEngine */
        $viewEngine = $c->get(ViewEngine::class);
        $viewEngine->addFolder('contact', __DIR__ . '/View/Contact/');

        $c[ContactController::class] = $c->factory(function (Container $c) {
            return Init::controller(new ContactController(), $c);
        });

        $c[ContactApiController::class] = $c->factory(function (Container $c) {
            return new ContactApiController();
        });
    }

    /**
     * @param Container $c
     * @param Router $router
     * @return Router
     */
    public function addRoutes(Container $c, Router $router): Router
    {
        $router->map('GET', '/contact', [ContactController::class, 'indexAction']);

        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api', function (RouteGroup $route) {
            $route->map('GET', '/contact', [ContactApiController::class, 'indexAction']);
        })
        ->setStrategy($strategy);

        return $router;
    }
}
