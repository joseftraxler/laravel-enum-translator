<?php

declare(strict_types=1);

use Tests\Examples\TestExampleBackedEnum;
use Tests\Examples\TestExampleEnum;
use Tests\Examples\TestExampleTranslatedBackedEnum;
use Tests\Examples\TestExampleTranslatedEnum;

it('formats fallback for unit enums')
    ->expect(fn () => TestExampleEnum::InProgress->trans())
    ->toBe('In Progress');

it('formats fallback for backed enums')
    ->expect(fn () => TestExampleBackedEnum::InProgress->trans())
    ->toBe('In progress');

it('keeps uppercase values unchanged for unit enums')
    ->expect(fn () => TestExampleEnum::PDF->trans())
    ->toBe('PDF');

it('keeps uppercase values unchanged for backed enums')
    ->expect(fn () => TestExampleBackedEnum::USA->trans())
    ->toBe('USA');

it('uses attribute translation for unit enums')
    ->expect(fn () => TestExampleTranslatedEnum::InProgress->trans())
    ->toBe('It\'s progressing...');

it('uses attribute translation for backed enums')
    ->expect(fn () => TestExampleTranslatedBackedEnum::InProgress->trans())
    ->toBe('It\'s progressing...');
