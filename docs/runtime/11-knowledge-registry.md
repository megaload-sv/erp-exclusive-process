# C-010 — Knowledge Registry

The Knowledge Registry is the unified semantic inventory of the TraceOps Semantic Runtime.

It combines the entities previously exposed by independent registries without replacing those specialized registries. Components, properties, types, capabilities, metadata and slots receive stable identities and become addressable through one contract.

## Semantic identities

```text
component.button
property.button.label
type.string
capability.clickable
metadata.component.button
slot.button.content
```

## Core objects

### SemanticEntity

Represents one node in the Runtime knowledge graph.

```php
SemanticEntity::make(
    'type.email',
    'type',
    'email',
    ['format' => 'email']
);
```

### KnowledgeRegistry

Stores semantic entities and their relationship registry.

```php
$registry->get('component.button');
$registry->ofKind('property');
$registry->connectedFrom('component.button', 'hasProperty');
$registry->connectedTo('type.string', 'hasType');
```

### KnowledgeRegistryBuilder

Projects the existing Runtime catalogs into a unified registry. Descriptors remain the source of truth; the Knowledge Registry is a normalized, query-ready representation.

## Architectural boundary

C-010 provides identity, inventory, one-hop traversal and kind summaries. Fluent filtering, recursive traversal and semantic predicates belong to C-011 Semantic Query Engine.

The specialized registries continue owning validation and construction rules. The Knowledge Registry composes their public semantic output rather than duplicating those responsibilities.
