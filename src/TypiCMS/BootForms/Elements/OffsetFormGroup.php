<?php

namespace TypiCMS\BootForms\Elements;

class OffsetFormGroup
{
    /**
     * @var string
     */
    protected $control;

    /**
     * @var array
     */
    protected $columnSizes;

    public function __construct(string $control, array $columnSizes)
    {
        $this->control = $control;
        $this->columnSizes = $columnSizes;
    }

    public function render(): string
    {
        $html = '<div class="mb-3 row">';
        $html .= '<div class="'.$this->getControlClass().'">';
        $html .= $this->control;
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    public function setColumnSizes(array $columnSizes): self
    {
        $this->columnSizes = $columnSizes;

        return $this;
    }

    protected function getControlClass(): string
    {
        $class = '';
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $class .= sprintf('col-%s-offset-%s col-%s-%s ', $breakpoint, $sizes[0], $breakpoint, $sizes[1]);
        }

        return trim($class);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __call($method, $parameters): self
    {
        call_user_func_array([$this->control, $method], $parameters);

        return $this;
    }
}
