# 6. Developer Console

The ERP Developer Console is the first visible consumer of Runtime semantics.

## Responsibilities

- display Runtime identity and health;
- enumerate registered components;
- inspect descriptors, properties, slots, capabilities and events;
- expose diagnostics without hardcoding component metadata;
- grow alongside every new Runtime capability.

## Planned navigation

```text
Developer
├── Runtime
├── Components
├── Capabilities
├── Types
├── Metadata
├── Tree
├── Render
├── Diagnostics
└── Performance
```

## Completion rule

A new Runtime engine is not considered integrated until its state and behavior can be inspected through the Developer Console or another approved real consumer.
