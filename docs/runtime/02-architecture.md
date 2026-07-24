# 2. Architecture

## Dependency direction

```text
Business Applications
        ↓
Developer Console / Studio / AI
        ↓
Runtime Services
        ↓
Runtime Contracts
```

Dependencies must point toward stable Runtime contracts. The Runtime must never depend on ERP modules, Studio screens or AI integrations.

## Layer boundaries

### Runtime

Owns components, trees, slots, descriptors, capabilities, types, registries, visitors, serializers, renderers and runtime diagnostics.

### Developer Platform

Consumes Runtime contracts to expose inspection, diagnostics, preview and performance tooling.

### Studio

Produces and edits semantic component trees. It must not generate application-specific HTML as its primary artifact.

### ERP

Owns business modules and consumes Runtime capabilities. When an ERP module needs a reusable primitive, that primitive is introduced into the Runtime first.

## Pull request rule

A Runtime pull request is complete only when it includes infrastructure, Runtime integration, visible consumption, tests and documentation.
