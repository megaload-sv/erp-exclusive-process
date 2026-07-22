# TraceOps Engineering Principles

## Purpose

These principles guide architecture, implementation, review, and operation of TraceOps ERP. They are mandatory decision criteria, not aspirational slogans.

## Principles

1. **Business first.** Technology serves operational outcomes and business rules.
2. **Architecture before acceleration.** Delivery speed must not create structural fragility.
3. **Domain-oriented design.** Business behavior belongs in domain services and modules, not in controllers or views.
4. **Modular by design.** Modules interact through explicit contracts and shared core capabilities.
5. **Secure by default.** Access is denied unless it is explicitly authorized.
6. **Observable operations.** Important actions produce logs, audit evidence, and health signals.
7. **Documentation is part of the change.** A change is incomplete when its documentation is stale.
8. **Testing by default.** New behavior must be designed so it can be tested in isolation.
9. **Replaceable components.** Infrastructure details must not dominate business logic.
10. **Sustainable evolution.** Decisions must support long-term maintenance without requiring a rewrite.

## Pull request rule

Every pull request must explain its objective, impact, risks, acceptance criteria, documentation changes, and lessons learned.
