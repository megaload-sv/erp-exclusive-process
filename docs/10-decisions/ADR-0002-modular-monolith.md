# ADR-0002: Modular Monolith Architecture

- Status: Accepted
- Date: 2026-07-22
- Decision owners: TraceOps ERP engineering team

## Context

TraceOps ERP will contain several business capabilities, including CRM, customers, workflow, operations, inventory, accounting, administration, and auditability. The product needs strong module boundaries without introducing the operational complexity of distributed services during its foundation stage.

## Decision

TraceOps ERP will begin as a modular monolith implemented with CodeIgniter 4.

The application will be deployed as one unit and will use one primary relational database. Business capabilities will be organized into explicit modules with controlled dependencies, module-owned application services, and clear interfaces.

Shared code will be limited to stable cross-cutting concerns such as authentication, authorization, auditing, formatting, notifications, and infrastructure adapters.

## Consequences

### Positive

- Simpler deployment, debugging, transactions, and local development.
- Lower infrastructure and operational cost.
- Strong consistency for process-driven operations.
- Clear path for incremental delivery through pull requests.
- Individual modules may be extracted later if scale or organizational needs justify it.

### Negative

- Module boundaries require discipline because they are not enforced by network separation.
- Poorly controlled shared code could create coupling.
- The application may require future extraction work if a capability develops very different scaling characteristics.

## Guardrails

- Modules must not access another module’s persistence implementation directly.
- Cross-module behavior should use application services or explicit contracts.
- Domain rules must remain outside controllers and views.
- Architectural exceptions require a new ADR.

## Alternatives considered

### Traditional layered monolith

Rejected because it tends to organize code by technical type instead of business capability and makes future module ownership harder.

### Microservices from the beginning

Rejected because the current product stage does not justify distributed transactions, service discovery, independent observability stacks, and additional deployment complexity.
