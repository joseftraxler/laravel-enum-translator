<?php

declare(strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum TestExampleSelectableEnum
{
    use TranslatableEnum;

    case Active;
    case Inactive;
    case Pending;
}
