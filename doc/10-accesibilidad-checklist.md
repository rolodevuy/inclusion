# Checklist de Accesibilidad Web — WCAG 2.1 AA

Guía de referencia para garantizar que una web sea accesible según las Pautas de Accesibilidad para el Contenido Web (WCAG) 2.1 nivel AA.

---

## 1. Perceptible

El contenido debe ser presentado de formas que los usuarios puedan percibir.

### 1.1 Alternativas de texto
- [ ] Todas las imágenes tienen atributo `alt` descriptivo
- [ ] Imágenes decorativas tienen `alt=""` o `aria-hidden="true"`
- [ ] Iconos SVG decorativos tienen `aria-hidden="true"`
- [ ] Botones con solo ícono tienen `aria-label` descriptivo

### 1.2 Contenido multimedia
- [ ] Videos tienen subtítulos
- [ ] Audio tiene transcripción
- [ ] Contenido multimedia tiene audiodescripción si es necesario

### 1.3 Adaptable
- [ ] La estructura del contenido se transmite con HTML semántico (headings, listas, tablas)
- [ ] La jerarquía de headings es correcta (h1 → h2 → h3, sin saltar niveles)
- [ ] Los formularios usan `<label>`, `<fieldset>` y `<legend>` correctamente
- [ ] Las tablas tienen `<th>` con `scope="col"` o `scope="row"`
- [ ] Las tablas tienen `<caption>` descriptivo
- [ ] El orden del DOM refleja el orden visual

### 1.4 Distinguible
- [ ] **Contraste mínimo 4.5:1** para texto normal sobre su fondo
- [ ] **Contraste mínimo 3:1** para texto grande (18px+ o 14px+ bold)
- [ ] Contraste mínimo 3:1 para elementos de interfaz (bordes, iconos)
- [ ] El texto se puede redimensionar hasta 200% sin pérdida de funcionalidad
- [ ] No se usa solo color para transmitir información (ej: errores también con texto/icono)
- [ ] El contenido se adapta a distintos tamaños de pantalla (responsive)

#### Colores seguros en Tailwind CSS (sobre fondo blanco):
| Clase | Ratio aprox. | Cumple AA |
|-------|-------------|-----------|
| `text-gray-400` | ~3.0:1 | No |
| `text-gray-500` | ~4.6:1 | Sí |
| `text-gray-600` | ~5.7:1 | Sí |
| `text-gray-700` | ~8.6:1 | Sí |
| `text-gray-900` | ~16:1 | Sí |
| `text-blue-700` | ~4.8:1 | Sí |
| `text-red-600` | ~4.5:1 | Sí (límite) |
| `text-green-700` | ~5.2:1 | Sí |

---

## 2. Operable

Los usuarios deben poder operar la interfaz.

### 2.1 Teclado
- [ ] Todos los elementos interactivos son alcanzables con Tab
- [ ] El orden de tabulación es lógico y predecible
- [ ] No hay trampas de teclado (el usuario siempre puede salir con Tab o Escape)
- [ ] Los atajos de teclado no interfieren con los del navegador o sistema operativo
- [ ] Menús desplegables se pueden navegar con flechas y cerrar con Escape
- [ ] Modales atrapan el foco dentro del diálogo

### 2.2 Tiempo suficiente
- [ ] No hay límites de tiempo automáticos (o son extensibles)
- [ ] El contenido que se mueve/parpadea se puede pausar

### 2.3 Convulsiones
- [ ] No hay contenido que parpadee más de 3 veces por segundo

### 2.4 Navegable
- [ ] Hay un **skip link** ("Ir al contenido principal") como primer elemento
- [ ] Las páginas tienen `<title>` descriptivo
- [ ] Los links tienen texto descriptivo (no "click aquí")
- [ ] Hay múltiples formas de llegar a cada página (navegación, buscador, links)
- [ ] Los headings y labels son descriptivos
- [ ] El **indicador de foco** es visible en todos los elementos interactivos
- [ ] El propósito de cada link se puede determinar por su texto (o contexto inmediato)

### 2.5 Modalidades de entrada
- [ ] Los gestos complejos (pinch, swipe) tienen alternativas simples
- [ ] Las acciones se pueden cancelar (el evento se dispara en `mouseup`, no `mousedown`)

---

## 3. Comprensible

El contenido debe ser comprensible.

### 3.1 Legible
- [ ] El atributo `lang` está en el `<html>` (ej: `lang="es"`)
- [ ] Si hay contenido en otro idioma, tiene su propio `lang`

### 3.2 Predecible
- [ ] Los elementos interactivos no cambian el contexto al recibir foco
- [ ] Los formularios no se envían automáticamente al cambiar un campo
- [ ] La navegación es consistente en todas las páginas
- [ ] Los componentes similares se comportan de forma similar

### 3.3 Entrada asistida
- [ ] Los errores de formulario se identifican y describen con texto
- [ ] Los campos requeridos están marcados (con `required` y/o texto visual)
- [ ] Los errores tienen `role="alert"` para ser anunciados por lectores de pantalla
- [ ] Los errores están asociados al campo con `aria-describedby`
- [ ] Se sugieren correcciones cuando es posible
- [ ] Las acciones importantes son reversibles o requieren confirmación

---

## 4. Robusto

El contenido debe ser compatible con tecnologías asistivas.

### 4.1 Compatible
- [ ] El HTML es válido (sin IDs duplicados, tags cerrados correctamente)
- [ ] Los componentes personalizados tienen roles ARIA apropiados
- [ ] Los estados se comunican con ARIA (`aria-expanded`, `aria-selected`, `aria-current`)
- [ ] Los mensajes dinámicos usan `aria-live` para ser anunciados

---

## Componentes comunes y sus requisitos ARIA

### Modales / Diálogos
```html
<div role="dialog" aria-modal="true" aria-labelledby="titulo-modal">
  <h2 id="titulo-modal">Título del modal</h2>
  <!-- contenido -->
</div>
<!-- Backdrop con aria-hidden="true" -->
```
- Atrapar foco dentro del modal
- Cerrar con Escape
- Devolver foco al elemento que lo abrió

### Menús desplegables
```html
<button aria-haspopup="true" aria-expanded="false">Menú</button>
<div role="menu">
  <a role="menuitem">Opción 1</a>
  <a role="menuitem">Opción 2</a>
</div>
```
- Navegar con flechas arriba/abajo
- Cerrar con Escape
- `aria-expanded` actualizado dinámicamente

### Formularios
```html
<label for="email">Email *</label>
<input id="email" type="email" required aria-describedby="email-error">
<p id="email-error" role="alert">El email es obligatorio</p>
```
- Cada input tiene un `<label>` asociado
- Grupos de campos usan `<fieldset>` + `<legend>`
- Errores asociados con `aria-describedby`

### Tablas de datos
```html
<table>
  <caption>Lista de usuarios</caption>
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>...</tbody>
</table>
```

### Navegación
```html
<nav aria-label="Navegación principal">
  <a href="/" aria-current="page">Inicio</a>
  <a href="/about">Nosotros</a>
</nav>
```
- `aria-current="page"` en el link activo
- `aria-label` si hay múltiples `<nav>`

### Alertas y mensajes dinámicos
```html
<div role="alert">Operación exitosa</div>
<!-- o para menos urgencia: -->
<div aria-live="polite">Se guardaron los cambios</div>
```

### Paginación
```html
<nav aria-label="Paginación">
  <a href="?page=1">1</a>
  <a href="?page=2" aria-current="page">2</a>
  <a href="?page=3">3</a>
</nav>
```

---

## Herramientas de prueba

### Automatizadas
- **axe DevTools** (extensión Chrome): detecta ~30% de problemas
- **Lighthouse** (Chrome DevTools > Audits): auditoría rápida
- **WAVE** (wave.webaim.org): evaluador visual de accesibilidad

### Manuales (imprescindibles)
- **Navegación por teclado**: Tab, Shift+Tab, Enter, Escape, flechas
- **Lector de pantalla**: NVDA (Windows, gratuito), VoiceOver (macOS/iOS), TalkBack (Android)
- **Zoom al 200%**: verificar que nada se rompa
- **Modo alto contraste**: Windows tiene modo integrado

### Contraste
- **WebAIM Contrast Checker**: webaim.org/resources/contrastchecker
- **Colour Contrast Analyser** (app de escritorio)

---

## Fuentes y referencias

- **WCAG 2.1**: w3.org/TR/WCAG21
- **WAI-ARIA 1.2**: w3.org/TR/wai-aria-1.2
- **ARIA Authoring Practices Guide**: w3.org/WAI/ARIA/apg
- **WebAIM**: webaim.org
- **A11y Project**: a11yproject.com/checklist
- **MDN Accessibility**: developer.mozilla.org/en-US/docs/Web/Accessibility
