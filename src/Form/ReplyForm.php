<?php

namespace Bone\Contact\Form;

use Del\Form\AbstractForm;
use Del\Form\Field\Submit;
use Del\Form\Field\Text;
use Del\Form\Field\TextArea;
use Del\Form\Renderer\HorizontalFormRenderer;

class ReplyForm extends AbstractForm
{
    public function init()
    {
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
        $submit->setClass('btn btn-lg btn-success pull-right');
        $this->addField($submit);

        $this->setFormRenderer(new HorizontalFormRenderer());

    }
}