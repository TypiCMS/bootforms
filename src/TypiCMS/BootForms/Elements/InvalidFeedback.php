<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;

class InvalidFeedback extends Element
{
    /**
     * @var string
     */
    private $message;

    public function __construct($message)
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
