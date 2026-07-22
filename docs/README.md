# Documentación de TraceOps ERP

Este directorio conserva la definición funcional, técnica y operativa del producto. La documentación debe actualizarse en la misma Pull Request que modifica el comportamiento relacionado.

## Estructura

| Directorio | Propósito |
|---|---|
| `00-project/` | Alcance, roadmap, progreso, riesgos y gobierno del proyecto. |
| `01-functional/` | Visión del producto, actores, reglas y requisitos funcionales. |
| `02-architecture/` | Arquitectura de software, límites y principios técnicos. |
| `03-database/` | Modelo de datos, convenciones y diccionario. |
| `04-modules/` | Diseño funcional y técnico por capacidad del ERP. |
| `05-workflows/` | Procesos, estados, transiciones y responsables. |
| `06-security/` | Autenticación, autorización, auditoría y protección de datos. |
| `07-integrations/` | Sistemas externos, contratos y sincronizaciones. |
| `08-api/` | Convenciones y especificaciones de API. |
| `09-deployment/` | Ambientes, despliegues, configuración y recuperación. |
| `10-decisions/` | Architecture Decision Records (ADR). |
| `11-releases/` | Notas de versión y cambios relevantes. |
| `12-user-guides/` | Manuales para usuarios finales y administradores. |
| `features/` | Especificaciones de funcionalidades concretas. |
| `book/` | Contenido editorial del Engineering Book. |

## Documentos iniciales

- [Project Charter](00-project/project-charter.md)
- [Roadmap](00-project/roadmap.md)
- [Progreso](00-project/progress.md)
- [Visión funcional](01-functional/product-vision.md)
- [Arquitectura general](02-architecture/architecture-overview.md)
- [ADR-0001: ERP orientado a procesos y expedientes](10-decisions/ADR-0001-process-driven-expediente.md)

## Regla de mantenimiento

Una funcionalidad no se considera terminada cuando su documentación, criterios de aceptación o impacto arquitectónico permanecen desactualizados.
