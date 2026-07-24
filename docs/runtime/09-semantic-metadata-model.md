# C-008 — Semantic Metadata Model

The Semantic Metadata Model introduces reusable knowledge objects into the TraceOps Semantic Runtime.

## Purpose

Metadata describes how Runtime entities should be understood, presented, documented and discovered without coupling consumers to concrete PHP implementations.

Metadata may describe:

- components
- properties
- types
- capabilities
- events
- commands
- services

## Stable identities

Registry entries use semantic identities such as:

```text
component.button
property.button.label
property.customer.email
```

These identities are public Runtime contracts. PHP class names are implementation details.

## Metadata object

```php
SemanticMetadata::make()
    ->title('Customer email')
    ->summary('Primary corporate email')
    ->icon('mail')
    ->group('General')
    ->placeholder('john@company.com')
    ->help('Use the customer corporate address.')
    ->tags('identity', 'contact')
    ->example('john@traceops.dev')
    ->since('0.3.0')
    ->order(10);
```

## Registry

`MetadataRegistry` resolves metadata by semantic identity and exposes a serializable catalog for Developer Console, Studio, documentation and future AI consumers.

## Developer Console rule

Every Runtime knowledge capability must have a visible consumer. C-008 is surfaced through Metadata Explorer and through property metadata in Component Explorer.

## Boundary

C-008 does not implement relationships or graph queries. Those belong to later Knowledge Layer capabilities.