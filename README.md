# Laravel Enum Translator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joseftraxler/laravel-enum-translator.svg?style=flat-square)](https://packagist.org/packages/joseftraxler/laravel-enum-translator)
[![Total Downloads](https://img.shields.io/packagist/dt/joseftraxler/laravel-enum-translator.svg?style=flat-square)](https://packagist.org/packages/joseftraxler/laravel-enum-translator)
![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php)
![Laravel Version](https://img.shields.io/badge/Laravel-12%2B-FF2D20?style=flat-square&logo=laravel)
![License](https://img.shields.io/badge/license-MIT-green.svg?style=flat-square)
[![CI](https://github.com/joseftraxler/laravel-enum-translator/actions/workflows/CI.yml/badge.svg)](https://github.com/joseftraxler/laravel-enum-translator/actions/workflows/CI.yml)

Lightweight Laravel helper for translating native PHP enums using attributes, Laravel’s translator, or automatic human‑readable fallback.

This package provides a simple trait you can add to any enum to get consistent, flexible translations without boilerplate.

---

## Installation

```bash
composer require joseftraxler/laravel-enum-translator
```

Requirements:

- PHP **8.4+**
- Laravel **12+**

No service providers, no configuration files — works out of the box.

---

## Usage

### 1) Add the trait to your enum

```php
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;
use JosefTraxler\LaravelEnumTranslator\Attributes\Trans;

enum MyEnum: string
{
    use TranslatableEnum;

    #[Trans('My translated value')]
    case MyValue = 'my_value';
}
```

### Get translated value

```php
echo MyEnum::MyValue->trans();
// "My translated value"
```

---

## Translation Sources (Priority Order)

The trait resolves translations in this order:

1. **Attribute translation** (`#[Trans('…')]`)
2. **Laravel translator** (`lang/en/enums.php`)
3. **Human‑readable fallback**

---

### 1) Attribute Translation

```php
#[Trans('My translated value')]
case MyValue = 'my_value';
```

This is the highest‑priority translation.

---

### 2) Laravel Translator

You can define translations using Laravel's standard language files.

**lang/en/enum.php**

```php
<?php

return [
    MyEnum::class => [
        MyEnum::MyValue->value => 'My translated value',
    ],
];
```

The translation key is automatically generated as:

```
enums.{EnumClass}.{value or name}
```

depending on whether the enum is backed.

---

### 3) Human‑Readable Fallback

If no attribute and no translation exists, the trait converts:

- `my_value` → `My value`
- `MyValue` → `My value`
- `MY_VALUE` → `MY VALUE` (keeps acronyms)
- `my-value` → `My value`

Example:

```php
enum Status: string {
    use TranslatableEnum;

    case InProgress = 'in_progress';
}

echo Status::InProgress->trans();
// "In progress"
```

---

## Select Options Helper

Useful for forms (Filament, Laravel Form Components, Nova, etc.):

```php
MyEnum::selectOptions();
```

Returns:

```php
[
    'my_value' => 'My translated value',
]
```

---

## HTML Output

The trait provides a `toHtml()` method that is fully **compatible** with Laravel’s `Htmlable` interface.
The trait itself does **not** implement `Htmlable`, but if your enum implements it, Laravel will automatically call `toHtml()` when the enum instance is rendered in Blade.

This allows you to use the enum directly in templates without calling `->trans()` manually.

Example enum definition:

```php
use Illuminate\Contracts\Support\Htmlable;
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum MyEnum: string implements Htmlable
{
    use TranslatableEnum;

    case MyValue = 'my_value';
}
```

Usage in Blade:

```php
{{ MyEnum::MyValue }}
```

Laravel will internally call:

```php
MyEnum::MyValue->toHtml();
```

Which is equivalent to:

```php
MyEnum::MyValue->trans();
```

---

## How It Works

The trait internally:

- detects whether the enum is backed (`value`) or pure (`name`)
- resolves translations via attribute → translator → fallback
- uses Laravel’s `translator` service via `App::make('translator')`
- formats fallback values using:
    - underscore/dash replacement
    - camelCase splitting
    - multibyte‑safe ucfirst

---

## License

MIT
© Josef Traxler
