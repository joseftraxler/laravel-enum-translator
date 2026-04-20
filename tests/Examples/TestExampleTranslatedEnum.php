<?php

declare (strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\Attributes\Trans;
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleTranslatedEnum
{
    use TranslatableEnum;

    #[Trans('It\'s progressing...')]
    case InProgress;
}
