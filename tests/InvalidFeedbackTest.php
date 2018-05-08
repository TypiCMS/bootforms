<?php

use TypiCMS\BootForms\Elements\InvalidFeedback;
use PHPUnit\Framework\TestCase;

class InvalidFeedbackTest extends TestCase
{
    public function setUp()
    {
    }

    public function testCanRenderBasicInvalidFeedback()
    {
        $formText = new InvalidFeedback('Email is required.');

        $expected = '<div class="invalid-feedback">Email is required.</div>';
        $result = $formText->render();
        $this->assertEquals($expected, $result);

        $formText = new InvalidFeedback('First name is required.');

        $expected = '<div class="invalid-feedback">First name is required.</div>';
        $result = $formText->render();
        $this->assertEquals($expected, $result);
    }
}
