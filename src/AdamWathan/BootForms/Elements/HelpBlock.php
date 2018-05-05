<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;

class HelpBlock extends Element
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
