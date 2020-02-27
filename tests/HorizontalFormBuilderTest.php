<?php

use PHPUnit\Framework\TestCase;
use TypiCMS\BootForms\HorizontalFormBuilder;
use TypiCMS\Form\FormBuilder;

class HorizontalFormBuilderTest extends TestCase
{
    private $form;

    private $builder;

    public function setUp()
    {
        $this->builder = new FormBuilder();
        $this->form = new HorizontalFormBuilder($this->builder);
    }

    public function tearDown()
    {
        Mockery::close();
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
        $expected = '<form method="GET" action="/search">';
        $result = $this->form->open()->get()->action('/search')->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormClose()
    {
        $expected = '</form>';
        $result = $this->form->close();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroup()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithCustomWidths()
    {
        $this->form->setColumnSizes(['lg' => [3, 9]]);
        $expected = '<div class="form-group row"><label class="col-lg-3 col-form-label" for="email">Email</label><div class="col-lg-9"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithMultipleBreakpointSizes()
    {
        $this->form->setColumnSizes(['xs' => [5, 7], 'lg' => [3, 9]]);
        $expected = '<div class="form-group row"><label class="col-xs-5 col-lg-3 col-form-label" for="email">Email</label><div class="col-xs-7 col-lg-9"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithValue()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" value="example@example.com"></div></div>';
        $result = $this->form->text('Email', 'email')->value('example@example.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithAttribute()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" maxlength="50"></div></div>';
        $result = $this->form->text('Email', 'email')->attribute('maxlength', '50')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Email is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control is-invalid"><div class="invalid-feedback">Email is required.</div></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInputAndDefaultValue()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->defaultValue('test@test.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithDefaultValue()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" value="test@test.com"></div></div>';
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

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control is-invalid"><div class="invalid-feedback">Email is required.</div></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroup()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control"></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupDoesntKeepOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('password');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control"></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Password is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control is-invalid"><div class="invalid-feedback">Password is required.</div></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButton()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><button type="button" class="btn btn-secondary">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithCustomColumnSizes()
    {
        $this->form->setColumnSizes(['lg' => [3, 9]]);
        $expected = '<div class="form-group row"><div class="col-lg-offset-3 col-lg-9"><button type="button" class="btn btn-secondary">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithMultipleBreakpointSizes()
    {
        $this->form->setColumnSizes(['xs' => [5, 7], 'lg' => [3, 9]]);
        $expected = '<div class="form-group row"><div class="col-xs-offset-5 col-xs-7 col-lg-offset-3 col-lg-9"><button type="button" class="btn btn-secondary">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithMultipleBreakpointSizesThatDontFillFullWidth()
    {
        $this->form->setColumnSizes(['xs' => [5, 7], 'lg' => [3, 6]]);
        $expected = '<div class="form-group row"><div class="col-xs-offset-5 col-xs-7 col-lg-offset-3 col-lg-6"><button type="button" class="btn btn-secondary">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSubmit()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><button type="submit" class="btn btn-primary">Submit</button></div></div>';
        $result = $this->form->submit()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckbox()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input"><label class="form-check-label" for="terms">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Must agree to terms.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input is-invalid"><label class="form-check-label" for="terms">Agree to Terms</label><div class="invalid-feedback">Must agree to terms.</div></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('1');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" checked="checked"><label class="form-check-label" for="terms">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxChecked()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" checked="checked"><label class="form-check-label" for="terms">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithAdditionalAttributes()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" data-foo="bar"><label class="form-check-label" for="terms">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->attribute('data-foo', 'bar')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadio()
    {
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="radio" name="color" value="red" id="color" class="form-check-input"><label class="form-check-label" for="color">Red</label></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="radio" name="color" value="red" id="color" class="form-check-input is-invalid"><label class="form-check-label" for="color">Red</label><div class="invalid-feedback">Sample error</div></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('red');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group row"><div class="col-lg-offset-2 col-lg-10"><div class="form-check"><input type="radio" name="color" value="red" id="color" class="form-check-input" checked="checked"><label class="form-check-label" for="color">Red</label></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextarea()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithRows()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="5" cols="50" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->rows(5)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithCols()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="20" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->cols(20)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithOldInput()
    {
        $oldInput = Mockery::mock('TypiCMS\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('Sample bio');

        $this->builder->setOldInputProvider($oldInput);
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control">Sample bio</textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control is-invalid"></textarea><div class="invalid-feedback">Sample error</div></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelect()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Color is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control is-invalid"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select><div class="invalid-feedback">Color is required.</div></div></div>';

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

        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2" selected>Green</option><option value="3">Blue</option></select></div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderDateGroup()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="birthday">Birthday</label><div class="col-lg-10"><input type="date" name="birthday" id="birthday" class="form-control"></div></div>';
        $result = $this->form->date('Birthday', 'birthday')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderDateTimeLocalGroup()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="dob">Date & time of birth</label><div class="col-lg-10"><input type="datetime-local" name="dob" id="dob" class="form-control"></div></div>';
        $result = $this->form->dateTimeLocal('Date & time of birth', 'dob')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroup()
    {
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="file">File</label><div class="col-lg-10"><input type="file" name="file" id="file"></div></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroupWithError()
    {
        $errorStore = Mockery::mock('TypiCMS\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="file">File</label><div class="col-lg-10"><input type="file" name="file" id="file" class="is-invalid"><div class="invalid-feedback">Sample error</div></div></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }
}
