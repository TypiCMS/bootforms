<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class CheckGroup extends FormGroup
{
    protected $label;
    protected $control;
    protected $inline = false;

    public function __construct(Label $label, Element $control)
    {
        $this->label = $label;
        $this->control = $control;
    }

    public function render()
    {
        if ($this->inline === true) {
            return $this->label->render();
        }

        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->control;
        $html .= $this->label;
        $html .= $this->renderHelpBlock();

        $html .= '</div>';

        return $html;
    }

    public function inline()
    {
        $this->inline = true;

        $class = $this->control()->getAttribute('type') . '-inline';
        $this->label->removeClass('control-label')->addClass($class);

        return $this;
    }

    public function control()
    {
        return $this->label->getControl();
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->label->getControl(), $method], $parameters);
        return $this;
    }
}
