# 7. Capability Engine

The Capability Engine is the behavior layer of the TraceOps Semantic Runtime.

A capability answers one question:

> What behavior does this descriptor support?

Consumers must inspect capabilities instead of concrete component classes.

```php
$descriptor->supports(ClickableCapability::class);
$resolver->componentsSupporting($descriptors, 'exportable');
```

## Building blocks

- `CapabilityInterface`: stable capability contract.
- `AbstractCapability`: reusable semantic description.
- `CapabilityRegistry`: catalog indexed by semantic name.
- `ComponentDescriptor::supports()`: descriptor-level query API.
- `BehaviorResolver`: resolves behavior and finds compatible components.

## Rules

1. Capability names describe behavior, not identity.
2. Components declare capability classes; descriptors serialize stable semantic names.
3. Registries reject conflicting names.
4. Runtime consumers must not require `instanceof` checks against component implementations.
5. Every delivered capability must be visible in the Developer Console.

## Initial vocabulary

- `renderable`
- `clickable`
- `focusable`
- `disableable`

The vocabulary will grow only from validated Runtime or ERP use cases.
