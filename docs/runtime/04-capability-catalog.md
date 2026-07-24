# 4. Runtime Capability Catalog

Capability identifiers are stable architectural references. PR numbers may change through repository history; capability identifiers must not.

| ID | Capability | Status | Primary delivery |
|---|---|---|---|
| C-001 | Framework Core | Delivered | PR-006 |
| C-002 | Universal Composition | Delivered | PR-007 |
| C-003 | Named Slots | Delivered | PR-008 |
| C-004 | Descriptor Engine | Delivered | PR-009 |
| C-005 | ERP Developer Console | Delivered | PR-010 |
| — | Runtime Specification and Base Contracts | Stabilization | PR-011 |
| C-006 | Capability Engine | Planned | PR-012 |
| C-007 | Type System | Planned | PR-013 |
| C-008 | Metadata Registry | Planned | PR-014 |
| C-009 | Visitor Engine | Planned | PR-015 |
| C-010 | Render Preview | Planned | PR-016 |

## Capability vocabulary

The Capability Engine will begin with a small semantic vocabulary and extend it only through real use cases:

- renderable
- clickable
- focusable
- disableable
- container
- layout
- data-source
- searchable
- sortable
- filterable
- selectable
- paginable
- exportable
- validatable
- editable
- readonly
- async
- realtime
- draggable
- droppable

Capability names describe behavior, not component identity. Consumers must ask what a component supports instead of checking whether it is a specific implementation.
