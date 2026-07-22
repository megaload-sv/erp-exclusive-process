# TraceOps ERP

**Gestión Operativa con Trazabilidad Completa**

TraceOps ERP es una plataforma empresarial orientada a procesos para gestionar servicios de principio a fin. Su núcleo no parte de módulos aislados, sino del **Expediente de Servicio**, que concentra participantes, estados, tareas, documentos, evidencias, costos, facturación y trazabilidad.

## Principios del producto

- **Process Driven ERP:** el proceso operativo define la experiencia del sistema.
- **Expediente como eje:** toda la información relevante de un servicio se consulta desde un único contexto.
- **Trazabilidad completa:** cada cambio importante debe registrar actor, fecha, origen y resultado.
- **Configuración antes que código:** estados, transiciones, responsables y reglas deben ser configurables cuando sea viable.
- **Documentación viva:** las decisiones funcionales y técnicas forman parte del repositorio.

## Stack objetivo

- PHP 8.2+
- CodeIgniter 4
- MySQL
- Tailwind CSS
- Composer
- GitHub

## Estado actual

El proyecto se encuentra en su fase de fundación. La primera entrega establece la visión, arquitectura inicial, documentación, roadmap y reglas de colaboración antes de iniciar los módulos de negocio.

Consulta el índice principal en [`docs/README.md`](docs/README.md) y el seguimiento en [`docs/00-project/progress.md`](docs/00-project/progress.md).

## Flujo de desarrollo

```text
main
  └── feature/<nombre-de-la-entrega>
        └── commits
              └── pull request
                    └── revisión
                          └── merge
```

Cada cambio funcional debe incluir documentación suficiente para comprender su propósito, alcance, impacto y criterios de aceptación.
