<?php

namespace TypiCMS\BootForms\Tests;

use PHPUnit\Framework\TestCase;
use TypiCMS\BootForms\Elements\InputGroup;

/**
 * @internal
 *
 * @coversNothing
 */
class InputGroupTest extends TestCase
{
    public function testCanRenderBasicText()
    {
        $input = new InputGroup('email');
        $this->assertInstanceOf('TypiCMS\Form\Elements\Text', $input);

        $expected = '<div class="input-group"><input type="text" name="email"></div>';
        $result = $input->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderBeforeAddon()
    {
        $input = new InputGroup('username');
        $this->assertEquals($input, $input->beforeAddon('@'));

        $expected = '<div class="input-group">@<input type="text" name="username"></div>';
        $result = $input->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderAfterAddonAndType()
    {
        $input = new InputGroup('mail');
        $this->assertEquals($input, $input->type('email'));
        $this->assertEquals($input, $input->afterAddon('@domain.com'));

        $expected = '<div class="input-group"><input type="email" name="mail">@domain.com</div>';
        $result = $input->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderWithValue()
    {
        $input = new InputGroup('test');
        $input = $input->value('abc');
        $expected = '<div class="input-group"><input type="text" name="test" value="abc"></div>';
        $result = $input->render();
        $this->assertEquals($expected, $result);

        $input = new InputGroup('test');
        $input = $input->value(null);
        $expected = '<div class="input-group"><input type="text" name="test"></div>';
        $result = $input->render();
        $this->assertEquals($expected, $result);
    }

    public function testDefaultValue()
    {
        $input = new InputGroup('test');
        $expected = '<div class="input-group"><input type="text" name="test" value="abc"></div>';
        $result = $input->defaultValue('abc')->render();
        $this->assertEquals($expected, $result);

        $input = new InputGroup('test');
        $expected = '<div class="input-group"><input type="text" name="test" value="xyz"></div>';
        $result = $input->value('xyz')->defaultValue('abc')->render();
        $this->assertEquals($expected, $result);

        $input = new InputGroup('test');
        $expected = '<div class="input-group"><input type="text" name="test" value="xyz"></div>';
        $result = $input->defaultValue('abc')->value('xyz')->render();
        $this->assertEquals($expected, $result);
    }
}
