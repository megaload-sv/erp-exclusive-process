# Versionado y entregas

TraceOps ERP seguirá un desarrollo incremental basado en Pull Requests. Durante la etapa inicial, cada PR representa una unidad de entrega técnica y documental.

## Ramas

- `main`: línea estable e integrada.
- `feature/*`: nuevas capacidades.
- `fix/*`: correcciones.
- `refactor/*`: mejoras internas sin cambio funcional esperado.
- `docs/*`: documentación aislada.
- `chore/*`: configuración, mantenimiento e infraestructura.

## Versionado

Cuando exista una primera versión utilizable se adoptará versionado semántico:

```text
MAJOR.MINOR.PATCH
```

- **MAJOR:** cambios incompatibles o evolución mayor del producto.
- **MINOR:** nuevas capacidades compatibles.
- **PATCH:** correcciones compatibles.

## Notas de versión

Cada versión deberá resumir:

- funcionalidades agregadas;
- cambios relevantes;
- correcciones;
- migraciones o pasos de despliegue;
- riesgos conocidos;
- decisiones o documentación relacionada.

## Principio

No se considera una entrega únicamente por existir código en una rama. La entrega ocurre cuando el cambio está revisado, integrado, validado y documentado.
