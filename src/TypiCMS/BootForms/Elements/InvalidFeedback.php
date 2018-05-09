<?php

namespace TypiCMS\BootForms\Elements;

use AdamWathan\Form\Elements\Element;

class InvalidFeedback extends Element
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->addClass('invalid-feedback');
    }

    public function render()
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</div>';

        return $html;
    }
}
