# 8. Semantic Property System

C-007 introduces semantic types and reusable property declarations.

## Responsibilities

- `TypeInterface` defines stable type metadata.
- `TypeRegistry` stores semantic types by public name.
- `TypeResolver` resolves names, classes, metadata and recommended inputs.
- `Property` provides a fluent declaration object.
- `PropertyDescriptor` serializes semantic property metadata for consumers.

## Initial types

- `string`
- `boolean`
- `email`
- `uuid`

## Example

```php
Property::make('email')
    ->label('Corporate email')
    ->type(EmailType::class)
    ->required()
    ->searchable()
    ->validation('email');
```

The public descriptor contains `type: email`, not the PHP class name. This keeps semantic contracts stable while allowing internal implementations to evolve.

## Consumer rule

ERP, Studio, API generators and AI tooling should use type metadata from the registry instead of duplicating validation, formatting or input-selection rules.