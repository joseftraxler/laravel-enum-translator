<?php

declare (strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleBackedEnum: string
{
    use TranslatableEnum;

    case InProgress = 'in_progress';
    case USA = 'USA';
    case XMLParser = 'XML_parser';
    case Version2Beta = 'version2_beta';
}
