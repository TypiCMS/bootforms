<?php

use AdamWathan\BootForms\Elements\HelpBlock;
use PHPUnit\Framework\TestCase;

class HelpBlockTest extends TestCase
{
    public function setUp()
    {
    }

    public function testCanRenderBasicHelpBlock()
    {
        $helpBlock = new HelpBlock('Email is required.');

        $expected = '<small class="form-text">Email is required.</small>';
        $result = $helpBlock->render();
        $this->assertEquals($expected, $result);

        $helpBlock = new HelpBlock('First name is required.');

        $expected = '<small class="form-text">First name is required.</small>';
        $result = $helpBlock->render();
        $this->assertEquals($expected, $result);
    }
}
