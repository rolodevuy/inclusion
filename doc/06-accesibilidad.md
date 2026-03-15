# Guía de Accesibilidad

## Estándar objetivo
**WCAG 2.1 — Nivel AA**

La plataforma está diseñada para personas con discapacidad, por lo que la accesibilidad no es opcional sino un requisito fundamental.

---

## Principios WCAG

### 1. Perceptible
La información debe ser presentable de formas que los usuarios puedan percibir.

**Implementación:**
- Texto alternativo (`alt`) en todas las imágenes
- Etiquetas (`label`) en todos los campos de formulario
- Contraste mínimo de 4.5:1 para texto normal, 3:1 para texto grande
- No transmitir información solo por color
- Subtítulos en contenido multimedia (si aplica)

### 2. Operable
Los componentes de la interfaz deben ser operables.

**Implementación:**
- Navegación completa por teclado (Tab, Enter, Escape, flechas)
- Indicadores de foco visibles (`:focus-visible`)
- Skip links ("Ir al contenido principal")
- Sin límites de tiempo en formularios
- Sin contenido que parpadee más de 3 veces por segundo

### 3. Comprensible
La información y operación de la interfaz deben ser comprensibles.

**Implementación:**
- Lenguaje claro y sencillo
- Mensajes de error descriptivos y junto al campo
- Formularios divididos en pasos
- Comportamiento predecible de la interfaz
- Atributo `lang="es"` en el HTML

### 4. Robusto
El contenido debe ser interpretable por diversas tecnologías.

**Implementación:**
- HTML semántico (`header`, `nav`, `main`, `footer`, `section`, `article`)
- Roles ARIA solo cuando HTML semántico no es suficiente
- `aria-label`, `aria-describedby`, `aria-live` donde corresponda
- Validación de HTML

---

## Pautas específicas para Tailwind CSS

### Contraste de colores
```
Texto principal:      text-gray-900 sobre bg-white        (ratio 21:1)
Texto secundario:     text-gray-700 sobre bg-white        (ratio 12:1)
Enlaces:              text-blue-700 sobre bg-white         (ratio 8.6:1)
Botón primario:       text-white sobre bg-blue-700         (ratio 8.6:1)
Errores:              text-red-700 sobre bg-red-50         (ratio 7.8:1)
Éxito:                text-green-700 sobre bg-green-50     (ratio 7.1:1)
```

### Foco visible
```css
/* Estilo global de foco */
*:focus-visible {
    @apply outline-2 outline-offset-2 outline-blue-600;
}
```

### Tamaños de texto
- Mínimo: `text-base` (16px)
- Formularios: `text-base` o `text-lg`
- Encabezados: `text-xl` a `text-3xl`
- No usar unidades fijas (px) para texto — usar rem/em

### Espaciado
- Áreas clicables mínimo 44x44px
- Espaciado generoso entre elementos interactivos (`space-y-4`, `gap-4`)

---

## Componentes accesibles

### Skip link
```html
<a href="#main-content"
   class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4
          focus:bg-white focus:px-4 focus:py-2 focus:z-50">
    Ir al contenido principal
</a>
```

### Formulario accesible
```html
<div class="space-y-2">
    <label for="nombre" class="block text-base font-medium text-gray-900">
        Nombre completo <span class="text-red-600" aria-hidden="true">*</span>
        <span class="sr-only">(obligatorio)</span>
    </label>
    <input type="text" id="nombre" name="nombre" required
           aria-describedby="nombre-help"
           class="block w-full rounded-md border-gray-300 text-base
                  focus:border-blue-500 focus:ring-blue-500">
    <p id="nombre-help" class="text-sm text-gray-600">
        Ingresa tu nombre tal como aparece en tu documento.
    </p>
</div>
```

### Alertas
```html
<div role="alert" class="rounded-md bg-red-50 p-4">
    <p class="text-red-700">Mensaje de error descriptivo.</p>
</div>
```

### Navegación
```html
<nav aria-label="Navegación principal">
    <ul role="list">
        <li><a href="/" aria-current="page">Inicio</a></li>
        <li><a href="/perfil">Mi Perfil</a></li>
    </ul>
</nav>
```

---

## Checklist de accesibilidad por vista

Antes de dar por terminada cada vista, verificar:

- [ ] Navegación completa por teclado (Tab recorre todos los elementos interactivos)
- [ ] Orden de tabulación lógico
- [ ] Todos los campos tienen `label` asociado
- [ ] Mensajes de error vinculados con `aria-describedby`
- [ ] Imágenes tienen `alt` descriptivo
- [ ] Contraste de colores cumple ratio mínimo
- [ ] Encabezados en orden jerárquico (h1 > h2 > h3)
- [ ] Botones tienen texto descriptivo (no solo iconos)
- [ ] Indicador de foco visible en todos los elementos interactivos
- [ ] Funciona con zoom al 200%
