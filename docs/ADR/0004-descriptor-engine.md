# ADR-0004: Descriptor Engine

## Status

Accepted.

## Context

TraceOps components must be consumable by the ERP, Studio, runtime diagnostics and future AI tooling without those consumers depending on concrete PHP classes.

## Decision

Introduce typed descriptors as the canonical semantic representation of platform elements.

The first increment includes:

- `DescriptorInterface`
- `ComponentDescriptor`
- `PropertyDescriptor`
- `DescriptorSerializer`
- `BaseComponent::describe()`

Legacy `metadata()` remains available and now delegates to the descriptor.

## Consequences

- Components become self-describing.
- Studio can build inspectors from descriptor data.
- ERP developer tooling can expose component metadata as JSON.
- Future capability, slot, event and type descriptors can extend the same contract.
- Component authors must keep their schema and semantic declarations accurate.
