<?php

declare(strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleSelectableBackedEnum: string
{
    use TranslatableEnum;

    case Active = '1';
    case Inactive = '0';
    case Pending = '2';
}
