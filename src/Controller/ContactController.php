<?php declare(strict_types=1);

namespace Bone\Contact\Controller;

use Bone\Controller\Controller;
use Bone\Mail\EmailMessage;
use Bone\Mail\Service\MailService;
use Del\Form\AbstractForm;
use Del\Icon;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends Controller
{
    /** @var AbstractForm $form */
    private $form;

    /** @var bool $sendThanksEmail */
    private $sendThanksEmail;

    /** @var string $notificationEmailAddress */
    private $notificationEmailAddress;

    /** @var MailService $mailService */
    private $mailService;

    /** @var string $emailLayout */
    private $emailLayout;

    /**
     * ContactController constructor.
     * @param AbstractForm $form
     * @param array $settings
     */
    public function __construct(AbstractForm $form, array $settings, MailService $mailService)
    {
        $this->form = $form;
        $this->sendThanksEmail = $settings['sendThanksEmail'];
        $this->notificationEmailAddress = $settings['notificationEmailAddress'];
        $this->emailLayout = $settings['emailLayout'];
        $this->mailService = $mailService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->form->populate($data);

            if ($this->form->isValid()) {
                $data = $this->form->getValues();
                $this->handleFormData($data);
                $body = $this->view->render('contact::thanks', [
                    'message' => [Icon::CHECK_CIRCLE . ' Message successfully delivered.', 'success'],
                ]);

            } else {
                $body = $this->view->render('contact::index', [
                    'form' => $this->form->render(),
                    'message' => [Icon::WARNING . ' There was a problem with your form.', 'danger'],
                ]);
            }
        } else {
            $body = $this->view->render('contact::index', [
                'form' => $this->form->render(),
                'message' => null,
            ]);
        }

        return new HtmlResponse($body);
    }

    /**
     * @param array $data
     */
    private function handleFormData(array $data): void
    {
        unset($data['submit']);
        $mail = $this->mailService;
        $config = $mail->getSiteConfig();
        $url = $config->getEnvironment()->getSiteURL();
        $title = $config->getTitle();
        $mail = new EmailMessage();
        $mail->setTo($this->notificationEmailAddress);
        $mail->setSubject('New message from ' . $data['name']);
        $mail->setTemplate('contact::notification-email');
        $mail->setViewData([
            'siteUrl' => $url,
            'logo' => $config->getEmailLogo(),
            'title' => $title,
            'address' => $config->getAddress(),
            'layout' => $this->emailLayout,
            'data' => $data
        ]);
        $this->mailService->sendEmail($mail);

        if ($this->sendThanksEmail) {
            $mail = new EmailMessage();
            $mail->setTo($data['email']);
            $mail->setSubject('Thanks for contacting ' . $title);
            $mail->setTemplate('contact::thanks-email');
            $mail->setViewData([
                'siteUrl' => $url,
                'title' => $title,
                'logo' => $config->getEmailLogo(),
                'address' => $config->getAddress(),
                'layout' => $this->emailLayout,
                'data' => $data
            ]);
            $this->mailService->sendEmail($mail);
        }
    }
}
