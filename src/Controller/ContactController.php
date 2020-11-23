<?php declare(strict_types=1);

namespace Bone\Contact\Controller;

use Bone\Controller\Controller;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends Controller
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $body = $this->view->render('contact::index', []);

        return new HtmlResponse($body);
    }
}
