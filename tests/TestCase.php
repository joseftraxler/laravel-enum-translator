<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Stubs\FakeTranslator;

abstract class TestCase extends BaseTestCase
{
    public Stubs\FakeApplication $app;
    public Stubs\FakeTranslator $translator;

    public static function setUpBeforeClass(): void
    {
        Facade::setFacadeApplication(new Stubs\FakeApplication());
        $translator = new FakeTranslator();
        App::instance('translator', $translator);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = App::getFacadeRoot();
        $this->translator = App::make('translator');
    }
}
