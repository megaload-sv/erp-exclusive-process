# C-009 — Semantic Relationship Engine

The Relationship Engine connects semantic Runtime entities through stable identities.

## Relationship model

A relationship is a directed semantic edge:

```text
source --type--> target
```

Examples:

```text
component.button --hasProperty--> property.button.label
property.button.label --hasType--> type.string
component.button --supports--> capability.clickable
property.button.label --describedBy--> metadata.property.button.label
```

## Stable identities

Consumers must use semantic identities rather than PHP class names. Relationships therefore remain valid across internal refactors.

## Registry

`RelationshipRegistry` supports traversal by source, target and relationship type. Duplicate edges are normalized by their stable identity.

## Descriptor derivation

`RelationshipGraphBuilder` derives the initial graph from component descriptors. The descriptor remains the source of truth; the graph is a traversable projection of that knowledge.

## Architectural boundary

C-009 establishes graph edges and basic traversal only. Fluent semantic queries, transitive traversal, graph validation and kernel orchestration belong to later capabilities.
