<?php

namespace TypiCMS\BootForms;

use TypiCMS\Form\Elements\FormOpen;

class BootForm
{
    protected BasicFormBuilder $builder;

    protected BasicFormBuilder $basicFormBuilder;

    protected HorizontalFormBuilder $horizontalFormBuilder;

    public function __construct(BasicFormBuilder $basicFormBuilder, HorizontalFormBuilder $horizontalFormBuilder)
    {
        $this->basicFormBuilder = $basicFormBuilder;
        $this->horizontalFormBuilder = $horizontalFormBuilder;
    }

    public function open(): FormOpen
    {
        $this->builder = $this->basicFormBuilder;

        return $this->builder->open();
    }

    public function openHorizontal(array $columnSizes): FormOpen
    {
        $this->horizontalFormBuilder->setColumnSizes($columnSizes);
        $this->builder = $this->horizontalFormBuilder;

        return $this->builder->open();
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
