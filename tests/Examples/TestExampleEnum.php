<?php

declare (strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleEnum
{
    use TranslatableEnum;

    case InProgress;
    case PDF;
    case XMLParser;
    case Version2Beta;
}
