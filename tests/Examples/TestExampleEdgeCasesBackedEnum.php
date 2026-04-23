<?php

declare(strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleEdgeCasesBackedEnum: string
{
    use TranslatableEnum;

    case ConsecutiveUPPERCASE = 'CONSECUTIVE_UPPERCASE';
    case camelCaseValue = 'camel_case_value';
    case snake_case_value = 'snake_case_value';
    case MixedCase_WithUnderscore = 'mixed_case_with_underscore';
    case Number2WithDigits = 'number_2_with_digits';
}
