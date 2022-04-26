<?php

namespace TypiCMS\BootForms;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Form\ErrorStore\IlluminateErrorStore;
use TypiCMS\Form\FormBuilder;
use TypiCMS\Form\OldInput\IlluminateOldInputProvider;

class BootFormsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
        $this->registerBasicFormBuilder();
        $this->registerHorizontalFormBuilder();
        $this->registerBootForm();
    }

    protected function registerErrorStore(): void
    {
        $this->app->singleton('typicms.form.errorstore', function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput(): void
    {
        $this->app->singleton('typicms.form.oldinput', function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder(): void
    {
        $this->app->singleton('typicms.form', function ($app) {
            $formBuilder = new FormBuilder();
            $formBuilder->setErrorStore($app['typicms.form.errorstore']);
            $formBuilder->setOldInputProvider($app['typicms.form.oldinput']);
            $formBuilder->setToken($app['session.store']->token());

            return $formBuilder;
        });
    }

    protected function registerBasicFormBuilder(): void
    {
        $this->app->singleton('typicms.bootform.basic', function ($app) {
            return new BasicFormBuilder($app['typicms.form']);
        });
    }

    protected function registerHorizontalFormBuilder(): void
    {
        $this->app->singleton('typicms.bootform.horizontal', function ($app) {
            return new HorizontalFormBuilder($app['typicms.form']);
        });
    }

    protected function registerBootForm(): void
    {
        $this->app->singleton('typicms.bootform', function ($app) {
            return new BootForm($app['typicms.bootform.basic'], $app['typicms.bootform.horizontal']);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['typicms.bootform'];
    }
}
