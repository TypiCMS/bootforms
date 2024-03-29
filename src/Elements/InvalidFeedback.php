<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;

class InvalidFeedback extends Element
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
        $this->addClass('invalid-feedback');
    }

    public function render(): string
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</div>';

        return $html;
    }
}
