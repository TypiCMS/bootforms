<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Element;
use TypiCMS\Form\Elements\Label;

class HorizontalFormGroup extends FormGroup
{
    protected array $controlSizes;

    public function __construct(Label $label, Element $control, array $controlSizes)
    {
        parent::__construct($label, $control);
        $this->controlSizes = $controlSizes;
        $this->addClass('row');
    }

    public function render(): string
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->label;
        $html .= '<div class="' . $this->getControlClass() . '">';
        $html .= $this->control;
        $html .= $this->renderInvalidFeedback();
        $html .= $this->renderFormText();
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    protected function getControlClass(): string
    {
        $class = '';
        foreach ($this->controlSizes as $breakpoint => $size) {
            $class .= sprintf('col-%s-%s ', $breakpoint, $size);
        }

        return trim($class);
    }

    public function __call($method, $parameters): self
    {
        call_user_func_array([$this->control, $method], $parameters);

        return $this;
    }
}
