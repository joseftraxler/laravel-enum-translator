<?php

declare(strict_types=1);

use Tests\Examples\TestExampleBackedEnum;
use Tests\Examples\TestExampleEnum;
use Tests\Examples\TestExampleTranslatedBackedEnum;
use Tests\Examples\TestExampleTranslatedEnum;

beforeEach(function () {
    test()->translator
        ->addLine(
            'enums.' . TestExampleEnum::class . '.' . TestExampleEnum::InProgress->name,
            'Processing enum...',
        )
        ->addLine(
            'enums.' . TestExampleBackedEnum::class . '.' . TestExampleBackedEnum::InProgress->value,
            'Processing backed enum...',
        );
});

it('uses translator when no attribute is defined')
    ->expect(fn () => TestExampleEnum::InProgress->trans())
    ->toBe('Processing enum...');

it('uses translator for backed enums when no attribute is defined')
    ->expect(fn () => TestExampleBackedEnum::InProgress->trans())
    ->toBe('Processing backed enum...');

it('uses attribute translation even if translator has a value')
    ->expect(fn () => TestExampleTranslatedEnum::InProgress->trans())
    ->toBe('It\'s progressing...');

it('uses attribute translation for backed enums even if translator has a value')
    ->expect(fn () => TestExampleTranslatedBackedEnum::InProgress->trans())
    ->toBe('It\'s progressing...');
