<?php

use AdamWathan\BootForms\Elements\InvalidFeedback;
use PHPUnit\Framework\TestCase;

class InvalidFeedbackTest extends TestCase
{
    public function setUp()
    {
    }

    public function testCanRenderBasicInvalidFeedback()
    {
        $helpBlock = new InvalidFeedback('Email is required.');

        $expected = '<div class="invalid-feedback">Email is required.</div>';
        $result = $helpBlock->render();
        $this->assertEquals($expected, $result);

        $helpBlock = new InvalidFeedback('First name is required.');

        $expected = '<div class="invalid-feedback">First name is required.</div>';
        $result = $helpBlock->render();
        $this->assertEquals($expected, $result);
    }
}
