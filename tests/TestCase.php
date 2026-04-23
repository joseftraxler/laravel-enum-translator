<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public Stubs\FakeApplication $app;
    public Stubs\FakeTranslator $translator;

    protected function setUp(): void
    {
        parent::setUp();

        Facade::setFacadeApplication(new Stubs\FakeApplication());

        $this->app = App::getFacadeRoot();
        $this->translator = App::make('translator');
    }
}
