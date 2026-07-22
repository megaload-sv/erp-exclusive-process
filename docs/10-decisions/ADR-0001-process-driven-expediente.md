# ADR-0001: ERP orientado a procesos y centrado en el expediente

- **Estado:** Aceptado
- **Fecha:** 2026-07-22
- **Decisores:** Equipo inicial de TraceOps ERP

## Contexto

Los ERP tradicionales suelen presentar la operación como un conjunto de módulos independientes. Aunque esta estructura facilita clasificar datos, obliga a los usuarios a reconstruir el contexto de un servicio navegando entre clientes, órdenes, archivos, tareas, costos y facturas.

TraceOps ERP está dirigido a organizaciones cuya unidad principal de trabajo es un servicio que atraviesa varias áreas y requiere coordinación, evidencia y seguimiento histórico.

## Decisión

El producto se diseñará como un **Process Driven ERP** y utilizará el **Expediente de Servicio** como agregado de navegación y trazabilidad.

El expediente:

- identifica el proceso aplicable;
- mantiene el estado operativo actual;
- relaciona las entidades especializadas;
- presenta el historial del servicio;
- sirve como contexto para permisos, tareas, documentos y eventos;
- conecta las etapas comercial, operativa y financiera.

Los módulos seguirán existiendo como límites funcionales y técnicos, pero la experiencia principal del usuario estará guiada por el proceso y el expediente.

## Consecuencias positivas

- Visibilidad integral del servicio.
- Menor fragmentación de información.
- Auditoría más comprensible.
- Mejor coordinación entre áreas.
- Posibilidad de medir tiempos de ciclo y cuellos de botella.
- Base adecuada para workflows configurables.

## Consecuencias y riesgos

- El expediente puede crecer excesivamente si se convierte en una entidad que contiene toda la lógica.
- Se requiere disciplina para mantener límites entre módulos.
- La autorización debe considerar tanto permisos globales como contexto del expediente.
- Los cambios de workflow requieren versionado y reglas claras.
- Las consultas integrales pueden necesitar modelos de lectura optimizados.

## Medidas de control

- Mantener las entidades especializadas dentro de sus módulos.
- Usar servicios de aplicación para coordinar operaciones entre módulos.
- Registrar eventos y transiciones de forma explícita.
- Separar modelos de escritura y vistas de lectura cuando la complejidad lo justifique.
- Documentar cada cambio significativo de arquitectura mediante ADR.

## Alternativas consideradas

### ERP estrictamente modular

Se descartó como enfoque principal porque reproduce la fragmentación que el producto busca resolver.

### Microservicios desde el inicio

Se descartó por aumentar complejidad operativa antes de validar los límites y necesidades reales del dominio.

### Sistema de tickets genérico

Se descartó porque no cubre adecuadamente la relación comercial, documental, operativa y financiera requerida.
