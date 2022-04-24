<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Text;

class InputGroup extends Text
{
    /**
     * @var array
     */
    protected $beforeAddon = [];

    /**
     * @var array
     */
    protected $afterAddon = [];

    public function beforeAddon(string $addon): self
    {
        $this->beforeAddon[] = $addon;

        return $this;
    }

    public function afterAddon(string $addon): self
    {
        $this->afterAddon[] = $addon;

        return $this;
    }

    public function type(string $type): self
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    protected function renderAddons(array $addons, string $class): string
    {
        $html = '';

        foreach ($addons as $addon) {
            $html .= $addon;
        }

        return $html;
    }

    public function render(): string
    {
        $html = '<div class="input-group">';
        $html .= $this->renderAddons($this->beforeAddon, 'prepend');
        $html .= parent::render();
        $html .= $this->renderAddons($this->afterAddon, 'append');
        $html .= '</div>';

        return $html;
    }
}
