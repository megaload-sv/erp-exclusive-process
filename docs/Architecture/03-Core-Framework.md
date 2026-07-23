# TraceOps Core Framework

## Objective

The Core Framework provides the contracts and services used by all TraceOps UI components, metadata consumers and future Studio-generated application definitions.

## Initial structure

```text
app/Libraries/TraceOps/
├── Support/
│   ├── Arr.php
│   ├── Enum.php
│   └── Str.php
└── UI/
    ├── ComponentNormalizer.php
    ├── BaseComponent.php
    ├── ComponentRegistry.php
    └── Renderer.php
```

## Responsibilities

### Support helpers

`Arr`, `Enum` and `Str` provide deterministic normalization and safe access to untrusted or incomplete configuration values.

### ComponentNormalizer

Transforms raw component properties according to a declarative schema. Supported types initially include strings, nullable strings, booleans, integers, arrays, callables and enums.

### BaseComponent

Defines the contract every registered component must implement:

```php
abstract class BaseComponent
{
    abstract public static function name(): string;

    abstract public static function view(): string;

    abstract public static function schema(): array;

    abstract public static function metadata(): array;

    final public static function normalize(array $props): array
    {
        return ComponentNormalizer::normalize($props, static::schema());
    }
}
```

Component classes describe behavior and configuration. They must not generate HTML directly.

### ComponentRegistry

Stores component-name-to-class mappings and guarantees that registered classes satisfy the component contract. It must reject invalid classes and duplicate names unless replacement is explicitly requested.

Expected public operations:

```php
ComponentRegistry::register(ButtonComponent::class);
ComponentRegistry::has('button');
ComponentRegistry::get('button');
ComponentRegistry::all();
```

### Renderer

Coordinates the full component lifecycle:

```text
Component name
    ↓
Registry lookup
    ↓
Schema normalization
    ↓
View data preparation
    ↓
CodeIgniter view rendering
    ↓
HTML
```

Expected usage:

```php
echo Renderer::render('button', [
    'label' => 'Guardar',
    'variant' => 'primary',
]);
```

## Component contract

A component must provide:

- A stable unique name.
- A CodeIgniter view path.
- A normalization schema.
- Metadata suitable for documentation and Studio.

A component should not:

- Access request or session state directly.
- Query databases from its view.
- Contain module-specific business rules.
- Depend on another component through a hard-coded view path when the registry can resolve it.

## Migration strategy

1. Keep existing view calls operational.
2. Introduce component classes for existing views.
3. Register components centrally.
4. Migrate usage toward `Renderer::render()`.
5. Preserve direct view rendering as a compatibility layer until applications are fully migrated.

## Testing requirements

The Core Framework requires tests for:

- Schema normalization and defaults.
- Invalid types and values.
- Duplicate registration.
- Unknown component lookup.
- Valid rendering.
- Escaped output and safe attributes.
- Metadata structure.
