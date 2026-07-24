# C-012 — Semantic Query Engine

The Semantic Query Engine turns the TraceOps Semantic Runtime into a queryable knowledge platform.

## Entry point

Queries are created through the Runtime Kernel:

```php
$query = $kernel->query();
```

Consumers do not need to construct or coordinate registries directly.

## Entity selection

```php
$kernel->query()->entities()->get();
$kernel->query()->components()->get();
$kernel->query()->properties()->get();
$kernel->query()->types()->get();
$kernel->query()->capabilities()->get();
$kernel->query()->metadata()->get();
$kernel->query()->slots()->get();
```

## Filters

```php
$kernel->query()
    ->components()
    ->whereIdentity('component.button')
    ->first();
```

```php
$kernel->query()
    ->components()
    ->whereAttribute('category', 'Forms')
    ->get();
```

Nested attributes can be addressed with dot notation.

```php
$kernel->query()
    ->properties()
    ->whereAttribute('metadata.group', 'content')
    ->get();
```

## Semantic graph filters

Relationship-aware filters query meaning instead of registry implementation details.

```php
$kernel->query()
    ->components()
    ->supporting('clickable')
    ->get();
```

```php
$kernel->query()
    ->components()
    ->havingProperty('label')
    ->get();
```

## Ordering and limits

```php
$result = $kernel->query()
    ->components()
    ->orderBy('name')
    ->limit(10)
    ->get();
```

## Results

`RuntimeQueryResult` is an iterable, countable semantic collection.

```php
$result->all();
$result->first();
$result->count();
$result->isEmpty();
$result->catalog();
```

## Architectural rule

Runtime consumers must initiate semantic discovery through `RuntimeKernelInterface::query()` instead of coordinating specialized registries themselves.

The query engine may internally use the Knowledge Registry and Relationship Registry, but those implementation details remain behind the Runtime contract.

## Future evolution

Later capabilities can extend this language with:

- reusable filter objects
- logical groups
- projections
- pagination
- graph depth
- path traversal
- query serialization
- execution diagnostics

These additions must remain backward compatible with the API introduced by C-012.
