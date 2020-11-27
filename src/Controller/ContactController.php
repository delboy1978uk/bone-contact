<?php declare(strict_types=1);

namespace Bone\Contact\Controller;

use Bone\Contact\Entity\Contact;
use Bone\Contact\Form\ReplyForm;
use Bone\Controller\Controller;
use Bone\Exception;
use Bone\Http\Response\LayoutResponse;
use Bone\Mail\EmailMessage;
use Bone\Mail\Service\MailService;
use Bone\View\Helper\AlertBox;
use Bone\View\Helper\Paginator;
use DateTime;
use Del\Form\AbstractForm;
use Del\Form\Field\Submit;
use Del\Form\Form;
use Del\Icon;
use Doctrine\ORM\EntityManager;
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

    /** @var string $formLayout */
    private $formLayout;

    /** @var string $adminLayout */
    private $adminLayout;

    /** @var bool $storeInDb */
    private $storeInDb;

    /** @var string $formClass */
    private $formClass;

    /** @var string $entityClass */
    private $entityClass;

    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var int $numPerPage */
    private $numPerPage = 10;

    /** @var Paginator $paginator */
    private $paginator;


    /**
     * ContactController constructor.
     * @param AbstractForm $form
     * @param array $settings
     */
    public function __construct(AbstractForm $form, array $settings, MailService $mailService, EntityManager $entityManager)
    {
        $this->paginator = new Paginator();
        $this->entityClass = $settings['entityClass'];
        $this->entityManager = $entityManager;
        $this->form = $form;
        $this->formClass = $settings['formClass'];
        $this->sendThanksEmail = $settings['sendThanksEmail'];
        $this->storeInDb = $settings['storeInDb'];
        $this->notificationEmailAddress = $settings['notificationEmailAddress'];
        $this->emailLayout = $settings['emailLayout'];
        $this->formLayout = $settings['formLayout'];
        $this->adminLayout = $settings['adminLayout'];
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

        return new LayoutResponse($body, $this->formLayout);
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

        if ($this->storeInDb === true && $this->entityClass === Contact::class) {
            $contact = new Contact();
            $contact->setName($data['name']);
            $contact->setTelephone($data['telephone']);
            $contact->setEmail($data['email']);
            $contact->setSubject($data['subject']);
            $contact->setMessage($data['message']);
            $contact->setDateReceived(new DateTime());
            $this->entityManager->persist($contact);
            $this->entityManager->flush($contact);

        } elseif ($this->storeInDb) {
            /** @todo hydration code */
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function messageIndex(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->entityManager->getRepository($this->entityClass);
        $total = $db->count([]);
        $this->paginator->setUrl('/admin/messages?page=:page');
        $params = $request->getQueryParams();
        $page = array_key_exists('page', $params) ? (int)$params['page'] : 1;
        $this->paginator->setCurrentPage($page);
        $this->paginator->setPageCountByTotalRecords($total, $this->numPerPage);
        $messages = $db->findBy([], ['id' => 'DESC'], $this->numPerPage, ($page * $this->numPerPage) - $this->numPerPage);

        $body = $this->view->render('contact::message-index', [
            'messages' => $messages,
            'paginator' => $this->paginator->render(),
        ]);

        return new LayoutResponse($body, $this->adminLayout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function view(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->entityManager->getRepository($this->entityClass);
        $id = $request->getAttribute('id');
        $message = $db->find($id);
        $body = $this->view->render('contact::message-view', [
            'message' => $message,
        ]);

        return new LayoutResponse($body, $this->adminLayout);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function reply(ServerRequestInterface $request): ResponseInterface
    {
        $db = $this->entityManager->getRepository($this->entityClass);
        $id = $request->getAttribute('id');
        $message = $db->find($id);
        $form = new ReplyForm('reply');
        $form->getField('subject')->setValue('Re: ' . $message->getSubject());

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $form->populate($data);

            if ($form->isValid()) {
                $data = $form->getValues();
                $this->handleReplyData($data, $message);
                $body = $this->view->render('contact::message-reply-thanks', [
                    'msg' => [Icon::CHECK_CIRCLE . ' Message successfully delivered.', 'success'],
                    'message' => $message,
                ]);

            } else {
                $body = $this->view->render('contact::message-reply', [
                    'form' => $form->render(),
                    'msg' => [Icon::WARNING . ' There was a problem with your form.', 'danger'],
                    'message' => $message,
                ]);
            }
        } else {
            $body = $this->view->render('contact::message-reply', [
                'form' => $form->render(),
                'msg' => null,
                'message' => $message,
            ]);
        }

        return new LayoutResponse($body, $this->adminLayout);
    }

    /**
     * @param array $data
     */
    private function handleReplyData(array $data, Contact $message): void
    {
        unset($data['submit']);
        $mail = $this->mailService;
        $config = $mail->getSiteConfig();
        $url = $config->getEnvironment()->getSiteURL();
        $title = $config->getTitle();
        $mail = new EmailMessage();
        $mail->setTo($this->notificationEmailAddress);
        $mail->setSubject('Sent reply to ' . $message->getName() . ' ( ' . $message->getEmail() . ')');
        $mail->setTemplate('contact::message-notification-email');
        $mail->setViewData([
            'siteUrl' => $url,
            'logo' => $config->getEmailLogo(),
            'title' => $title,
            'address' => $config->getAddress(),
            'layout' => $this->emailLayout,
            'data' => $data,
            'message' => $message,
        ]);
        $this->mailService->sendEmail($mail);

        $mail = new EmailMessage();
        $mail->setTo($message->getEmail(), $message->getName());
        $mail->setSubject($data['subject']);
        $mail->setTemplate('contact::message-reply-email');
        $mail->setViewData([
            'siteUrl' => $url,
            'title' => $title,
            'logo' => $config->getEmailLogo(),
            'address' => $config->getAddress(),
            'layout' => $this->emailLayout,
            'data' => $data,
            'message' => $message,
        ]);
        $this->mailService->sendEmail($mail);

    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface $response
     * @throws \Exception
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $db = $this->entityManager->getRepository($this->entityClass);
        $form = new Form('deleteMessage');
        $submit = new Submit('submit');
        $submit->setValue('Delete');
        $submit->setClass('btn btn-lg btn-danger');
        $form->addField($submit);
        /** @var Message $message */
        $message = $db->find($id);

        if (!$message) {
            throw new Exception(Exception::LOST_AT_SEA, 404);
        }

        $text = '';

        if ($request->getMethod() === 'POST') {
            $this->entityManager->remove($message);
            $this->entityManager->flush($message);
            $id = null;
            $msg = $this->alertBox(Icon::CHECK_CIRCLE . ' Message deleted.', 'warning');
            $form = '<a href="/admin/messages" class="btn btn-lg btn-default">Back</a>';
            $text = 'The message has been deleted';
        } else {
            $form = $form->render();
            $msg = $this->alertBox(Icon::WARNING . ' Warning, please confirm your intention to delete.', 'danger');
            $text = '<p class="lead">Are you sure you want to delete the message from ' . $message->getEmail() . '?</p>';
        }

        $body = $this->view->render('contact::message-delete', [
            'messageId' => $id,
            'form' => $form,
            'msg' => $msg,
            'text' => $text,
        ]);

        return new LayoutResponse($body, $this->adminLayout);
    }

    /**
     * @param string $message
     * @param string $class
     * @return string
     */
    private function alertBox(string $message, string $class): string
    {
        $helper = new AlertBox();

        return $helper->alertBox([
            'message' => $message,
            'class' => $class,
        ]);
    }
}
