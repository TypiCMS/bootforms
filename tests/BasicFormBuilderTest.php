<?php

namespace TypiCMS\BootForms\Tests;

use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypiCMS\BootForms\BasicFormBuilder;
use TypiCMS\Form\FormBuilder;

/**
 * @internal
 *
 * @coversNothing
 */
class BasicFormBuilderTest extends TestCase
{
    private $form;

    private $builder;

    public function setUp(): void
    {
        $this->builder = new FormBuilder();
        $this->form = new BasicFormBuilder($this->builder);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testRenderTextGroup()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithValue()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email" value="example@example.com"></div>';
        $result = $this->form->text('Email', 'email')->value('example@example.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Email is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control is-invalid" id="email"><div class="invalid-feedback">Email is required.</div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithErrorAndCustomFormText()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Email is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control is-invalid" id="email"><div class="invalid-feedback">Email is required.</div><small class="form-text">some custom text</small></div>';
        $result = $this->form->text('Email', 'email')->formText('some custom text')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" value="example@example.com" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInputAndDefaultValue()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" value="example@example.com" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->defaultValue('test@test.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithDefaultValue()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email" value="test@test.com"></div>';
        $result = $this->form->text('Email', 'email')->defaultValue('test@test.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInputAndError()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Email is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" value="example@example.com" class="form-control is-invalid" id="email"><div class="invalid-feedback">Email is required.</div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroup()
    {
        $expected = '<div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" name="password" class="form-control" id="password"></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupDoesntKeepOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('password');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" name="password" class="form-control" id="password"></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Password is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="password" class="form-label">Password</label><input type="password" name="password" class="form-control is-invalid" id="password"><div class="invalid-feedback">Password is required.</div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButton()
    {
        $expected = '<button type="button" class="btn btn-secondary">Click Me</button>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithNameAndAlternateStyling()
    {
        $expected = '<button type="button" name="success" class="btn btn-success">Click Me</button>';
        $result = $this->form->button('Click Me', 'success', 'btn-success')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSubmit()
    {
        $expected = '<button type="submit" class="btn btn-primary">Submit</button>';
        $result = $this->form->submit()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSubmitWithAlternateStyling()
    {
        $expected = '<button type="submit" class="btn btn-success">Submit</button>';
        $result = $this->form->submit('Submit', 'btn-success')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSubmitWithValue()
    {
        $expected = '<button type="submit" class="btn btn-success">Sign Up</button>';
        $result = $this->form->submit('Sign Up', 'btn-success')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelect()
    {
        $expected = '<div class="mb-3"><label for="color" class="form-label">Favorite Color</label><select name="color" class="form-select" id="color"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithSelected()
    {
        $expected = '<div class="mb-3"><label for="color" class="form-label">Favorite Color</label><select name="color" class="form-select" id="color"><option value="1">Red</option><option value="2">Green</option><option value="3" selected>Blue</option></select></div>';
        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->select('3')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Color is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="color" class="form-label">Favorite Color</label><select name="color" class="form-select is-invalid" id="color"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select><div class="invalid-feedback">Color is required.</div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('2');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="color" class="form-label">Favorite Color</label><select name="color" class="form-select" id="color"><option value="1">Red</option><option value="2" selected>Green</option><option value="3">Blue</option></select></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckbox()
    {
        $expected = '<div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input"><label class="form-check-label" for="terms">Agree to Terms</label></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Must agree to terms.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input is-invalid"><label class="form-check-label" for="terms">Agree to Terms</label><div class="invalid-feedback">Must agree to terms.</div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('1');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" checked="checked"><label class="form-check-label" for="terms">Agree to Terms</label></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxChecked()
    {
        $expected = '<div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" checked="checked"><label class="form-check-label" for="terms">Agree to Terms</label></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadio()
    {
        $expected = '<div class="form-check"><input type="radio" name="color" value="red" id="color_red" class="form-check-input"><label class="form-check-label" for="color_red">Red</label></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-check"><input type="radio" name="color" value="red" id="color_red" class="form-check-input is-invalid"><label class="form-check-label" for="color_red">Red</label><div class="invalid-feedback">Sample error</div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('red');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-check"><input type="radio" name="color" value="red" id="color_red" class="form-check-input" checked="checked"><label class="form-check-label" for="color_red">Red</label></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextarea()
    {
        $expected = '<div class="mb-3"><label for="bio" class="form-label">Bio</label><textarea name="bio" rows="10" cols="50" class="form-control" id="bio"></textarea></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithRows()
    {
        $expected = '<div class="mb-3"><label for="bio" class="form-label">Bio</label><textarea name="bio" rows="5" cols="50" class="form-control" id="bio"></textarea></div>';
        $result = $this->form->textarea('Bio', 'bio')->rows(5)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithCols()
    {
        $expected = '<div class="mb-3"><label for="bio" class="form-label">Bio</label><textarea name="bio" rows="10" cols="20" class="form-control" id="bio"></textarea></div>';
        $result = $this->form->textarea('Bio', 'bio')->cols(20)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('Sample bio');

        $this->builder->setOldInputProvider($oldInput);
        $expected = '<div class="mb-3"><label for="bio" class="form-label">Bio</label><textarea name="bio" rows="10" cols="50" class="form-control" id="bio">Sample bio</textarea></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="mb-3"><label for="bio" class="form-label">Bio</label><textarea name="bio" rows="10" cols="50" class="form-control is-invalid" id="bio"></textarea><div class="invalid-feedback">Sample error</div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineCheckboxFallback()
    {
        $expected = '<div class="form-check form-check-inline"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input"><label class="form-check-label" for="terms">Agree to Terms</label></div>';
        $result = $this->form->inlineCheckbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineCheckboxFallbackWithChaining()
    {
        $expected = '<div class="form-check form-check-inline"><input type="checkbox" name="DJ" value="meal" id="DJ" class="form-check-input" chain="link" checked="checked"><label class="form-check-label" for="DJ">Checkit!</label></div>';
        $result = $this->form->inlineCheckbox('Checkit!', 'DJ')->value('meal')->chain('link')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineCheckboxModifier()
    {
        $expected = '<div class="form-check form-check-inline"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input"><label class="form-check-label" for="terms">Agree to Terms</label></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->inline()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineCheckboxModifierWithChaining()
    {
        $expected = '<div class="form-check form-check-inline"><input type="checkbox" name="DJ" value="meal" id="DJ" class="form-check-input" chain="link" checked="checked"><label class="form-check-label" for="DJ">Checkit!</label></div>';
        $result = $this->form->checkbox('Checkit!', 'DJ')->inline()->value('meal')->chain('link')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineRadioFallback()
    {
        $expected = '<div class="form-check form-check-inline"><input type="radio" name="color" value="Red" id="color_red" class="form-check-input"><label class="form-check-label" for="color_red">Red</label></div>';
        $result = $this->form->inlineRadio('Red', 'color')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineRadioFallbackWithChaining()
    {
        $expected = '<div class="form-check form-check-inline"><input type="radio" name="colour" value="Canada Red" id="colour_canada_red" class="form-check-input" chain="link" checked="checked"><label class="form-check-label" for="colour_canada_red">Canada Red</label></div>';
        $result = $this->form->inlineRadio('Canada Red', 'colour')->chain('link')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineRadioModifier()
    {
        $expected = '<div class="form-check form-check-inline"><input type="radio" name="color" value="Red" id="color_red" class="form-check-input"><label class="form-check-label" for="color_red">Red</label></div>';
        $result = $this->form->radio('Red', 'color')->inline()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineRadioModifierWithChaining()
    {
        $expected = '<div class="form-check form-check-inline"><input type="radio" name="colour" value="Canada Red" id="colour_canada_red" class="form-check-input" chain="link" checked="checked"><label class="form-check-label" for="colour_canada_red">Canada Red</label></div>';
        $result = $this->form->radio('Canada Red', 'colour')->inline()->chain('link')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInlineModifierOnUnsupportedElement()
    {
        $expected = '<div class="mb-3"><label for="name" class="form-label">Name</label><input type="text" name="name" class="form-control" id="name" inline="inline"></div>';
        $result = $this->form->text('Name', 'name')->inline()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpen()
    {
        $expected = '<form method="POST" action="">';
        $result = $this->form->open()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenGet()
    {
        $expected = '<form method="GET" action="">';
        $result = $this->form->open()->get()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenCustomAction()
    {
        $expected = '<form method="POST" action="/login">';
        $result = $this->form->open()->action('/login')->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormClose()
    {
        $expected = '</form>';
        $result = $this->form->close();
        $this->assertEquals($expected, $result);
    }

    public function testCsrfToken()
    {
        $this->form->setToken('1234');
        $expected = '<input type="hidden" name="_token" value="1234">';
        $result = $this->form->token();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenPut()
    {
        $expected = '<form method="POST" action=""><input type="hidden" name="_method" value="PUT">';
        $result = $this->form->open()->put()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenDelete()
    {
        $expected = '<form method="POST" action=""><input type="hidden" name="_method" value="DELETE">';
        $result = $this->form->open()->delete()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderDateGroup()
    {
        $expected = '<div class="mb-3"><label for="birthday" class="form-label">Birthday</label><input type="date" name="birthday" class="form-control" id="birthday"></div>';
        $result = $this->form->date('Birthday', 'birthday')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderDateTimeLocalGroup()
    {
        $expected = '<div class="mb-3"><label for="dob" class="form-label">Date & time of birth</label><input type="datetime-local" name="dob" class="form-control" id="dob"></div>';
        $result = $this->form->dateTimeLocal('Date & time of birth', 'dob')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderEmailGroup()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" name="email" class="form-control" id="email"></div>';
        $result = $this->form->email('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroup()
    {
        $expected = '<div class="mb-3"><label for="file" class="form-label">File</label><input type="file" name="file" id="file" class="form-control"></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="mb-3"><label for="file" class="form-label">File</label><input type="file" name="file" id="file" class="form-control is-invalid"><div class="invalid-feedback">Sample error</div></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanAddClassToUnderlyingControl()
    {
        $expected = '<div class="mb-3"><label for="color" class="form-label">Favorite Color</label><select name="color" class="form-select my-class" id="color"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->addClass('my-class')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithLabelClass()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label required">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->labelClass('required')->render();
        $this->assertEquals($expected, $result);
    }

    public function testBindObject()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);
        $expected = '<div class="mb-3"><label for="first_name" class="form-label">First Name</label><input type="text" name="first_name" value="John" class="form-control" id="first_name"></div>';
        $result = $this->form->text('First Name', 'first_name')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanHideLabels()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label visually-hidden">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->hideLabel()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRequiredLabels()
    {
        $expected = '<div class="mb-3"><label for="email" class="form-label form-label-required">Email</label><input type="text" name="email" class="form-control" id="email" required="required"></div>';
        $result = $this->form->text('Email', 'email')->required()->render();
        $this->assertEquals($expected, $result);

        $expected = '<div class="mb-3"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->required(false)->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanAddGroupClass()
    {
        $expected = '<div class="mb-3 test-class"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->addGroupClass('test-class')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRemoveGroupClass()
    {
        $expected = '<div><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->removeGroupClass('mb-3')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanSetGroupData()
    {
        $expected = '<div class="mb-3" data-test="1"><label for="email" class="form-label">Email</label><input type="text" name="email" class="form-control" id="email"></div>';
        $result = $this->form->text('Email', 'email')->groupData('test', 1)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithBeforeAddon()
    {
        $expected = '<div class="mb-3"><label for="username" class="form-label">Username</label><div class="input-group">@<input type="text" name="username" class="form-control" id="username"></div></div>';
        $result = $this->form->inputGroup('Username', 'username')->beforeAddon('@')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithAfterAddon()
    {
        $expected = '<div class="mb-3"><label for="site" class="form-label">Site</label><div class="input-group"><input type="text" name="site" class="form-control" id="site">.com.br</div></div>';
        $result = $this->form->inputGroup('Site', 'site')->afterAddon('.com.br')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupChangeTypeWithBothAddon()
    {
        $expected = '<div class="mb-3"><label for="secret" class="form-label">Secret</label><div class="input-group">before<input type="password" name="secret" class="form-control" id="secret">after</div></div>';
        $result = $this->form
            ->inputGroup('Secret', 'secret')
            ->type('password')
            ->beforeAddon('before')
            ->afterAddon('after')
            ->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithValue()
    {
        $expected = '<div class="mb-3"><label for="test" class="form-label">Test</label><div class="input-group"><input type="text" name="test" class="form-control" id="test" value="abc"></div></div>';
        $result = $this->form->inputGroup('Test', 'test')->value('abc')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('xyz');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="test" class="form-label">Test</label><div class="input-group"><input type="text" name="test" value="xyz" class="form-control" id="test"></div></div>';
        $result = $this->form->inputGroup('Test', 'test')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithOldInputAndDefaultValue()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('xyz');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="test" class="form-label">Test</label><div class="input-group"><input type="text" name="test" value="xyz" class="form-control" id="test"></div></div>';
        $result = $this->form->inputGroup('Test', 'test')->defaultValue('acb')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithDefaultValue()
    {
        $expected = '<div class="mb-3"><label for="test" class="form-label">Test</label><div class="input-group"><input type="text" name="test" class="form-control" id="test" value="acb"></div></div>';
        $result = $this->form->inputGroup('Test', 'test')->defaultValue('acb')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderInputGroupWithOldInputAndError()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('abc');

        $this->builder->setOldInputProvider($oldInput);

        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Test is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="test" class="form-label">Test</label><div class="input-group"><input type="text" name="test" value="abc" class="form-control is-invalid" id="test"></div><div class="invalid-feedback">Test is required.</div></div>';
        $result = $this->form->inputGroup('Test', 'test')->render();
        $this->assertEquals($expected, $result);
    }

    public function testModifyingDifferentElementsOfAFormGroup()
    {
        $expected = '<div class="mb-3 foo" data-foo="bar"><label for="email" class="form-label bar" data-bar="baz">Email</label><input type="text" name="email" class="form-control baz" id="email" data-baz="foo"></div>';
        $result = $this->form->text('Email', 'email')
            ->group()->addClass('foo')->data('foo', 'bar')
            ->label()->addClass('bar')->data('bar', 'baz')
            ->control()->addClass('baz')->data('baz', 'foo')
            ->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroup()
    {
        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" class="form-control" id="number"></div>';
        $result = $this->form->number('Number', 'number')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithValue()
    {
        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" class="form-control" id="number" value="15"></div>';
        $result = $this->form->number('Number', 'number')->value('15')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Number is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" class="form-control is-invalid" id="number"><div class="invalid-feedback">Number is required.</div></div>';
        $result = $this->form->number('Number', 'number')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithErrorAndCustomFormText()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Number is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" class="form-control is-invalid" id="number"><div class="invalid-feedback">Number is required.</div><small class="form-text">some custom text</small></div>';
        $result = $this->form->number('Number', 'number')->formText('some custom text')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('15');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" value="15" class="form-control" id="number"></div>';
        $result = $this->form->number('Number', 'number')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithOldInputAndDefaultValue()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('15');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" value="15" class="form-control" id="number"></div>';
        $result = $this->form->number('Number', 'number')->defaultValue('22')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithDefaultValue()
    {
        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" class="form-control" id="number" value="15"></div>';
        $result = $this->form->number('Number', 'number')->defaultValue('15')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderNumberGroupWithOldInputAndError()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('18');

        $this->builder->setOldInputProvider($oldInput);

        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Number is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="mb-3"><label for="number" class="form-label">Number</label><input type="number" name="number" value="18" class="form-control is-invalid" id="number"><div class="invalid-feedback">Number is required.</div></div>';
        $result = $this->form->number('Number', 'number')->render();
        $this->assertEquals($expected, $result);
    }

    private function getStubObject()
    {
        $obj = new stdClass();
        $obj->email = 'johndoe@example.com';
        $obj->first_name = 'John';
        $obj->last_name = 'Doe';
        $obj->date_of_birth = new DateTime('1985-05-06');
        $obj->gender = 'male';
        $obj->terms = 'agree';

        return $obj;
    }
}
