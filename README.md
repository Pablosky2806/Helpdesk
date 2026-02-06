# 🛠️ HelpDesk — Trabajo de Fin de Grado

Aplicación web de **gestión de tickets de soporte técnico**, desarrollada como **Trabajo de Fin de Grado (TFG)** utilizando el framework **Laravel**.

El objetivo del proyecto es simular el funcionamiento de un sistema HelpDesk real, permitiendo a los usuarios crear incidencias y realizar su seguimiento de forma organizada, segura y estructurada.

---

## 📌 Descripción general del proyecto

La aplicación permite:

- Registro e inicio de sesión de usuarios
- Acceso a un panel principal (dashboard)
- Creación de tickets de soporte
- Visualización y edición de tickets propios
- Gestión del estado y prioridad de los tickets
- Protección de rutas mediante autenticación
- Control del historial de cambios de estado

El desarrollo sigue una metodología progresiva, priorizando inicialmente el **backend y la lógica de negocio**, dejando el diseño visual en segundo plano.

---

## 🧱 Tecnologías utilizadas

- **Laravel** (framework backend)
- **PHP 8.1+**
- **MySQL**
- **Blade** (motor de plantillas)
- **Bootstrap** (diseño y maquetación)
- **Vite**
- **Composer**
- **Node.js / npm**
- **Git**

---

## ⚙️ Requisitos del sistema

Antes de ejecutar el proyecto, es necesario tener instalado en el sistema:

- PHP **8.1 o superior**
- Composer
- Node.js y npm
- MySQL
- Git
- Servidor local (XAMPP, Laragon, WAMP o similar)

---

## 📥 Clonar el repositorio

Desde la terminal:

```bash
git clone https://github.com/Pablosky2806/Helpdesk.git
cd Helpdesk

📦 Instalación de dependencias
🔹 Dependencias backend (Laravel)

Instalar las dependencias del backend usando Composer:

composer install

🔹 Dependencias frontend

Instalar dependencias frontend y compilar los assets:

npm install
npm run build

🔧 Configuración del entorno
1️⃣ Crear el archivo de entorno

Copiar el archivo de ejemplo .env.example:

cp .env.example .env

2️⃣ Generar la clave de la aplicación
php artisan key:generate

3️⃣ Configuración de la base de datos

Editar el archivo .env y configurar los datos de conexión a MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=helpdesk
DB_USERNAME=usuario_mysql
DB_PASSWORD=contraseña_mysql


⚠️ Importante:
La base de datos debe existir previamente en MySQL antes de ejecutar las migraciones.

🗄️ Migraciones de la base de datos

Crear todas las tablas necesarias en la base de datos ejecutando:

php artisan migrate

▶️ Ejecución del proyecto

Iniciar el servidor de desarrollo de Laravel:

php artisan serve


La aplicación estará disponible en el navegador en la siguiente dirección:

http://127.0.0.1:8000

🔐 Autenticación y uso básico

Acceder a la página principal de la aplicación

Registrarse como usuario

Iniciar sesión

Acceder al dashboard

Gestionar los tickets desde el apartado correspondiente

Las rutas del sistema están protegidas, por lo que solo los usuarios autenticados pueden acceder a la gestión de tickets.

🗃️ Modelo de datos (resumen)

El sistema se basa principalmente en las siguientes entidades:

Usuario

Ticket

Técnico

Historial de estados

Las relaciones entre estas entidades siguen un modelo entidad–relación, diseñado para reflejar un sistema HelpDesk real y documentado como parte del TFG.

📁 Estructura del proyecto (resumen)

app/ → Lógica de negocio y controladores

database/ → Migraciones y seeders

resources/views/ → Vistas Blade

routes/ → Definición de rutas

public/ → Archivos públicos

config/ → Configuración del sistema

📈 Estado actual del proyecto

✔ Sistema de autenticación funcional
✔ Creación, listado y edición de tickets
✔ Protección de rutas
✔ Gestión básica de estados y prioridades
✔ Backend estructurado y escalable

🔜 Próximas mejoras

Cierre definitivo de tickets

Validaciones avanzadas

Gestión completa de técnicos

Historial detallado de cambios de estado

Roles de usuario (admin / técnico / usuario)

Integración con servicios externos

Mejora de la interfaz visual