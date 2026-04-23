<?php

declare(strict_types=1);

use JosefTraxler\LaravelEnumTranslator\Facades\Translator;
use Tests\Examples\TestExampleBackedEnum;
use Tests\Examples\TestExampleEnum;
use Tests\Examples\TestExampleSimpleBackedEnum;
use Tests\Examples\TestExampleSimpleEnum;
use Tests\Examples\TestExampleTranslatedBackedEnum;
use Tests\Examples\TestExampleTranslatedEnum;

beforeEach(function () {
    test()->translator->addLine(
        'tests.enums.values.InProgress',
        'Value from tests.enums.values.InProgress',
    )->addLine(
        'tests.enums.values.in_progress',
        'Value from tests.enums.values.in_progress',
    );
});

it('formats fallback for unit enums')
    ->expect(fn () => Translator::trans(TestExampleSimpleEnum::InProgress))
    ->toBe('In Progress');

it('formats fallback for backed enums')
    ->expect(fn () => Translator::trans(TestExampleSimpleBackedEnum::InProgress))
    ->toBe('In progress');

it('keeps uppercase values unchanged for unit enums')
    ->expect(fn () => Translator::trans(TestExampleEnum::PDF))
    ->toBe('PDF');

it('keeps uppercase values unchanged for backed enums')
    ->expect(fn () => Translator::trans(TestExampleBackedEnum::USA))
    ->toBe('USA');

it('uses attribute translation for unit enums')
    ->expect(fn () => Translator::trans(TestExampleTranslatedEnum::InProgress))
    ->toBe('It\'s progressing...');

it('uses attribute translation for backed enums')
    ->expect(fn () => Translator::trans(TestExampleTranslatedBackedEnum::InProgress))
    ->toBe('It\'s progressing...');

it('uses namespace attribute for unit enums')
    ->expect(fn () => Translator::trans(\Tests\Examples\TestExampleCustomNamespaceEnum::InProgress))
    ->toBe('Value from tests.enums.values.InProgress');

it('uses namespace attribute for backed enums')
    ->expect(fn () => Translator::trans(\Tests\Examples\TestExampleCustomNamespaceBackedEnum::InProgress))
    ->toBe('Value from tests.enums.values.in_progress');
