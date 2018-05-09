<?php

namespace TypiCMS\BootForms;

use AdamWathan\Form\FormBuilder;
use TypiCMS\BootForms\Elements\CheckGroup;
use TypiCMS\BootForms\Elements\HorizontalFormGroup;
use TypiCMS\BootForms\Elements\OffsetFormGroup;

class HorizontalFormBuilder extends BasicFormBuilder
{
    protected $columnSizes;

    protected $builder;

    public function __construct(FormBuilder $builder, $columnSizes = ['lg' => [2, 10]])
    {
        $this->builder = $builder;
        $this->columnSizes = $columnSizes;
    }

    public function setColumnSizes($columnSizes)
    {
        $this->columnSizes = $columnSizes;

        return $this;
    }

    public function open()
    {
        return $this->builder->open();
    }

    protected function formGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)
            ->addClass($this->getLabelClass())
            ->addClass('col-form-label')
            ->forId($name);

        $control->id($name)->addClass('form-control');

        $formGroup = new HorizontalFormGroup($label, $control, $this->getControlSizes());

        if ($this->builder->hasError($name)) {
            $formGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $this->wrap($formGroup);
    }

    protected function getControlSizes()
    {
        $controlSizes = [];
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $controlSizes[$breakpoint] = $sizes[1];
        }

        return $controlSizes;
    }

    protected function getLabelClass()
    {
        $class = '';
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $class .= sprintf('col-%s-%s ', $breakpoint, $sizes[0]);
        }

        return trim($class);
    }

    public function button($value, $name = null, $type = 'btn-secondary')
    {
        $button = $this->builder->button($value, $name)->addClass('btn')->addClass($type);

        return new OffsetFormGroup($button, $this->columnSizes);
    }

    public function submit($value = 'Submit', $type = 'btn-primary')
    {
        $button = $this->builder->submit($value)->addClass('btn')->addClass($type);

        return new OffsetFormGroup($button, $this->columnSizes);
    }

    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);
        $checkGroup = $this->checkGroup($label, $name, $control);

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

    protected function checkGroup($label, $name, $control)
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
        $checkGroup = $this->checkGroup($label, $name, $control);

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

    public function file($label, $name, $value = null)
    {
        $control = $this->builder->file($name)->value($value);
        $label = $this->builder->label($label, $name)
            ->addClass($this->getLabelClass())
            ->addClass('col-form-label')
            ->forId($name);

        $control->id($name);

        $formGroup = new HorizontalFormGroup($label, $control, $this->getControlSizes());

        if ($this->builder->hasError($name)) {
            $formGroup->invalidFeedback($this->builder->getError($name));
            $control->addClass('is-invalid');
        }

        return $formGroup;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
