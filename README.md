# Laravel Enum Translator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joseftraxler/laravel-enum-translator.svg?style=flat-square)](https://packagist.org/packages/joseftraxler/laravel-enum-translator)
[![Total Downloads](https://img.shields.io/packagist/dt/joseftraxler/laravel-enum-translator.svg?style=flat-square)](https://packagist.org/packages/joseftraxler/laravel-enum-translator)
![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=flat-square&logo=php)
![Laravel Version](https://img.shields.io/badge/Laravel-12%2B-FF2D20?style=flat-square&logo=laravel)
![License](https://img.shields.io/badge/license-MIT-green.svg?style=flat-square)
[![CI](https://github.com/joseftraxler/laravel-enum-translator/actions/workflows/CI.yml/badge.svg)](https://github.com/joseftraxler/laravel-enum-translator/actions/workflows/CI.yml)

A lightweight, zero-configuration Laravel package that provides simple and elegant translation for native PHP enums using **attributes**, **Laravel's translator**, or automatic **human-readable fallback**.

This package eliminates the need for boilerplate code when working with enums that need translations. Just add the trait and start translating!

---

## Table of Contents

- [Quick Start](#quick-start)
- [Installation](#installation)
- [Usage](#usage)
- [Translation Sources (Priority Order)](#translation-sources-priority-order)
- [Advanced Usage](#advanced-usage)
- [Real-World Examples](#real-world-examples)
- [Testing](#testing)
- [How It Works](#how-it-works)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## Quick Start

```php
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;
use JosefTraxler\LaravelEnumTranslator\Attributes\Trans;

enum Status: string
{
    use TranslatableEnum;

    #[Trans('In Progress')]
    case InProgress = 'in_progress';
    
    #[Trans('Completed')]
    case Completed = 'completed';
}

// Use it anywhere
echo Status::InProgress->trans(); // "In Progress"
```

---

## Installation

```bash
composer require joseftraxler/laravel-enum-translator
```

### Requirements

- **PHP** 8.4+
- **Laravel** 12+

### Zero Configuration

The package is **auto-discovered** by Laravel and requires **no configuration files or service providers**. It works out of the box!

---

## Usage

### Step 1: Add the Trait to Your Enum

```php
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum MyEnum: string
{
    use TranslatableEnum;

    case MyValue = 'my_value';
}
```

### Step 2: Translate Enum Values

```php
// Using the trait method
echo MyEnum::MyValue->trans();

// In Blade templates (if enum implements Htmlable)
{{ MyEnum::MyValue }}

// Get all enum options for forms
$options = MyEnum::selectOptions(); // ['my_value' => 'My value']
```

---

## Translation Sources (Priority Order)

The package attempts to resolve translations in this order:

1. **Attribute Translation** (`#[Trans('…')]`) — Highest priority
2. **Laravel Translator** (language files)
3. **Human-Readable Fallback** — Always available

---

## Advanced Usage

### 1) Attribute Translation (Highest Priority)

Use the `#[Trans()]` attribute to define hardcoded translations:

```php
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;
use JosefTraxler\LaravelEnumTranslator\Attributes\Trans;

enum Priority: string
{
    use TranslatableEnum;

    #[Trans('Urgent')]
    case High = 'high';
    
    #[Trans('Normal')]
    case Medium = 'medium';
    
    #[Trans('Low Priority')]
    case Low = 'low';
}

echo Priority::High->trans(); // "Urgent"
```

**When to use:** Great for static translations that never change or when you want consistency without touching language files.

---

### 2) Laravel Translator (Flexible & Multi-Language)

Use Laravel's standard language files for translations:

#### Create Language Files

**`resources/lang/en/enums.php`**

```php
<?php

return [
    \App\Enums\Status::class => [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],
    \App\Enums\Priority::class => [
        'high' => 'High Priority',
        'medium' => 'Medium Priority',
        'low' => 'Low Priority',
    ],
];
```

**`resources/lang/de/enums.php`**

```php
<?php

return [
    \App\Enums\Status::class => [
        'pending' => 'Überprüfung ausstehend',
        'approved' => 'Genehmigt',
        'rejected' => 'Abgelehnt',
    ],
];
```

#### Usage

```php
enum Status: string
{
    use TranslatableEnum;

    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}

// English (default)
echo Status::Pending->trans(); // "Pending Review"

// German
echo Status::Pending->trans(locale: 'de'); // "Überprüfung ausstehend"

// Falls back to human-readable if translation not found
echo Status::SomeOther->trans(); // "Some Other"
```

#### Custom Translation Namespaces

By default, the package looks for translations in `enums.{EnumClass}.{value or name}`. You can customize this:

```php
use JosefTraxler\LaravelEnumTranslator\Attributes\TranslatorNamespace;

#[TranslatorNamespace('app.statuses')]
enum Status: string
{
    use TranslatableEnum;

    case Pending = 'pending';
}

// Looks for translation in: app.statuses.pending
```

**When to use:** When you need multi-language support or dynamic translations that can be managed through language files.

---

### 3) Human-Readable Fallback (Always Available)

If no attribute or translation exists, the package automatically converts enum values:

```php
enum Status: string
{
    use TranslatableEnum;

    case InProgress = 'in_progress';
    case MyValue = 'MyValue';
    case STATUS_OPEN = 'STATUS_OPEN';
}

echo Status::InProgress->trans();   // "In progress"
echo Status::MyValue->trans();      // "My value"
echo Status::STATUS_OPEN->trans();  // "STATUS OPEN" (keeps acronyms)
```

**Conversion rules:**
- Underscores and dashes → spaces
- camelCase → words with spaces
- UPPERCASE → kept as-is (for acronyms)
- First letter → uppercase

**When to use:** Perfect for development or quick prototypes where translations aren't critical.

---

## Real-World Examples

### Example 1: User Roles

```php
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;
use JosefTraxler\LaravelEnumTranslator\Attributes\Trans;

enum UserRole: string
{
    use TranslatableEnum;

    #[Trans('Administrator')]
    case Admin = 'admin';
    
    #[Trans('Editor')]
    case Editor = 'editor';
    
    #[Trans('Viewer')]
    case Viewer = 'viewer';
}

// In a form
<select name="role">
    @foreach(UserRole::selectOptions() as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
```

### Example 2: Order Status with Multi-Language Support

**Enum definition:**

```php
enum OrderStatus: string
{
    use TranslatableEnum;

    case Pending = 'pending';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}
```

**Language files:**

**`resources/lang/en/enums.php`**
```php
return [
    OrderStatus::class => [
        'pending' => 'Awaiting Payment',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Order Cancelled',
    ],
];
```

**`resources/lang/es/enums.php`**
```php
return [
    OrderStatus::class => [
        'pending' => 'Esperando Pago',
        'processing' => 'En Procesamiento',
        'shipped' => 'Enviado',
        'delivered' => 'Entregado',
        'cancelled' => 'Pedido Cancelado',
    ],
];
```

**Usage:**

```php
// In notification emails
$order->status->trans(locale: 'es'); // Spanish translation

// In API responses
return [
    'status' => $order->status->trans(),
    'label' => $order->status->trans(locale: 'de'),
];
```

### Example 3: Filament Select Field

```php
use Filament\Forms\Components\Select;

Select::make('priority')
    ->options(Priority::selectOptions())
    ->required(),
```

### Example 4: Blade Template with Htmlable Interface

```php
use Illuminate\Contracts\Support\Htmlable;
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum BadgeStatus: string implements Htmlable
{
    use TranslatableEnum;

    case Success = 'success';
    case Warning = 'warning';
    case Error = 'error';
}

<!-- In Blade -->
<span class="badge badge-{{ $status->value }}">
    {{ $status }}
</span>

<!-- Renders as: -->
<!-- <span class="badge badge-success">Success</span> -->
```

---

## Select Options Helper

Convert all enum cases to an associative array perfect for HTML `<select>` elements, Laravel form components, Filament, Nova, etc.

```php
MyEnum::selectOptions();

// Returns:
[
    'my_value' => 'My value',
    'other_value' => 'Other value',
]
```

Works with both **backed enums** (uses `value`) and **pure enums** (uses `name`):

```php
// Pure enum
enum Status
{
    use TranslatableEnum;
    
    case Pending;
    case Approved;
}

Status::selectOptions(); 
// ['Pending' => 'Pending', 'Approved' => 'Approved']

// Backed enum
enum Status: string
{
    use TranslatableEnum;
    
    case Pending = 'pending';
    case Approved = 'approved';
}

Status::selectOptions();
// ['pending' => 'Pending', 'approved' => 'Approved']
```

---

## HTML Output

The trait provides a `toHtml()` method that is fully compatible with Laravel's `Htmlable` interface.

**Note:** The trait itself does **not** implement `Htmlable`, but if your enum implements it, Laravel will automatically call `toHtml()` when the enum is rendered in Blade templates.

```php
use Illuminate\Contracts\Support\Htmlable;
use JosefTraxler\LaravelEnumTranslator\TranslatableEnum;

enum Status: string implements Htmlable
{
    use TranslatableEnum;

    #[Trans('In Progress')]
    case InProgress = 'in_progress';
}

// In Blade template
{{ Status::InProgress }}

// Equivalent to:
{{ Status::InProgress->toHtml() }}

// Which calls:
{{ Status::InProgress->trans() }}
```

This allows seamless integration with Blade without explicit method calls.

---

## Testing

The package uses **Pest** for testing. Run tests with:

```bash
composer test
```

### Code Quality

Check PHP coding standards:

```bash
composer cs
```

Fix coding standards:

```bash
composer cs-fix
```

Run static analysis:

```bash
composer stan
```

---

## How It Works

### Translation Resolution Flow

```
Enum::Case->trans()
    ↓
1. Check for #[Trans()] attribute
    ↓ (found: return label)
    ↓ (not found: continue)
2. Check Laravel translator
    ↓ (found: return translation)
    ↓ (not found: continue)
3. Apply human-readable fallback
    ↓
Return formatted value
```

### Implementation Details

The package internally:

- **Detects enum type:** Whether the enum is backed (has `value`) or pure (uses `name`)
- **Reflects attributes:** Uses PHP's `ReflectionEnumUnitCase` to read `#[Trans()]` attributes
- **Uses Laravel's translator:** Integrates with `Illuminate\Contracts\Translation\Translator`
- **Formats values:** Converts underscores, dashes, and camelCase to human-readable text
- **Handles Unicode:** Uses `mb_ucfirst()` for multibyte character safety

### Service Provider

The package auto-registers the translator with Laravel's service container:

```php
class TranslatorProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Contracts\Translator::class,
            fn() => $this->app->make(Translator::class),
        );
    }
}
```

This is done automatically — no configuration needed!

---

## Troubleshooting

### Translation Not Found?

**Check the priority order:**

1. **Attribute present?** → `#[Trans('label')]` should match exactly
2. **Language file exists?** → Check `resources/lang/{locale}/enums.php`
3. **Correct translation key?** → Default is `enums.{EnumClass}.{value or name}`
4. **Fallback active?** → Human-readable conversion should apply

### Custom Namespace Not Working?

Ensure the attribute is applied to the **enum class**, not individual cases:

```php
// ✅ Correct
#[TranslatorNamespace('my.namespace')]
enum MyEnum: string
{
    use TranslatableEnum;
    case MyValue = 'value';
}

// ❌ Incorrect
enum MyEnum: string
{
    use TranslatableEnum;
    
    #[TranslatorNamespace('my.namespace')]
    case MyValue = 'value';
}
```

### Locale Parameter Ignored?

The `locale` parameter only works with **Laravel translator** translations:

```php
// Works if translation exists in language files
MyEnum::MyValue->trans(locale: 'de');

// Falls back to attribute or human-readable (ignores locale parameter)
MyEnum::MyValue->trans(locale: 'de');
```

### Pure vs Backed Enums

**Pure enums** use the `name` property:

```php
enum Status
{
    use TranslatableEnum;
    case Pending; // name: "Pending"
}

// Translation key: enums.Status.Pending
```

**Backed enums** use the `value` property:

```php
enum Status: string
{
    use TranslatableEnum;
    case Pending = 'pending'; // value: "pending"
}

// Translation key: enums.Status.pending
```

---

## API Reference

### Methods

#### `trans(?string $locale = null): string`

Translates the enum case to a human-readable string.

```php
MyEnum::Case->trans();           // Uses default locale
MyEnum::Case->trans(locale: 'de'); // Uses German locale
```

#### `selectOptions(): array`

Returns all enum cases as an associative array for form selects.

```php
MyEnum::selectOptions();
// ['key' => 'Translated Label', ...]
```

#### `toHtml(): string`

Returns the translated string. Called automatically by Blade when enum implements `Htmlable`.

```php
MyEnum::Case->toHtml();
// Returns: "Translated Label"
```

### Attributes

#### `#[Trans(string $label)]`

Set a hardcoded translation for an enum case.

```php
#[Trans('My Custom Label')]
case MyValue = 'value';
```

#### `#[TranslatorNamespace(string $path)]`

Set a custom translation namespace for the entire enum (applied to class, not cases).

```php
#[TranslatorNamespace('app.statuses')]
enum MyEnum: string { ... }

// Looks for: app.statuses.{value}
```

---

## Contributing

Contributions are welcome! Please ensure:

- Code passes all tests: `composer test`
- Code standards are met: `composer cs`
- Static analysis passes: `composer stan`

---

## License

MIT License © [Josef Traxler](https://github.com/joseftraxler)

See the [LICENSE](LICENSE) file for details.

---

## Support

- **Issues:** [GitHub Issues](https://github.com/joseftraxler/laravel-enum-translator/issues)
- **Source:** [GitHub Repository](https://github.com/joseftraxler/laravel-enum-translator)
