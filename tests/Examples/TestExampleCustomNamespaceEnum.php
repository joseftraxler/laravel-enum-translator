<?php

declare(strict_types=1);

namespace Tests\Examples;

use JosefTraxler\LaravelEnumTranslator\Attributes\TranslatorNamespace;

#[TranslatorNamespace('tests.enums.values')]
enum TestExampleCustomNamespaceEnum
{
    case InProgress;
}
