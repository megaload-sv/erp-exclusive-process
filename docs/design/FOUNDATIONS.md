# TraceOps Design Foundations

TraceOps utiliza un sistema de tokens para mantener una experiencia visual consistente sin acoplar los módulos de negocio a valores CSS concretos.

> La plataforma existe para acelerar el producto, no para retrasarlo.

## Convención de tokens

El sistema separa dos niveles:

- `--to-ref-*`: valores de referencia. Representan la paleta, escala tipográfica, espaciado, radios, elevación, movimiento y capas.
- `--to-sys-*`: valores semánticos. Expresan intención de uso y son los únicos que deberían consumir los componentes.

Ejemplo:

```css
--to-ref-color-brand-900: #173b57;
--to-sys-color-primary: var(--to-ref-color-brand-900);
```

Un componente debe usar `--to-sys-color-primary`, no el hexadecimal ni el token de referencia. Esto permite cambiar el tema sin modificar el componente.

## Colores semánticos

Los tokens principales son:

| Token | Uso |
|---|---|
| `--to-sys-color-primary` | Acciones y elementos principales |
| `--to-sys-color-background` | Fondo general de la aplicación |
| `--to-sys-color-surface` | Superficies, paneles y tarjetas |
| `--to-sys-color-surface-muted` | Superficies secundarias |
| `--to-sys-color-text` | Texto principal |
| `--to-sys-color-text-subtle` | Texto secundario |
| `--to-sys-color-text-muted` | Metadatos y ayudas |
| `--to-sys-color-border` | Divisiones y bordes estándar |
| `--to-sys-color-success` | Estados exitosos |
| `--to-sys-color-warning` | Advertencias |
| `--to-sys-color-danger` | Errores y acciones destructivas |
| `--to-sys-color-info` | Información contextual |

Los colores no deben utilizarse como único mecanismo para comunicar un estado. Deben acompañarse de texto, iconografía o atributos accesibles.

## Tipografía

La familia principal es `Inter`, con fuentes del sistema como respaldo. La escala disponible va de `xs` a `3xl` y utiliza pesos de `regular` a `bold`.

Los componentes deben consumir los tokens de tipografía en lugar de declarar tamaños arbitrarios.

```css
font: var(--to-ref-font-weight-bold)
      var(--to-ref-font-size-sm)/1
      var(--to-sys-font-family);
```

## Espaciado

La escala está basada en múltiplos de `0.25rem` y utiliza nombres numéricos:

```text
0, 1, 2, 3, 4, 5, 6, 8, 10, 12, 16
```

Ejemplo:

```css
padding: var(--to-ref-space-4);
gap: var(--to-ref-space-2);
```

No deben agregarse nuevos valores hasta que exista una necesidad real y repetida en el producto.

## Forma y elevación

Los controles utilizan `--to-sys-radius-control` y los contenedores utilizan `--to-sys-radius-container`.

La elevación se limita a tres niveles:

- `sm`: separación ligera.
- `md`: menús, elementos flotantes y énfasis moderado.
- `lg`: overlays o elementos de alta prioridad.

Las sombras no deben sustituir una jerarquía estructural clara.

## Movimiento

Las transiciones deben ser breves, funcionales y respetar `prefers-reduced-motion`.

El movimiento debe ayudar a comprender un cambio de estado; no debe utilizarse únicamente como decoración.

## Capas

La escala de `z-index` evita valores arbitrarios:

```text
base → sticky → dropdown → overlay → modal → toast
```

Todo componente flotante debe usar uno de estos niveles.

## Temas

El tema claro es el predeterminado. El tema puede seleccionarse mediante el atributo `data-to-theme` en el elemento raíz:

```html
<html lang="es" data-to-theme="light">
```

La base también incluye tokens para `dark`, pero la activación funcional del selector de tema se implementará únicamente cuando el producto lo necesite.

## Reglas de adopción

1. Los módulos no deben declarar colores de marca directamente.
2. Los componentes consumen tokens semánticos.
3. Los valores de referencia solo se modifican en la fundación.
4. Un token nuevo debe resolver una necesidad repetida, no un caso aislado.
5. Las mejoras visuales no deben bloquear la entrega de valor de negocio.

## Compatibilidad

El archivo mantiene temporalmente alias para los nombres usados durante la primera etapa del proyecto. Esto permite migrar los consumidores existentes sin romper el dashboard. Los alias podrán retirarse cuando toda la interfaz utilice la convención `ref/sys`.
