<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;

class FormText extends Element
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->addClass('form-text');
    }

    public function render()
    {
        $html = '<small';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</small>';

        return $html;
    }
}
