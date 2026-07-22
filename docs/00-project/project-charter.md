# Project Charter — TraceOps ERP

## Propósito

Diseñar e implementar un ERP orientado a procesos que permita administrar servicios operativos con trazabilidad completa desde la oportunidad comercial hasta el cierre administrativo y financiero.

## Problema que resuelve

En una operación tradicional, la información de un servicio suele quedar fragmentada entre correos, hojas de cálculo, módulos independientes, documentos y conversaciones. Esto dificulta conocer el estado real, los responsables, las evidencias, los costos y el historial de decisiones.

TraceOps ERP reúne ese contexto en un **Expediente de Servicio** y coordina el trabajo mediante flujos configurables.

## Objetivos

1. Centralizar la información operativa y documental de cada servicio.
2. Guiar la ejecución mediante estados, tareas, responsables y reglas.
3. Registrar una bitácora auditable de acciones y cambios.
4. Integrar el ciclo comercial, operativo, documental y financiero.
5. Entregar indicadores confiables sobre tiempos, costos, calidad y cumplimiento.

## Alcance inicial

- Seguridad, usuarios, roles y permisos.
- Clientes, contactos y oportunidades.
- Cotizaciones y aprobación comercial.
- Motor de workflows.
- Expedientes de servicio.
- Órdenes de trabajo, tareas y asignaciones.
- Evidencias y documentos.
- Equipos y recursos operativos.
- Facturación, cuentas por cobrar y costos.
- Reportes y tableros.

## Fuera del alcance inicial

- Nómina completa de propósito general.
- Contabilidad financiera integral.
- Manufactura avanzada.
- Reemplazo inmediato de todos los sistemas externos existentes.

Estos puntos podrán incorporarse mediante integraciones o fases posteriores.

## Partes interesadas

- Dirección y gerencia.
- Operaciones.
- Comercial y servicio al cliente.
- Finanzas y administración.
- Supervisores y personal de campo.
- Tecnología y soporte.
- Clientes con acceso futuro al portal.

## Criterios de éxito

- Un expediente permite conocer el estado integral de un servicio sin consultar fuentes externas.
- Las transiciones críticas quedan auditadas.
- Los responsables reciben tareas claras y medibles.
- Los documentos y evidencias se relacionan con el expediente correcto.
- La información operativa puede convertirse en indicadores de gestión.
- Las nuevas capacidades se entregan mediante Pull Requests revisables y documentadas.

## Restricciones iniciales

- Stack principal basado en PHP 8.2+, CodeIgniter 4 y MySQL.
- Desarrollo incremental, evitando una implementación monolítica de gran alcance.
- Seguridad y trazabilidad se consideran requisitos transversales, no fases opcionales.
