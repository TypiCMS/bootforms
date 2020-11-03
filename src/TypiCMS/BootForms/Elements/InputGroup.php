<?php

namespace TypiCMS\BootForms\Elements;

use TypiCMS\Form\Elements\Text;

class InputGroup extends Text
{
    protected $beforeAddon = [];

    protected $afterAddon = [];

    public function beforeAddon($addon)
    {
        $this->beforeAddon[] = $addon;

        return $this;
    }

    public function afterAddon($addon)
    {
        $this->afterAddon[] = $addon;

        return $this;
    }

    public function type($type)
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    protected function renderAddons($addons, $class)
    {
        $html = '';

        foreach ($addons as $addon) {
            $html .= $addon;
        }

        return $html;
    }

    public function render()
    {
        $html = '<div class="input-group">';
        $html .= $this->renderAddons($this->beforeAddon, 'prepend');
        $html .= parent::render();
        $html .= $this->renderAddons($this->afterAddon, 'append');
        $html .= '</div>';

        return $html;
    }
}
