<?php

declare(strict_types=1);

use JosefTraxler\LaravelEnumTranslator\Facades\Translator;
use Tests\Examples\TestExampleBackedEnum;
use Tests\Examples\TestExampleEnum;

// @group edge-cases
// Tests that the translator handles unusual enum values correctly

it('keeps consecutive uppercase letters unchanged')
    ->expect(fn () => Translator::trans(TestExampleEnum::XMLParser))
    ->toBe('XMLParser');

it('keeps consecutive uppercase letters unchanged for backed enums')
    ->expect(fn () => Translator::trans(TestExampleBackedEnum::XMLParser))
    ->toBe('XML parser');

it('handles underscores in backed enum values')
    ->expect(fn () => Translator::trans(TestExampleBackedEnum::Version2Beta))
    ->toBe('Version2 beta');

it('handles numbers mixed with text in unit enums')
    ->expect(fn () => Translator::trans(TestExampleEnum::Version2Beta))
    ->toBe('Version2 Beta');

it('trait trans method works with edge cases')
    ->expect(fn () => TestExampleEnum::XMLParser->trans())
    ->toBe('XMLParser');

it('backed enum trait trans method works with edge cases')
    ->expect(fn () => TestExampleBackedEnum::Version2Beta->trans())
    ->toBe('Version2 beta');
