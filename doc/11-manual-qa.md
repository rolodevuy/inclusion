# Manual de QA — Inclusión Laboral

Guía paso a paso para testing manual de la plataforma. Cubre funcionalidad, accesibilidad y casos borde.

**Usuarios de prueba** (creados por DemoSeeder, contraseña: `password`):
- Candidatos: `candidato1@demo.com` a `candidato100@demo.com`
- Empresas: `techco@demo.com`, `hotel@demo.com`, `contaplus@demo.com`, `saludya@demo.com`, `educamas@demo.com`
- Admin: crear manualmente o usar el admin existente

---

## 1. Registro y autenticación

### 1.1 Registro de candidato
1. Ir a `/register`
2. Completar nombre, email, contraseña (mínimo 8 caracteres)
3. Seleccionar rol **Candidato**
4. Verificar que redirige al dashboard
5. Verificar que el email de verificación se envía (revisar log en `storage/logs/laravel.log`)

**Casos borde:**
- [ ] Registrar con email duplicado → debe mostrar error
- [ ] Contraseña menor a 8 caracteres → debe mostrar error
- [ ] Campos vacíos → debe mostrar errores de validación
- [ ] Intentar acceder a rutas de empresa con cuenta de candidato → debe redirigir/403

### 1.2 Registro de empresa
1. Igual que candidato pero seleccionando rol **Empresa**
2. Verificar que redirige al dashboard de empresa

### 1.3 Login
- [ ] Login con credenciales correctas → redirige al dashboard
- [ ] Login con credenciales incorrectas → muestra error
- [ ] Recuperar contraseña → envía email con link de reset
- [ ] Cerrar sesión → redirige a landing

---

## 2. Candidato

### 2.1 Crear perfil (`/candidato/perfil/crear`)
1. Completar todos los campos: departamento, categoría laboral, modalidad de trabajo
2. Completar información de discapacidad: tipo, certificado, necesidades de adaptación
3. Configurar visibilidad de discapacidad (pública / bajo solicitud / privada)
4. Seleccionar habilidades
5. Guardar y verificar que redirige al perfil

**Casos borde:**
- [ ] Guardar sin campos obligatorios → errores de validación
- [ ] Subir certificado de discapacidad (archivo PDF/imagen) → debe guardarse
- [ ] Intentar crear perfil si ya existe → debe redirigir a editar

### 2.2 Editar perfil (`/candidato/perfil/editar`)
- [ ] Modificar campos y guardar → cambios persisten
- [ ] Cambiar visibilidad de discapacidad → se refleja en cómo empresas ven el perfil
- [ ] Cambiar habilidades → se actualizan correctamente

### 2.3 Experiencia laboral
- [ ] Agregar experiencia (`/candidato/experiencias/crear`) → aparece en perfil
- [ ] Editar experiencia → cambios persisten
- [ ] Eliminar experiencia → desaparece del perfil
- [ ] Experiencia sin fecha fin (trabajo actual) → muestra "Actualidad"

### 2.4 Explorar ofertas (`/candidato/ofertas`)
1. Verificar que se muestran solo ofertas activas
2. En la primera página sin filtros, debe aparecer sección **"Recomendadas para vos"** (si el perfil tiene match ≥ 30% con alguna oferta)
3. Probar filtros: categoría, departamento, modalidad, búsqueda por texto
4. Verificar paginación

**Casos borde:**
- [ ] Candidato sin perfil completo → no muestra recomendaciones (sin error)
- [ ] No hay ofertas que matcheen ≥ 30% → no muestra sección de recomendadas
- [ ] Filtros combinados → resultados correctos

### 2.5 Ver oferta (`/candidato/ofertas/{id}`)
- [ ] Muestra toda la info de la oferta: título, descripción, requisitos, modalidad, departamento
- [ ] Botón de postularse visible si no se postuló antes
- [ ] Si ya se postuló → muestra mensaje indicándolo, sin botón

### 2.6 Postularse a oferta
1. Desde la vista de oferta, hacer clic en "Postularse"
2. Opcionalmente escribir un mensaje
3. Elegir si compartir información de accesibilidad (`compartir_accesibilidad`)
4. Enviar

**Casos borde:**
- [ ] Postularse dos veces a la misma oferta → debe impedirlo
- [ ] Postularse sin perfil completo → debe impedirlo o advertir

### 2.7 Mis postulaciones (`/candidato/postulaciones`)
- [ ] Lista todas las postulaciones del candidato
- [ ] Muestra estado de cada una (pendiente, vista, aceptada, rechazada)
- [ ] Muestra fecha y oferta asociada

### 2.8 Solicitudes de acceso (`/candidato/solicitudes`)
- [ ] Lista solicitudes de empresas que quieren ver info de accesibilidad
- [ ] Nombre de empresa es un link clickeable al perfil de la empresa
- [ ] Botón Aprobar → empresa puede ver la info
- [ ] Botón Rechazar → empresa no puede ver la info
- [ ] Verificar que al hacer clic en el nombre de empresa, se ve el perfil público

### 2.9 Ver perfil de empresa (`/candidato/empresa/{id}`)
- [ ] Muestra: nombre, sector, ubicación, web, descripción, políticas de inclusión
- [ ] Muestra ofertas activas de esa empresa
- [ ] Si el usuario no es empresa → 404

### 2.10 Mensajería (`/mensajes`)
- [ ] Lista conversaciones ordenadas por última actividad
- [ ] Muestra contador de mensajes no leídos
- [ ] Abrir conversación → muestra historial de mensajes
- [ ] Enviar mensaje → aparece en la conversación
- [ ] El otro usuario ve el mensaje como no leído

---

## 3. Empresa

### 3.1 Crear perfil (`/empresa/perfil/crear`)
- [ ] Completar: nombre empresa, sector, departamento, descripción, web
- [ ] Completar políticas de inclusión
- [ ] Guardar → redirige al perfil

### 3.2 Editar perfil (`/empresa/perfil/editar`)
- [ ] Modificar campos → cambios persisten

### 3.3 Crear oferta (`/empresa/ofertas/crear`)
- [ ] Completar: título, descripción, requisitos, categoría, departamento, modalidad
- [ ] Guardar → aparece en listado de ofertas

**Casos borde:**
- [ ] Campos obligatorios vacíos → errores de validación

### 3.4 Gestionar ofertas (`/empresa/ofertas`)
- [ ] Lista todas las ofertas de la empresa
- [ ] Editar oferta → cambios persisten
- [ ] Cambiar estado (activa/pausada/cerrada)

### 3.5 Ver oferta y postulaciones (`/empresa/ofertas/{id}`)
- [ ] Muestra detalle de la oferta
- [ ] Lista postulantes con su estado
- [ ] Sección **"Candidatos sugeridos"** con match ≥ 30%
- [ ] Click en postulante → ver perfil del candidato

### 3.6 Ver candidato postulado (`/empresa/ofertas/{oferta}/postulaciones/{postulacion}/candidato`)
- [ ] Muestra info profesional del candidato
- [ ] Si el candidato compartió accesibilidad → muestra tipo de discapacidad, certificado, necesidades
- [ ] Si no compartió → muestra mensaje "no compartió su información"
- [ ] Botones: Aceptar postulación, Rechazar postulación
- [ ] Cambiar estado → se refleja en el listado

### 3.7 Buscador de candidatos (`/empresa/buscador`)
- [ ] Buscar por categoría, departamento, habilidades
- [ ] Resultados respetan visibilidad de discapacidad del candidato
- [ ] Ver perfil de candidato desde buscador

### 3.8 Solicitar acceso a info de accesibilidad
- [ ] Desde perfil de candidato con visibilidad "bajo_solicitud" → botón solicitar
- [ ] Enviar solicitud → candidato la ve en `/candidato/solicitudes`
- [ ] No se puede enviar solicitud duplicada

### 3.9 Reportes (`/empresa/reportes`)
- [ ] Muestra métricas: ofertas por estado, postulaciones por estado
- [ ] Tasa de aceptación
- [ ] Tendencia mensual
- [ ] Top ofertas por postulaciones
- [ ] Indicadores de inclusión

### 3.10 Mensajería
- [ ] Mismas verificaciones que candidato (sección 2.10)

---

## 4. Admin

### 4.1 Dashboard (`/admin/dashboard`)
- [ ] Muestra estadísticas generales de la plataforma

### 4.2 Gestión de usuarios (`/admin/usuarios`)
- [ ] Lista todos los usuarios con filtros (buscar, rol)
- [ ] Activar/desactivar usuarios no-admin
- [ ] No se puede desactivar a un admin
- [ ] Usuario desactivado no puede hacer login

### 4.3 Catálogos (`/admin/catalogos`)
- [ ] Crear categoría laboral → aparece en listado
- [ ] Editar categoría → cambios persisten
- [ ] Eliminar categoría → desaparece (verificar que no rompe perfiles asociados)
- [ ] Crear/editar/eliminar habilidades → mismo flujo

### 4.4 Verificación de certificados (`/admin/certificados`)
- [ ] Lista certificados pendientes de verificación
- [ ] Descargar certificado → abre/descarga el archivo
- [ ] Verificar certificado → cambia estado a "verificado", aparece en historial
- [ ] Rechazar certificado → pide motivo obligatorio, cambia estado, aparece en historial
- [ ] Historial muestra: candidato, estado, observaciones, fecha

---

## 5. Accesibilidad (WCAG 2.1 AA)

Referencia completa: `doc/10-accesibilidad-checklist.md`

### 5.1 Navegación por teclado
Recorrer **toda la app** usando solo teclado. En cada página verificar:

- [ ] **Tab** avanza al siguiente elemento interactivo
- [ ] **Shift+Tab** retrocede
- [ ] El orden de tabulación es lógico (izquierda→derecha, arriba→abajo)
- [ ] **Enter** activa botones y links
- [ ] **Escape** cierra modales y dropdowns
- [ ] El **indicador de foco** (borde azul) es visible en todo momento
- [ ] No hay "trampas de teclado" (siempre se puede salir con Tab o Escape)

**Páginas críticas para testear con teclado:**
1. Landing (`/`) — skip link, navegación, botones CTA
2. Login y registro — formularios completos
3. Crear/editar perfil candidato — formulario largo con selects
4. Crear oferta — formulario con múltiples campos
5. Listado de ofertas — filtros, paginación, cards clickeables
6. Vista de oferta — botón postularse, modal de postulación
7. Mensajería — lista de conversaciones, envío de mensajes
8. Admin certificados — botones verificar/rechazar, dropdown de rechazo

### 5.2 Lector de pantalla (NVDA)
Descargar NVDA gratis desde [nvaccess.org](https://www.nvaccess.org/download/).

**Cómo usar NVDA:**
- `Insert + Espacio` → modo foco / modo navegación
- `Tab` → saltar entre elementos interactivos
- `H` → saltar entre headings
- `F` → saltar entre formularios
- `T` → saltar entre tablas
- `Insert + F7` → lista de links de la página

**En cada página verificar:**
- [ ] NVDA anuncia el título de la página (`<title>`)
- [ ] Los headings se anuncian en orden correcto (h1 → h2 → h3)
- [ ] Los formularios anuncian el label de cada campo
- [ ] Los errores de validación se anuncian automáticamente (tienen `role="alert"`)
- [ ] Los botones anuncian su propósito
- [ ] Las imágenes decorativas no se anuncian
- [ ] Los badges de estado anuncian su texto
- [ ] Los modales anuncian "diálogo" al abrirse
- [ ] Los dropdowns anuncian "menú" y su estado expandido/colapsado
- [ ] El skip link funciona: lleva al contenido principal

### 5.3 Contraste de colores
- [ ] Instalar extensión **axe DevTools** en Chrome
- [ ] Correr auditoría en cada página principal
- [ ] Verificar que no haya errores de contraste
- [ ] Verificar manualmente textos sobre fondos de color (badges, alertas)

### 5.4 Zoom
- [ ] Hacer zoom al 200% (`Ctrl + +` varias veces)
- [ ] Verificar que el contenido no se corta ni se superpone
- [ ] Verificar que la navegación sigue funcionando
- [ ] Los formularios siguen siendo usables

---

## 6. API REST

### 6.1 Endpoints públicos
Testear con navegador o Postman:

```
GET http://localhost/inclusion/public/api/ofertas
GET http://localhost/inclusion/public/api/ofertas?categoria=1&departamento=1&modalidad=presencial
GET http://localhost/inclusion/public/api/ofertas/{id}
GET http://localhost/inclusion/public/api/estadisticas
GET http://localhost/inclusion/public/api/categorias
GET http://localhost/inclusion/public/api/departamentos
```

- [ ] `/api/ofertas` → devuelve lista paginada de ofertas activas
- [ ] Filtros funcionan: `categoria`, `departamento`, `modalidad`, `buscar`
- [ ] `/api/ofertas/{id}` → devuelve oferta con detalle, solo si está activa
- [ ] `/api/ofertas/{id}` con oferta inactiva → 404
- [ ] `/api/estadisticas` → devuelve totales de la plataforma
- [ ] `/api/categorias` → lista de categorías laborales
- [ ] `/api/departamentos` → lista de departamentos

---

## 7. Privacidad y seguridad

### 7.1 Visibilidad de discapacidad
Probar con 3 configuraciones del candidato:

**Visibilidad "pública":**
- [ ] Empresa ve info de accesibilidad en buscador sin solicitar acceso

**Visibilidad "bajo_solicitud":**
- [ ] Empresa NO ve info de accesibilidad hasta que candidato apruebe
- [ ] Empresa puede enviar solicitud
- [ ] Candidato aprueba → empresa ahora ve la info
- [ ] Candidato rechaza → empresa sigue sin ver la info

**Visibilidad "privada":**
- [ ] Empresa NO ve info de accesibilidad
- [ ] No hay opción de solicitar acceso

### 7.2 Compartir en postulación
- [ ] Postularse CON `compartir_accesibilidad` → empresa ve info en vista del candidato
- [ ] Postularse SIN `compartir_accesibilidad` → empresa NO ve info

### 7.3 Aislamiento de roles
- [ ] Candidato no puede acceder a rutas `/empresa/*`
- [ ] Empresa no puede acceder a rutas `/candidato/*`
- [ ] Ninguno puede acceder a rutas `/admin/*`
- [ ] Usuario desactivado por admin no puede hacer login

---

## 8. Responsive (móvil)

Usar DevTools de Chrome (`F12` → ícono de dispositivo) o probar en celular real.

Resoluciones a testear: **375px** (iPhone SE), **768px** (tablet), **1024px** (laptop)

- [ ] Navegación se colapsa en menú hamburguesa en móvil
- [ ] Formularios son usables en pantalla chica
- [ ] Tablas hacen scroll horizontal o se adaptan
- [ ] Cards de ofertas se apilan verticalmente
- [ ] Botones tienen tamaño táctil suficiente (mínimo 44x44px)
- [ ] Texto es legible sin hacer zoom

---

## Checklist rápido por página

| Página | Teclado | NVDA | Contraste | Zoom | Responsive | Funcional |
|--------|---------|------|-----------|------|------------|-----------|
| Landing | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Login | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Registro | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Perfil candidato | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Ofertas candidato | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Detalle oferta | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Postulaciones | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Solicitudes | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Perfil empresa | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Ofertas empresa | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Crear oferta | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Ver candidato | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Buscador | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Reportes | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Mensajería | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Admin dashboard | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Admin usuarios | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Admin catálogos | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| Admin certificados | ☐ | ☐ | ☐ | ☐ | ☐ | ☐ |
| API ofertas | — | — | — | — | — | ☐ |
