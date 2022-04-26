<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;

class FormText extends Element
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
        $this->addClass('form-text');
    }

    public function render(): string
    {
        $html = '<small';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</small>';

        return $html;
    }
}
