# Proyecto Ecommerce Kiosko + Dashboard

## Descripción General

Este proyecto es un sistema de ecommerce con doble funcionamiento:

### Kiosko Web (público)
Los clientes pueden:
- Navegar productos sin registrarse
- Registrarse opcionalmente (con correo o Google)
- Seleccionar productos de interés ("carrito de intención de compra")
- Enviar su carrito a WhatsApp del negocio para coordinar la compra (sin pagos en línea)

### Dashboard Administrativo (privado)
Administradores y empleados pueden:
- Gestionar productos, inventarios, facturación, usuarios y roles

## 🎯 Objetivos

- Separar vistas de clientes y administradores/empleados completamente
- Usuarios administrativos no pueden loguearse en la vista pública (kiosko)
- Sesión de clientes dura hasta que el usuario cierre sesión manualmente
- Sesión de administrador/empleado tiene un tiempo límite de inactividad (expiración automática)

## 📦 Estructura de Productos

### Jerarquía

| Nivel | Ejemplo |
|-------|---------|
| Grupo | Tecnología, Bazar, Librería |
| Categoría | HP, Epson, Kingston (por grupo) |
| Subcategoría | Impresoras, Discos SSD, USBs (por marca) |
| Producto | Impresora HP 123, Disco Kingston 480GB |

## 🗄️ Base de Datos

### Tablas principales:
- `groups` → Grupos generales
- `categories` → Categorías (marcas)
- `subcategories` → Tipos de producto
- `products` → Productos individuales
- `product_images` → Múltiples imágenes por producto
- `users` → Usuarios (clientes, administradores, empleados)
- `roles` y `permissions` → (gestión de acceso, usando Spatie Laravel Permissions)
- `intentions` → (carritos de intención de compra enviados por clientes)

## 🧠 Roles y Permisos

| Rol | Descripción |
|-----|-------------|
| Cliente | Navega productos en kiosko, registra intención de compra |
| Empleado | Accede a Dashboard, maneja inventario y ventas |
| Administrador | Acceso total: usuarios, roles, productos, facturación |

## 🔑 Registro e Inicio de Sesión

| Característica | Público (Kiosko) | Privado (Dashboard) |
|----------------|------------------|-------------------|
| Registro normal (correo) | ✅ | ✅ |
| Registro con Google (OAuth) | ✅ | - |
| Inicio de sesión persistente | ✅ | - |
| Sin expiración automática | ✅ | - |
| URL separada | - | `/admin/login` |
| Sesión expira por inactividad | - | ✅ |
| Requiere rol específico | - | Admin o Empleado |

## 📲 Envío de intención de compra
- Los clientes seleccionan productos
- Al terminar, el carrito genera un resumen
- El resumen se redirige directamente a WhatsApp del negocio con los detalles

## 🔧 Tecnologías
- Laravel 11 (Backend principal)
- Inertia.js (Comunicación Backend ↔ Frontend)
- React 18+ (Frontend SPA)
- Vite (Compilador de assets)
- Spatie/Permission (Manejo de roles y permisos)
- TailwindCSS (Estilizado rápido y adaptable)
- Laravel Breeze (Autenticación ligera)
- Laravel Socialite (Autenticación por Google)
- WhatsApp API URL (enlace dinámico para envío de carritos)

## Primeros Módulos a Crear
1. Registro/login clientes
2. Registro/login administrativos (en ruta separada)
3. Sistema de roles y validaciones
4. Gestión de grupos, categorías, subcategorías y productos
5. Carga múltiple de imágenes
6. Inventario y stock
7. Facturación básica
8. Carrito de intención y redirección a WhatsApp

## 🚀 Plan de trabajo sugerido
1. Instalar Laravel + Breeze + Inertia + React + Tailwind
2. Crear migraciones de roles, usuarios, productos
3. Definir las rutas separadas (cliente vs admin)
4. Implementar autenticación + expiración por inactividad para admins
5. Construir kiosko de productos
6. Conectar carrito al envío por WhatsApp
7. Construir dashboard administrativo

## 📋 Notas Especiales

### UX/UI
- El kiosko debe ser rápido, responsivo y orientado a conversión (UX amigable)
- El dashboard debe ser claro y sencillo para gestión administrativa

### Seguridad reforzada
- Roles estrictos en middleware de rutas
- Tiempos de sesión diferenciados
- Validaciones de acceso

> **Nota importante**: Este proyecto NO contempla pasarelas de pago, todo cierre de venta será vía WhatsApp empresarial.

## 📊 Esquema Completo de la Base de Datos

### Tablas Principales

#### users
```sql
CREATE TABLE users (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NULL,
    google_id varchar(255) NULL,
    avatar varchar(255) NULL,
    phone varchar(20) NULL,
    address text NULL,
    remember_token varchar(100) NULL,
    email_verified_at timestamp NULL,
    last_login_at timestamp NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id)
);
```

#### roles
```sql
CREATE TABLE roles (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    guard_name varchar(255) NOT NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id)
);
```

#### permissions
```sql
CREATE TABLE permissions (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    guard_name varchar(255) NOT NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id)
);
```

#### model_has_roles
```sql
CREATE TABLE model_has_roles (
    role_id bigint unsigned NOT NULL,
    model_type varchar(255) NOT NULL,
    model_id bigint unsigned NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type)
);
```

#### model_has_permissions
```sql
CREATE TABLE model_has_permissions (
    permission_id bigint unsigned NOT NULL,
    model_type varchar(255) NOT NULL,
    model_id bigint unsigned NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type)
);
```

#### groups
```sql
CREATE TABLE groups (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE,
    description text NULL,
    image varchar(255) NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id)
);
```

#### categories
```sql
CREATE TABLE categories (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    group_id bigint unsigned NOT NULL,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE,
    description text NULL,
    image varchar(255) NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (group_id) REFERENCES groups(id)
);
```

#### subcategories
```sql
CREATE TABLE subcategories (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    category_id bigint unsigned NOT NULL,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE,
    description text NULL,
    image varchar(255) NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

#### products
```sql
CREATE TABLE products (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    subcategory_id bigint unsigned NOT NULL,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE,
    description text NULL,
    price decimal(10,2) NOT NULL,
    stock int NOT NULL DEFAULT 0,
    sku varchar(100) NULL UNIQUE,
    status enum('active','inactive') DEFAULT 'active',
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(id)
);
```

#### product_images
```sql
CREATE TABLE product_images (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    product_id bigint unsigned NOT NULL,
    image_path varchar(255) NOT NULL,
    is_primary boolean DEFAULT false,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

#### intentions
```sql
CREATE TABLE intentions (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    user_id bigint unsigned NULL,
    client_name varchar(255) NOT NULL,
    client_email varchar(255) NULL,
    client_phone varchar(20) NULL,
    total_amount decimal(10,2) NOT NULL,
    status enum('pending','processed','cancelled') DEFAULT 'pending',
    notes text NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### intention_items
```sql
CREATE TABLE intention_items (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    intention_id bigint unsigned NOT NULL,
    product_id bigint unsigned NOT NULL,
    quantity int NOT NULL,
    price decimal(10,2) NOT NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (intention_id) REFERENCES intentions(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

## 📁 Estructura de Carpetas

```
ecommerce-jmc/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── IntentionController.php
│   │   │   ├── Kiosk/
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── CartController.php
│   │   │   └── Auth/
│   │   │       ├── LoginController.php
│   │   │       └── RegisterController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   └── KioskMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Group.php
│   │   ├── Subcategory.php
│   │   └── Intention.php
│   ├── Services/
│   │   ├── WhatsAppService.php
│   │   └── ImageService.php
│   └── Providers/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── images/
│   │   ├── products/
│   │   ├── categories/
│   │   └── groups/
│   └── assets/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   │   ├── Admin/
│   │   │   └── Kiosk/
│   │   ├── Layouts/
│   │   │   ├── AdminLayout.jsx
│   │   │   └── KioskLayout.jsx
│   │   ├── Pages/
│   │   │   ├── Admin/
│   │   │   │   ├── Dashboard.jsx
│   │   │   │   ├── Products/
│   │   │   │   ├── Categories/
│   │   │   │   └── Users/
│   │   │   └── Kiosk/
│   │   │       ├── Home.jsx
│   │   │       ├── Products/
│   │   │       └── Cart.jsx
│   │   └── app.jsx
│   └── css/
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── kiosk.php
├── storage/
│   └── app/
│       └── public/
├── tests/
├── vendor/
├── .env
├── .env.example
├── .gitignore
├── composer.json
├── package.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

### Descripción de Carpetas Principales

#### `/app`
- **Controllers/**: Controladores separados para admin y kiosk
- **Models/**: Modelos de Eloquent
- **Services/**: Servicios para lógica de negocio
- **Middleware/**: Middleware personalizado para roles y autenticación

#### `/resources/js`
- **Components/**: Componentes React reutilizables
- **Layouts/**: Layouts principales para admin y kiosk
- **Pages/**: Páginas de la aplicación separadas por contexto

#### `/public`
- **images/**: Almacenamiento de imágenes públicas
- **assets/**: Archivos compilados y recursos estáticos

#### `/routes`
- **web.php**: Rutas principales
- **admin.php**: Rutas del panel administrativo
- **kiosk.php**: Rutas del kiosko público

#### `/storage/app/public`
- Almacenamiento de archivos subidos por usuarios
- Imágenes de productos y categorías
