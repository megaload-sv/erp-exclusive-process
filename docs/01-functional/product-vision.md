# Visión funcional

## Propuesta de valor

TraceOps ERP permite que una organización gestione servicios complejos desde una visión única y trazable. En lugar de navegar por módulos desconectados, el usuario trabaja dentro del contexto del proceso y del expediente correspondiente.

## Concepto central: Expediente de Servicio

El Expediente de Servicio es el contenedor funcional que relaciona:

- cliente, contactos y ubicaciones;
- oportunidad y cotización de origen;
- tipo de servicio y workflow aplicable;
- estado actual e historial de transiciones;
- responsables, participantes, tareas y fechas;
- órdenes de trabajo y actividades;
- documentos, evidencias y observaciones;
- equipos y recursos utilizados;
- incidencias, riesgos y excepciones;
- costos, cargos, facturas y cobros;
- bitácora de acciones.

El expediente no reemplaza las entidades especializadas. Las conecta y presenta como una historia operacional coherente.

## Ciclo principal

```text
Prospecto / solicitud
        ↓
Oportunidad comercial
        ↓
Cotización y aprobación
        ↓
Creación del expediente
        ↓
Planificación y asignación
        ↓
Ejecución del servicio
        ↓
Evidencias y validación
        ↓
Facturación y cobro
        ↓
Cierre y análisis
```

## Actores iniciales

- Administrador del sistema.
- Dirección o gerencia.
- Ejecutivo comercial.
- Coordinador de operaciones.
- Supervisor.
- Técnico u operador.
- Responsable documental.
- Finanzas y cuentas por cobrar.
- Auditor o usuario de consulta.
- Cliente externo, en una fase posterior.

## Capacidades transversales

### Trazabilidad

Toda acción sensible debe poder responder: qué ocurrió, quién la realizó, cuándo ocurrió, desde qué contexto y cuál fue el resultado.

### Workflow

Los procesos deben modelarse mediante estados, transiciones, permisos, condiciones y acciones. Una transición no es solamente un cambio de texto; puede validar requisitos, generar tareas, solicitar aprobación o registrar eventos.

### Gestión documental

Los documentos y evidencias deben estar clasificados, versionados cuando corresponda y vinculados al expediente, actividad o entidad que les da contexto.

### Alertas y vencimientos

Las fechas comprometidas, tareas pendientes y excepciones deben convertirse en alertas accionables, no solamente en datos almacenados.

### Indicadores

Los datos transaccionales deben permitir medir tiempos de ciclo, cumplimiento, productividad, costos, rentabilidad, incidencias y calidad.

## Principios de experiencia de usuario

- Mostrar primero el contexto necesario para tomar decisiones.
- Reducir navegación entre pantallas desconectadas.
- Hacer visible el siguiente paso permitido.
- Diferenciar claramente estados normales, alertas y bloqueos.
- Evitar que el usuario tenga que reconstruir manualmente la historia del servicio.
