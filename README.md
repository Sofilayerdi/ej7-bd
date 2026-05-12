# Ej 7 — Laboratorio ORM

Dominio modelado: tienda en línea con usuarios, productos, categorías, órdenes, pagos, reseñas y cupones.

---

## Requisitos previos

- PHP >= 8.3
- Composer
- Docker y Docker Compose
- Node.js >= 18 y npm

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Sofilayerdi/ej7-bd.git
cd ej7-bd
```

### 2. Instalar dependencias

```bash
composer install
npm install
npm run build
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Levantar la base de datos con Docker

```bash
docker compose up -d
```

### 5. Configurar `.env`

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5435
DB_DATABASE=ecommerce
DB_USERNAME=postgres
DB_PASSWORD=secret
```

---

## Migraciones

Crear todas las tablas:

```bash
php artisan migrate
```

Revertir todas las migraciones:

```bash
php artisan migrate:rollback
```

Reiniciar desde cero:

```bash
php artisan migrate:fresh
```

---

## Seeders

```bash
php artisan db:seed
```

O combinado con migraciones:

```bash
php artisan migrate:fresh --seed
```


## Consultas Eloquent

Las consultas están en `app/Queries/EcommerceQueries.php`.

Para ejecutarlas:

```bash
php artisan tinker --execute="require base_path('app/Queries/EcommerceQueries.php');"
```

### Resumen de consultas

- **Productos activos**
  - Productos activos
  - Precio menor a Q500
  - Incluye categoría
  - Ordenados por precio ascendente

- **Órdenes grandes entregadas**
  - Estado `delivered`
  - Total mayor a Q1000
  - Incluye usuario
  - Ordenadas por total descendente

- **Órdenes en procesamiento**
  - Últimas 10 órdenes con estado `processing`
  - Incluye usuario, items y pago
  - Muestra cantidad de items y estado del pago

- **Usuarios destacados**
  - Usuarios con reseñas aprobadas
  - Rating >= 4
  - Incluye solo reseñas filtradas
  - Límite de 10 usuarios

- **Reseñas perfectas**
  - Reseñas aprobadas
  - Rating de 5 estrellas
  - Incluye producto y usuario
  - Últimas 10 reseñas