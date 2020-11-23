<?php

namespace Bone\Contact\Form;

use Del\Form\AbstractForm;
use Del\Form\Field\Submit;
use Del\Form\Field\Text;
use Del\Form\Field\Text\EmailAddress;
use Del\Form\Field\TextArea;
use Del\Form\Renderer\HorizontalFormRenderer;

class ContactForm extends AbstractForm
{
    public function init()
    {
        $name = new Text('name');
        $name->setRequired(true);
        $name->setLabel('Name');
        $name->setPlaceholder('Type your name...');
        $this->addField($name);

        $email = new EmailAddress('email');
        $email->setRequired(true);
        $email->setLabel('Email');
        $email->setPlaceholder('Type your email..');
        $email->setCustomErrorMessage('Please enter a valid email address.');
        $this->addField($email);

        $tel = new Text('telephone');
        $tel->setLabel('Telephone');
        $tel->setPlaceholder('e.g. 07890123456..');
        $this->addField($tel);

        $subject = new Text('subject');
        $subject->setRequired(true);
        $subject->setLabel('Subject');
        $subject->setPlaceholder('Type a message subject..');
        $this->addField($subject);

        $message = new TextArea('message');
        $message->setRequired(true);
        $message->setLabel('Message');
        $message->setPlaceholder('Type your message..');
        $this->addField($message);

        $submit = new Submit('submit');
        $submit->setValue('Send');
        $this->addField($submit);

        $this->setFormRenderer(new HorizontalFormRenderer());

    }
}