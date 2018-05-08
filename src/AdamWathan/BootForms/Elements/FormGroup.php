<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class FormGroup extends Element
{
    protected $label;
    protected $control;
    protected $helpBlock;
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
        $html .= $this->renderHelpBlock();
        $html .= '</div>';

        return $html;
    }

    public function helpBlock($text)
    {
        if (isset($this->helpBlock)) {
            return;
        }
        $this->helpBlock = new HelpBlock($text);
        return $this;
    }

    protected function renderHelpBlock()
    {
        if ($this->helpBlock) {
            return $this->helpBlock->render();
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
