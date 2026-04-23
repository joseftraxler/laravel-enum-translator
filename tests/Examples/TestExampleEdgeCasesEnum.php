<?php

declare(strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleEdgeCasesEnum
{
    use TranslatableEnum;

    case ConsecutiveUPPERCASE;
    case camelCaseValue;
    case snake_case_value;
    case MixedCase_WithUnderscore;
    case Number2WithDigits;
}
