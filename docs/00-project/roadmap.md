# Roadmap inicial

El roadmap se organiza por entregas pequeñas y revisables. Cada Pull Request debe dejar una base utilizable para la siguiente, sin mezclar demasiadas capacidades.

## Fase 0 — Fundación

### PR-001 — Project & Documentation Foundation

- Identidad y propósito del producto.
- Estructura documental.
- Project Charter.
- Visión funcional.
- Arquitectura inicial.
- Roadmap y control de progreso.
- Plantilla de Pull Request.
- Primer ADR.

### PR-002 — Application Foundation

- Instalación base de CodeIgniter 4.
- Configuración por ambientes.
- Convenciones de estructura.
- Manejo de errores y logging.
- Conexión de base de datos.
- Health check.

### PR-003 — UX/UI Design System Foundation

- Layout administrativo.
- Navegación principal.
- Tipografía, espaciado y componentes base.
- Formularios, tablas, alertas, estados y badges.
- Diseño responsivo y accesibilidad inicial.

## Fase 1 — Gobierno y procesos

### PR-004 — Security, Users & Roles

- Inicio y cierre de sesión.
- Usuarios, roles y permisos.
- Políticas de acceso.
- Bitácora inicial.

### PR-005 — Workflow Engine

- Definición de workflows.
- Estados y transiciones.
- Reglas de transición.
- Asignaciones y tareas.
- Historial de ejecución.

## Fase 2 — Ciclo comercial

### PR-006 — Customers

- Clientes y contactos.
- Direcciones y datos fiscales.
- Estado y clasificación del cliente.

### PR-007 — CRM

- Oportunidades.
- Actividades y seguimiento.
- Canales de origen.

### PR-008 — Quotations

- Cotizaciones y partidas.
- Versiones.
- Aprobaciones.
- Conversión a expediente.

## Fase 3 — Ejecución operativa

- Expedientes de servicio.
- Órdenes de trabajo.
- Planificación y asignación.
- Evidencias.
- Documentos.
- Equipos y recursos.
- Incidencias y excepciones.

## Fase 4 — Administración y analítica

- Costos y cargos.
- Facturación.
- Cuentas por cobrar.
- Compensaciones relacionadas con servicios.
- Indicadores operativos.
- Tableros ejecutivos.

## Criterio para avanzar

Una fase puede iniciar cuando la dependencia necesaria de la fase anterior está integrada en `main`, documentada y estable para el siguiente incremento. No es obligatorio completar todos los módulos de una fase para comenzar trabajo paralelo que no dependa de ellos.
