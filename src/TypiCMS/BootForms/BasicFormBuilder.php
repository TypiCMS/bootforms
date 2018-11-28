<?php

namespace TypiCMS\BootForms;

use TypiCMS\BootForms\Elements\CheckGroup;
use TypiCMS\BootForms\Elements\FormGroup;
use TypiCMS\BootForms\Elements\GroupWrapper;
use TypiCMS\BootForms\Elements\InputGroup;
use TypiCMS\Form\FormBuilder;

class BasicFormBuilder
{
    protected $builder;

    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function formGroup($label, $name, $control)
    {
        $label = $this->builder->label($label)->forId($name);
        $control->id($name)->addClass('form-control');

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $this->wrap($formGroup);
    }

    protected function wrap($group)
    {
        return new GroupWrapper($group);
    }

    public function text($label, $name, $value = null)
    {
        $control = $this->builder->text($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function password($label, $name)
    {
        $control = $this->builder->password($name);

        return $this->formGroup($label, $name, $control);
    }

    public function button($value, $name = null, $type = 'btn-secondary')
    {
        return $this->builder->button($value, $name)->addClass('btn')->addClass($type);
    }

    public function submit($value = 'Submit', $type = 'btn-primary')
    {
        return $this->builder->submit($value)->addClass('btn')->addClass($type);
    }

    public function select($label, $name, $options = [])
    {
        $control = $this->builder->select($name, $options);

        return $this->formGroup($label, $name, $control);
    }

    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);

        return $this->checkGroup($label, $name, $control);
    }

    public function inlineCheckbox($label, $name)
    {
        return $this->checkbox($label, $name)->inline();
    }

    protected function checkGroup($label, $name, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);

        return $this->wrap($checkGroup);
    }

    protected function buildCheckGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)->addClass('form-check-label')->forId($name);
        $control->id($name)->addClass('form-check-input');

        $checkGroup = new CheckGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $checkGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $checkGroup;
    }

    public function radio($label, $name, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);

        return $this->radioGroup($label, $name, $control);
    }

    public function inlineRadio($label, $name, $value = null)
    {
        return $this->radio($label, $name, $value)->inline();
    }

    protected function radioGroup($label, $name, $control)
    {
        $checkGroup = $this->buildRadioGroup($label, $name, $control);

        return $this->wrap($checkGroup);
    }

    protected function buildRadioGroup($label, $name, $control)
    {
        $id = $name.'_'.strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $control->getAttribute('value'))));
        $label = $this->builder->label($label, $name)->addClass('form-check-label')->forId($id);
        $control->id($id)->addClass('form-check-input');

        $checkGroup = new CheckGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $checkGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $checkGroup;
    }

    public function textarea($label, $name)
    {
        $control = $this->builder->textarea($name);

        return $this->formGroup($label, $name, $control);
    }

    public function date($label, $name, $value = null)
    {
        $control = $this->builder->date($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function dateTimeLocal($label, $name, $value = null)
    {
        $control = $this->builder->dateTimeLocal($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function email($label, $name, $value = null)
    {
        $control = $this->builder->email($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function file($label, $name, $value = null)
    {
        $control = $this->builder->file($name)->value($value);
        $label = $this->builder->label($label, $name)->forId($name);
        $control->id($name)->addClass('form-control-file');

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $this->wrap($formGroup);
    }

    public function inputGroup($label, $name, $value = null)
    {
        $control = new InputGroup($name);
        if (!is_null($value) || !is_null($value = $this->getValueFor($name))) {
            $control->value($value);
        }

        return $this->formGroup($label, $name, $control);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
