# C-011 — Runtime Kernel

The Runtime Kernel is the stable entry point to the TraceOps Semantic Runtime.

## Purpose

Before this capability, consumers assembled and traversed specialized registries directly. The Kernel now composes those registries behind a single contract while preserving their individual responsibilities.

```text
Consumers
   │
   ▼
RuntimeKernelInterface
   │
   ├── ComponentRegistry
   ├── CapabilityRegistry
   ├── TypeRegistry
   ├── MetadataRegistry
   ├── RelationshipRegistry
   └── KnowledgeRegistry
```

## Construction

```php
$kernel = (new RuntimeKernelBuilder())->build(
    $components,
    $capabilities,
    $types,
    $metadata,
);
```

The builder derives the Knowledge Registry and relationship graph from the registered descriptors.

## Public API

```php
$kernel->components();
$kernel->capabilities();
$kernel->types();
$kernel->metadata();
$kernel->relationships();
$kernel->knowledge();
$kernel->stats();
$kernel->health();
```

## Architectural rule

Studio, APIs, documentation generators, AI context generators and the Developer Console should depend on `RuntimeKernelInterface`, not on the construction details of individual registries.

## Boundary

C-011 does not introduce semantic query syntax. C-012 will build the Query Engine over the Kernel contract.
