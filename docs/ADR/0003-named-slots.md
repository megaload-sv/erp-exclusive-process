# ADR-0003 — Named Slots in the TraceOps Object Model

## Status

Accepted

## Context

A plain child list preserves hierarchy but does not express the semantic role of each child. Enterprise interfaces require meaningful regions such as `header`, `body`, `footer`, `actions`, `filters` and `sidebar`.

Without named regions, renderers, Studio, inspectors and future AI capabilities would have to infer intent from child order or concrete component types.

## Decision

TraceOps nodes support named slots in addition to their ordinary child collection.

A slot:

- has a validated stable name;
- contains zero or more nodes in insertion order;
- participates in parent-child ownership;
- supports safe reparenting;
- participates in recursive traversal;
- is rendered recursively with the same `RenderContext` as the root;
- is exposed to component views as both ordered rendered items and concatenated HTML.

The public API is explicit:

```php
$card
    ->setSlot('header', $toolbar)
    ->setSlot('body', $table)
    ->addToSlot('footer', $pagination);
```

## Alternatives considered

### Positional children only

Rejected because position does not communicate semantic intent and becomes fragile as components evolve.

### Dedicated properties for every region

Rejected because it would require each component to implement repetitive region-management logic and would prevent generic tooling.

### Arbitrary associative arrays

Rejected because they would not enforce node ownership, traversal, cycle safety or consistent rendering.

## Consequences

### Positive

- Component trees become semantically meaningful.
- Renderers can target named regions consistently.
- Studio can display valid drop zones.
- Metadata and validation engines can describe slot rules later.
- AI and inspection tools can reason about interface structure without reading HTML.

### Trade-offs

- Nodes now maintain two composition channels: ordinary children and named slots.
- Tree traversal must include both channels deterministically.
- Future slot schemas must define cardinality and accepted node types without coupling the core collection to UI-specific classes.

## Follow-up decisions

- Slot schemas and composition constraints.
- Metadata exposure for supported slots.
- Serialization format for named regions.
- Visitor behavior for slot-aware mutations.
