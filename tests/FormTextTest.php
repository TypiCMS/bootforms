<?php

namespace TypiCMS\BootForms\Tests;

use PHPUnit\Framework\TestCase;
use TypiCMS\BootForms\Elements\FormText;

/**
 * @internal
 * @coversNothing
 */
class FormTextTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testCanRenderBasicFormText()
    {
        $formText = new FormText('Email is required.');

        $expected = '<small class="form-text">Email is required.</small>';
        $result = $formText->render();
        $this->assertEquals($expected, $result);

        $formText = new FormText('First name is required.');

        $expected = '<small class="form-text">First name is required.</small>';
        $result = $formText->render();
        $this->assertEquals($expected, $result);
    }
}
