# Taller Pro — Diseño de Interfaces (UX/UI)

---

## Parte 1: Dashboard Administrativo

### 1.1 Layout general

```
+------------------+--------------------------------------------------+
|                  |  Navbar Superior                                 |
|   SIDEBAR        |  +----------------------------------------------+ |
|   IZQUIERDO      |  | Buscar...   [🔔] [👤 Admin]                 | |
|   (fijo)         |  +----------------------------------------------+ |
|   260px          |                                                  |
|                  |  CONTENIDO PRINCIPAL (scrollable)                |
|  [Logo]          |                                                  |
|  ───────────     |  +-------+  +-------+  +-------+  +--------+  |
|  📊 Dashboard    |  | Activas|  | Citas |  |Clientes|  |Ingresos|  |
|  👥 Clientes     |  |   12   |  |   8   |  |  340   |  | $12.5k |  |
|  🚗 Vehículos    |  +-------+  +-------+  +-------+  +--------+  |
|  📋 Órdenes      |                                                  |
|  📅 Citas        |  +------------------+  +------------------+     |
|  🔧 Inventario   |  | 📊 Donut Chart   |  | 📈 Line Chart   |     |
|  👨‍🔧 Mecánicos   |  | Órdenes/Estado   |  | Servicios/mes   |     |
|  🛠️ Servicios    |  +------------------+  +------------------+     |
|  📄 Reportes      |                                                  |
|  ⚙️ Configuración |  +----------------------------------------------+ |
|  ───────────     |  | Últimas Órdenes de Trabajo                    | |
|  🌐 Ir al Portal |  | +---+---------+----------+--------+---------+ | |
|                  |  | #  | Cliente | Vehículo | Estado  | Total   | | |
|                  |  +---+---------+----------+--------+---------+ | |
|                  |  | 1  | Pérez   | ABC-123  | 🟡 Proc  | $450    | | |
|                  |  | 2  | López   | XYZ-789  | ✅ Comp  | $230    | | |
|                  |  | 3  | García  | DEF-456  | 🟢 Pend  | $120    | | |
|                  |  +----------------------------------------------+ |
|                  |                                                  |
+------------------+--------------------------------------------------+
```

### 1.2 Sidebar izquierdo

**Ancho:** 260px fijo, scroll oculto.

**Logo:** 40px altura, nombre "Taller Pro" al lado.

**Items de navegación:**
| Icono | Label | Ruta | Roles |
|---|---|---|---|
| Home | Dashboard | `/panel/dashboard` | admin, operador |
| Users | Clientes | `/panel/clientes` | admin, operador |
| Car | Vehiculos | `/panel/vehiculos` | admin, operador |
| FileText | Ordenes de Trabajo | `/panel/ordenes` | admin, operador |
| Calendar | Citas | `/panel/citas` | admin, operador |
| Package | Inventario | `/panel/inventario` | admin, operador |
| Wrench | Mecanicos | `/panel/mecanicos` | admin |
| Tool | Servicios | `/panel/servicios` | admin |
| BarChart3 | Reportes | `/panel/reportes` | admin |
| Settings | Configuracion | `/panel/configuracion` | admin |
| — | Separador | — | — |
| ExternalLink | Ir al Portal | `/` | admin, operador |

**Estados visuales:**
- Item activo: bg azul suave + borde izquierdo azul
- Hover: bg gris claro
- Subíndice (solo si aplica): indicador de cantidad (ej: notificaciones)

### 1.3 Navbar superior

**Altura:** 64px fijo.

**Elementos (izquierda a derecha):**
1. Botón hamburguesa (toggle sidebar en móvil)
2. Breadcrumb: `Taller Pro > Dashboard`
3. Campo de búsqueda global (cmd+K)
4. Selector de sucursal (si el usuario admin tiene múltiples)
5. Botón tema claro/oscuro
6. Campana de notificaciones con badge
7. Avatar de usuario + nombre + dropdown:
   - Mi Perfil
   - Cerrar Sesión

### 1.4 KPIs (4 tarjetas)

**Diseño de cada tarjeta:**
- Fondo blanco, border radius 12px, shadow suave
- Icono circular a la izquierda con color semántico
- Label abajo
- Valor numérico grande (font-bold, text-2xl)
- Badge de variación vs mes anterior (opcional)

| KPI | Icono | Color | Cálculo |
|---|---|---|---|
| Ordenes Activas | Wrench | Amber | COUNT WHERE estado = 'en_proceso' |
| Citas Pendientes | Calendar | Blue | COUNT WHERE estado = 'pendiente' |
| Clientes Registrados | Users | Green | COUNT clientes.activo = true |
| Ingresos del Mes | DollarSign | Indigo | SUM pagos WHERE MONTH(fecha_pago) = CURRENT |

### 1.5 Gráficos

**Donut Chart — Órdenes por Estado:**
- Dimensiones: 100% x 300px
- Segmentos: pendiente (gris), en_proceso (azul), completado (verde), cancelado (rojo)
- Label central: total de órdenes
- Usar ApexCharts

**Line Chart — Servicios Completados (últimos 6 meses):**
- Dimensiones: 100% x 300px
- Eje X: meses (jul, ago, sep, oct, nov, dic)
- Eje Y: cantidad de órdenes completadas
- Tooltip al hover
- Usar ApexCharts

### 1.6 Tablas

**Últimas Órdenes de Trabajo:**
| Columna | Justificación |
|---|---|
| # ID | Link a detalle |
| Cliente | nombre + apellido |
| Vehículo | placa |
| Estado | Badge coloreado |
| Total | moneda formateada |
| Fecha | formato corto |

**Próximas Citas (sidebar derecha o sección abajo):**
| Columna |
|---|
| Hora |
| Cliente |
| Tipo (servicio/diagnóstico) |
| Estado |

### 1.7 Tema claro/oscuro

| Variable | Claro | Oscuro |
|---|---|---|
| bg body | `#f8fafc` (slate-50) | `#0f172a` (slate-900) |
| bg card | `#ffffff` | `#1e293b` (slate-800) |
| text primary | `#0f172a` (slate-900) | `#f8fafc` (slate-50) |
| text muted | `#64748b` (slate-500) | `#94a3b8` (slate-400) |
| sidebar bg | `#ffffff` | `#1e293b` |
| border | `#e2e8f0` (slate-200) | `#334155` (slate-700) |
| primary | `#2563eb` (blue-600) | `#3b82f6` (blue-500) |
| success | `#16a34a` (green-600) | `#22c55e` (green-500) |
| warning | `#d97706` (amber-600) | `#f59e0b` (amber-500) |
| danger | `#dc2626` (red-600) | `#ef4444` (red-500) |

### 1.8 Responsive

| Breakpoint | Sidebar | Layout |
|---|---|---|
| > 1024px | Visible, fijo 260px | Normal 2 columnas |
| 768-1024px | Oculto, toggle con hamburguesa | 1 columna |
| < 768px | Overlay full-width | 1 columna, cards apiladas |

---

## Parte 2: Portal del Cliente

### 2.1 Flujo de reserva — paso a paso

```
[LANDING] → [SUCURSAL] → [VEHICULO] → [SERVICIO] → [FECHA] → [HORA] → [CONFIRMAR]
                                                                             ↓
                                                                       ✅ CITA CREADA
```

**Tiempo estimado total: < 60 segundos**

### 2.2 Landing Page

```
+-------------------------------------------------------------+
|  [Logo Taller Pro]                    [Iniciar Sesion]       |
|                                                             |
|                                                             |
|            🛞  ¿Necesitas servicio para tu                   |
|                vehículo?                                     |
|                                                             |
|         Agenda tu cita en menos de 1 minuto                  |
|                                                             |
|              [  AGENDA AHORA  ]  (botón grande CTA)          |
|                                                             |
|         o inicia sesión para ver tus órdenes                 |
|                                                             |
|       Beneficios:                                            |
|       ✅ Sin esperas  ✅ Presupuesto claro  ✅ Garantía      |
+-------------------------------------------------------------+
```

**Elementos clave:**
- Hero con ilustración de auto/taller (Tailwind + SVG)
- CTA principal: botón grande azul "Agenda Ahora"
- Link secundario: "Iniciar Sesión" (para ver órdenes existentes)
- No hay navbar compleja — solo lo esencial

### 2.3 Step 1: Seleccionar sucursal (solo si hay múltiples)

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 1 de 5                     |
|                                                             |
|  ¿Qué sucursal te queda más cerca?                           |
|                                                             |
|  +-----------+  +-----------+  +---------------------------+|
|  | 🏪         |  | 🏪         |  | 🏪                        ||
|  | Sucursal   |  | Sucursal   |  | Sucursal                 ||
|  | Centro     |  | Norte      |  | Sur                      ||
|  | Av. Principal| | Av. 2      |  | Av. 3                    ||
|  |            |  |            |  |                          ||
|  +-----------+  +-----------+  +---------------------------+|
+-------------------------------------------------------------+
```

**UX:** Tarjetas clickeables con dirección abreviada.

**Si hay una sola sucursal:** Ocultar este paso completamente, avanzar directo al paso 2.

### 2.4 Step 2: Tipo de vehículo

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 2 de 5                     |
|                                                             |
|  ¿Qué tipo de vehículo tienes?                               |
|                                                             |
|  +--------+  +--------+  +--------+  +--------+             |
|  | 🚗     |  | 🏍️     |  | 🚐     |  | 🚛     |             |
|  | Auto   |  | Moto   |  |Camioneta|  | Otro  |             |
|  +--------+  +--------+  +--------+  +--------+             |
|                                                             |
|  (selección única, visual tipo card)                         |
+-------------------------------------------------------------+
```

**UX:** Mobile-first, 2 columnas en móvil, 4 en desktop. Selección visual inmediata, sin formularios.

### 2.5 Step 3a: Elegir servicio

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 3 de 5                     |
|                                                             |
|  ¿Qué necesitas?                                             |
|                                                             |
|  [🔍 Buscar servicio...]                                     |
|                                                             |
|  Categorías:                                                 |
|  +------------------+  +------------------+                  |
|  | 🛢️ Mantenimiento |  | 🔧 Reparación   |                  |
|  | Cambio de aceite |  | Frenos          |                  |
|  | Filtros          |  | Suspensión      |                  |
|  | Batería          |  | Motor           |                  |
|  +------------------+  +------------------+                  |
|                                                             |
|  +------------------+  +------------------+                  |
|  | 🔍 Diagnóstico   |  | ⚙️ Alineación   |                  |
|  | No sé qué tiene  |  | Balanceo        |                  |
|  +------------------+  +------------------+                  |
|                                                             |
|  Selecciona un servicio o elige "Diagnóstico General"        |
+-------------------------------------------------------------+
```

**UX:** Cards organizadas por categoría con íconos. Input de búsqueda para filtrar.

### 2.6 Step 3b: Diagnóstico (alternativa)

Si el cliente seleccionó "Diagnóstico General":

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 3 de 5                     |
|                                                             |
|  Cuéntanos qué le pasa a tu vehículo                        |
|                                                             |
|  +-------------------------------------------------------+  |
|  | Hace un ruido extraño al acelerar...                   |  |
|  |                                                       |  |
|  |                                                       |  |
|  |   (textarea, 3 líneas, placeholder con ejemplos)       |  |
|  +-------------------------------------------------------+  |
|                                                             |
|  Ejemplos:                                                   |
|  🔹 Hace un ruido extraño                                   |
|  🔹 No enciende                                             |
|  🔹 Pierde aceite                                           |
|  🔹 Vibra al frenar                                         |
|                                                             |
+-------------------------------------------------------------+
```

**UX:** Textarea con placeholder y ejemplos clickeables debajo.

### 2.7 Step 4: Seleccionar fecha

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 4 de 5                     |
|                                                             |
|  ¿Para cuándo?                                              |
|                                                             |
|  [ julio 2026 ]  <  >                                       |
|                                                             |
|  Lu  Ma  Mi  Ju  Vi  Sa  Do                                 |
|       1   2   3   4   5   6                                  |
|  7   8   9  10  11  12  13                                  |
| 14  15  16  17  18  19  20                                  |
| 21  22  23  24  25  26  27                                  |
| 28  29  30  31                                               |
|                                                             |
|  Domingos deshabilitados (taller cerrado)                   |
+-------------------------------------------------------------+
```

**UX:** Calendario nativo o simple, con días sin disponibilidad deshabilitados. Mobile-first: usar input type="date" como fallback.

### 2.8 Step 5: Horarios disponibles

```
+-------------------------------------------------------------+
|  ← Volver                    Paso 5 de 5                     |
|                                                             |
|  Selecciona un horario                                      |
|                                                             |
|  09:00  ───  Disponible                                     |
|  10:00  ───  Disponible                                     |
|  11:00  ───  No disponible                                  |
|  12:00  ───  Disponible                                     |
|                                                                            
|  14:00  ───  Disponible                                     |
|  15:00  ───  No disponible                                  |
|  16:00  ───  Disponible                                     |
|  17:00  ───  No disponible                                  |
|                                                             |
|  Horario del taller: Lun - Vie 09:00 a 18:00                |
|                         Sáb 09:00 a 13:00                   |
+-------------------------------------------------------------+
```

**UX:**
- Lista vertical con slots de 1 hora
- Los slots NO disponibles se ven grises/deshabilitados
- No se muestran nombres de mecánicos
- "Disponible" en verde, "No disponible" en rojo/gris
- Al seleccionar, se resalta en azul

### 2.9 Step 6: Confirmar

```
+-------------------------------------------------------------+
|  ← Volver                                                    |
|                                                             |
|  Revisa tu cita                                              |
|                                                             |
|  🏪 Sucursal Centro                                          |
|  🚗 Automóvil                                                |
|  🛢️ Cambio de aceite                                        |
|  📅 Viernes 10 de julio, 2026                                |
|  ⏰ 10:00 - 11:00 (60 min)                                   |
|                                                             |
|  Al confirmar recibirás un correo con los detalles.          |
|                                                             |
|  [  Contacto: +591 7XXXXXXX ] (opcional)                     |
|                                                             |
|              [  CONFIRMAR CITA  ]                            |
|                                                             |
|  Al confirmar aceptas nuestros términos y condiciones.       |
+-------------------------------------------------------------+
```

**Post-confirmación:**

```
+-------------------------------------------------------------+
|                                                             |
|           ✅  Cita agendada con éxito                        |
|                                                             |
|   Recibirás un correo de confirmación en los próximos        |
|   minutos.                                                   |
|                                                             |
|   🆔 Código: CIT-001                                        |
|   📅 10/07/2026 — 10:00 am                                  |
|   🏪 Sucursal Centro                                        |
|                                                             |
|              [  Volver al inicio  ]                          |
|                                                             |
+-------------------------------------------------------------+
```

### 2.10 Otras páginas del portal

**Mis Órdenes:**
- Lista de órdenes de trabajo del cliente
- Estado, vehículo, fecha, total
- Badge de estado coloreado
- Link a detalle

**Mi Perfil:**
- Nombre, email, teléfono
- Lista de vehículos registrados (si tiene)
- Cerrar sesión

**Todas las páginas del portal:**
- Sin sidebar
- Navbar simple con logo y menú hamburguesa
- Footer mínimo con contacto del taller

---

## Parte 3: Componentes Reutilizables

### 3.1 Componentes del Dashboard

| Componente | Props | Variantes |
|---|---|---|
| `Card` | title, subtitle, padding | default, kpi, chart |
| `KpiCard` | icon, label, value, color, trend | trend up/down, sin trend |
| `StatusBadge` | status, size | sm, md — colores por estado |
| `DataTable` | columns, rows, search, pagination | con/sin acciones |
| `SidebarItem` | icon, label, active, badge, route | active, inactive, with badge |
| `Navbar` | breadcrumbs, user, notifications | — |
| `Modal` | title, size, footer | sm, md, lg, xl |
| `FormInput` | label, type, error, help | text, select, textarea, date |
| `Button` | variant, size, icon, loading | primary, secondary, danger, ghost |
| `Avatar` | src, name, size | sm, md, lg |
| `EmptyState` | icon, title, description, action | — |
| `Pagination` | current, total, perPage | — |

### 3.2 Componentes del Portal

| Componente | Props | Uso |
|---|---|---|
| `StepIndicator` | currentStep, totalSteps | Indicador de progreso en la reserva |
| `SelectCard` | icon, title, description, selected | Selección de sucursal, tipo vehículo |
| `ServiceCard` | icon, name, category, duration, price | Catálogo de servicios |
| `TimeSlot` | time, available, selected | Slots de horario |
| `ConfirmSummary` | items (icon + label + value) | Resumen antes de confirmar |
| `HeroSection` | title, subtitle, cta | Landing page |

---

## Parte 4: Vistas Blade necesarias

### 4.1 Layouts

```
resources/views/
├── layouts/
│   ├── panel.blade.php          # Layout del Dashboard (sidebar + navbar)
│   └── portal.blade.php         # Layout del Portal (navbar simple)
```

### 4.2 Vistas del Dashboard

```
resources/views/panel/
├── dashboard/
│   └── index.blade.php          # KPIs + gráficos + tabla
├── clientes/
│   ├── index.blade.php          # Tabla de clientes
│   ├── create.blade.php         # Formulario crear cliente
│   └── edit.blade.php           # Formulario editar cliente
├── vehiculos/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── ordenes/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── citas/
│   ├── index.blade.php          # Calendario/tabla de citas
│   └── asignar.blade.php        # Asignar mecánico a cita
├── inventario/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── mecanicos/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── servicios/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── reportes/
│   └── index.blade.php
├── configuracion/
│   ├── usuarios.blade.php
│   ├── roles.blade.php
│   └── sucursales.blade.php
└── componentes/
    ├── kpi-card.blade.php
    ├── status-badge.blade.php
    ├── data-table.blade.php
    ├── sidebar-item.blade.php
    └── empty-state.blade.php
```

### 4.3 Vistas del Portal

```
resources/views/portal/
├── landing.blade.php                 # Hero + CTA
├── auth/
│   ├── login.blade.php               # Login del cliente
│   └── register.blade.php            # Registro del cliente
├── reserva/
│   ├── sucursal.blade.php            # Step 1
│   ├── vehiculo.blade.php            # Step 2
│   ├── servicio.blade.php            # Step 3a - servicios
│   ├── diagnostico.blade.php         # Step 3b - descripción
│   ├── fecha.blade.php               # Step 4 - calendario
│   ├── horario.blade.php             # Step 5 - slots
│   ├── confirmar.blade.php           # Step 6 - resumen
│   └── confirmado.blade.php          # Post-confirmación
├── ordenes/
│   └── index.blade.php               # Mis órdenes
├── perfil/
│   └── index.blade.php               # Mi perfil
└── componentes/
    ├── step-indicator.blade.php
    ├── select-card.blade.php
    ├── service-card.blade.php
    ├── time-slot.blade.php
    └── confirm-summary.blade.php
```

---

## Parte 5: Estructura de carpetas completa

```
resources/
├── css/
│   └── app.css                    # Tailwind directives + variables CSS
├── js/
│   ├── app.js                     # Alpine.js + imports globales
│   ├── panel.js                   # Lógica del dashboard (sidebar toggle, etc.)
│   └── portal.js                  # Lógica del portal (stepper, calendario)
├── views/
│   ├── layouts/
│   │   ├── panel.blade.php
│   │   └── portal.blade.php
│   ├── panel/
│   │   ├── dashboard/
│   │   ├── clientes/
│   │   ├── vehiculos/
│   │   ├── ordenes/
│   │   ├── citas/
│   │   ├── inventario/
│   │   ├── mecanicos/
│   │   ├── servicios/
│   │   ├── reportes/
│   │   ├── configuracion/
│   │   └── componentes/
│   ├── portal/
│   │   ├── auth/
│   │   ├── reserva/
│   │   ├── ordenes/
│   │   ├── perfil/
│   │   └── componentes/
│   └── vendor/
│       └── ... (Breeze views)     # No tocar, son de Breeze
├── routes/
│   ├── web.php                    # Rutas del portal (públicas)
│   └── panel.php                  # Rutas del dashboard (protegidas)
```

---

## Parte 6: Paleta de colores y tipografía

### Colores primarios (Dashboard)

```
Primary:    #2563eb (blue-600)    → Botones, links, active state
Secondary:  #64748b (slate-500)   → Textos secundarios, iconos
Success:    #16a34a (green-600)   → Completado, disponible
Warning:    #d97706 (amber-600)   → En proceso, pendiente
Danger:     #dc2626 (red-600)     → Cancelado, errores
Info:       #0891b2 (cyan-600)    → Información
```

### Colores del Portal

Más cálidos y amigables que el dashboard:

```
Primary:    #3b82f6 (blue-500)
CTA:        #2563eb (blue-600)
Success:    #22c55e (green-500)
Bg hero:    gradient de blue-50 a blue-100
```

### Tipografía

```
Dashboard:  Inter (sans-serif) — moderna, profesional, limpia
Portal:     Inter — misma familia, consistencia

Tamaños:
  h1:  text-3xl (30px)
  h2:  text-2xl (24px)
  h3:  text-xl  (20px)
  body: text-sm (14px) en dashboard, text-base (16px) en portal
  small: text-xs (12px)
```

### Iconografía

```
Librería: Lucide Icons (https://lucide.dev)
- 100% open source
- Compatible con Alpine.js
- Fácil de integrar como SVG inline o componentes Blade

Alternativa: Heroicons (misma filosofía)
```

---

## Parte 7: Experiencia de usuario — principios

### Dashboard
- Acciones comunes a 1 click (crear orden, asignar mecánico)
- Búsqueda global desde cualquier pantalla (cmd+K)
- Tablas paginadas con búsqueda y filtros
- Feedback visual inmediato (toast de éxito/error)
- Modales para confirmar acciones destructivas

### Portal
- Sin registro obligatorio para agendar (solo email al final)
- Progreso visible (step indicator)
- Máximo 6 clics desde la landing hasta cita creada
- Mobile-first: todo el flujo funciona en una pantalla de 375px
- Sin imágenes pesadas, sin JS innecesario
- Confirmación visible + correo de resumen

---

## Resumen

| Aspecto | Dashboard | Portal |
|---|---|---|
| Layout | Sidebar + Navbar + Content | Centered, simple |
| Framework CSS | Tailwind v4 | Tailwind v4 |
| JS | Alpine.js + ApexCharts | Alpine.js |
| Tema | Claro / Oscuro | Solo claro |
| Mobile | Adaptable (sidebar overlay) | Mobile-first |
| Vistas | ~20 | ~12 |
| Componentes | ~12 | ~6 |
