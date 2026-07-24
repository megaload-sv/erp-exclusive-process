# 3. Components and Descriptors

## Components

A component is a Runtime node that declares a stable type, view, property schema and semantic behavior. Components may participate in ordinary child composition and named slots.

## Descriptors

A descriptor is the portable semantic representation of a component. Consumers must inspect descriptors instead of relying on concrete component classes.

The canonical component descriptor contains:

- `type`
- `class`
- `displayName`
- `category`
- `view`
- `properties`
- `slots`
- `capabilities`
- `events`

## Universal language

Descriptors are the shared language between the Runtime, Developer Console, Studio, documentation, marketplace and AI consumers.

## Compatibility

Legacy metadata APIs may delegate to descriptors, but new consumers should use `describe()` and descriptor contracts directly.
