# 5. Runtime Contracts

Runtime contracts provide stable boundaries between engines and consumers.

## Initial contracts

- `CapabilityInterface`: stable capability name and optional description.
- `TypeInterface`: stable semantic type name.
- `RegistryInterface`: registration, lookup and enumeration boundary.
- `VisitorInterface`: node visitation boundary.
- `SerializerInterface`: conversion of Runtime values into portable representations.

`DescriptorInterface` currently lives under the metadata package and remains compatible. A future refactor may relocate it only with a dedicated migration plan.

## Rules

- Contracts must remain small.
- Contracts must not depend on CodeIgniter, ERP modules or presentation concerns.
- Implementations may add richer APIs without expanding the base contract prematurely.
- New methods require at least one concrete consumer.
