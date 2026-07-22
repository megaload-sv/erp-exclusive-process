# Arquitectura general

## Enfoque inicial

TraceOps ERP iniciará como un **monolito modular** construido con CodeIgniter 4. Este enfoque permite avanzar con rapidez manteniendo límites claros entre capacidades, sin asumir prematuramente la complejidad operativa de microservicios.

## Capas principales

```text
HTTP / CLI
    ↓
Controllers
    ↓
Application Services / Use Cases
    ↓
Domain Rules
    ↓
Repositories / Models / Integrations
    ↓
MySQL, almacenamiento de archivos y servicios externos
```

### Presentación

Controladores, vistas, componentes y respuestas API. Esta capa interpreta la solicitud y delega la operación; no debe concentrar reglas de negocio complejas.

### Aplicación

Coordina casos de uso, transacciones, autorizaciones, eventos y respuestas. Representa las acciones que el sistema permite ejecutar.

### Dominio

Contiene reglas, estados, invariantes y conceptos del negocio. Debe evitar dependencias innecesarias de infraestructura.

### Infraestructura

Implementa persistencia, correo, archivos, integraciones, colas y otros detalles técnicos.

## Módulos funcionales previstos

- Identity & Access
- Customers
- CRM
- Quotations
- Workflow
- Service Files
- Operations
- Work Orders
- Evidence & Documents
- Equipment & Resources
- Billing
- Accounts Receivable
- Compensation
- Reporting & BI

Cada módulo debe exponer servicios claros y evitar acceso directo indiscriminado a tablas pertenecientes a otra capacidad.

## Identificadores y auditoría

Las entidades principales utilizarán identificadores internos consistentes. Cuando se requieran referencias públicas se evaluará el uso de UUID. Las tablas transaccionales deberán considerar, según su naturaleza:

- fecha y usuario de creación;
- fecha y usuario de modificación;
- estado lógico;
- versión o mecanismo de concurrencia cuando sea necesario;
- origen de la operación;
- correlación con expediente o proceso;
- bitácora separada para eventos sensibles.

## Transacciones

Los casos de uso que modifican varias entidades relacionadas deben ejecutarse dentro de una transacción de base de datos. El cambio de estado de un expediente no debe quedar aplicado si falla una acción obligatoria asociada.

## Integraciones

Las integraciones externas se encapsularán detrás de contratos propios. El dominio no debe depender directamente de SDK o formatos específicos de terceros.

## Seguridad

- Autenticación centralizada.
- Autorización por permisos y contexto.
- Validación de entrada en límites del sistema.
- Protección CSRF para formularios web.
- Escape de salida en vistas.
- Gestión segura de secretos por ambiente.
- Auditoría de accesos y operaciones críticas.

## Evolución

El monolito modular podrá separar componentes cuando existan razones medibles: escalabilidad independiente, aislamiento operativo, ciclos de despliegue distintos o límites organizacionales claros. La separación no será un objetivo por sí misma.
