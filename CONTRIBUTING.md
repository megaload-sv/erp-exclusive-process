# Contribución a TraceOps ERP

## Flujo de trabajo

1. Actualizar `main`.
2. Crear una rama con propósito único.
3. Implementar cambios pequeños y coherentes.
4. Actualizar documentación y pruebas relacionadas.
5. Abrir una Pull Request hacia `main`.
6. Atender observaciones antes del merge.

## Nombres de ramas

```text
feature/<descripcion>
fix/<descripcion>
refactor/<descripcion>
docs/<descripcion>
chore/<descripcion>
```

Ejemplo:

```text
feature/project-documentation-foundation
```

## Commits

Se recomienda usar mensajes breves en inglés con un prefijo de intención:

```text
feat: add service file creation
fix: prevent duplicated workflow transitions
docs: define quotation approval flow
refactor: extract authorization policy
chore: configure pull request template
```

## Pull Requests

Una PR debe:

- resolver un objetivo claro;
- evitar cambios no relacionados;
- describir cómo validar el resultado;
- mencionar riesgos o migraciones;
- actualizar la documentación aplicable;
- no incluir secretos ni credenciales;
- conservar trazabilidad entre requerimiento, implementación y evidencia.

## Criterio de terminado

Un cambio está terminado cuando fue implementado, validado, documentado, revisado e integrado en `main`.
