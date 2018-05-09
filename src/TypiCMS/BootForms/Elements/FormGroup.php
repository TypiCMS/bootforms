<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;
use TypiCMS\Form\Elements\Label;

class FormGroup extends Element
{
    protected $label;
    protected $control;
    protected $formText;
    protected $invalidFeedback;

    public function __construct(Label $label, Element $control)
    {
        $this->label = $label;
        $this->control = $control;
        $this->addClass('form-group');
    }

    public function render()
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->label;
        $html .= $this->control;
        $html .= $this->renderInvalidFeedback();
        $html .= $this->renderFormText();
        $html .= '</div>';

        return $html;
    }

    public function formText($text)
    {
        if (isset($this->formText)) {
            return;
        }
        $this->formText = new FormText($text);

        return $this;
    }

    protected function renderFormText()
    {
        if ($this->formText) {
            return $this->formText->render();
        }

        return '';
    }

    public function invalidFeedback($text)
    {
        if (isset($this->invalidFeedback)) {
            return;
        }
        $this->invalidFeedback = new InvalidFeedback($text);

        return $this;
    }

    protected function renderInvalidFeedback()
    {
        if ($this->invalidFeedback) {
            return $this->invalidFeedback->render();
        }

        return '';
    }

    public function control()
    {
        return $this->control;
    }

    public function label()
    {
        return $this->label;
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->control, $method], $parameters);

        return $this;
    }
}
