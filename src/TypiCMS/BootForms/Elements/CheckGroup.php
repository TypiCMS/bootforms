<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;
use TypiCMS\Form\Elements\Label;

class CheckGroup extends FormGroup
{
    protected $label;

    protected $control;

    public function __construct(Label $label, Element $control)
    {
        $this->label = $label;
        $this->control = $control;
        $this->addClass('form-check');
    }

    public function render()
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->control;
        $html .= $this->label;
        $html .= $this->renderInvalidFeedback();
        $html .= $this->renderFormText();
        $html .= '</div>';

        return $html;
    }

    public function inline()
    {
        $this->addClass('form-check-inline');

        return $this;
    }

    public function control()
    {
        return $this->control;
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->control, $method], $parameters);

        return $this;
    }
}
