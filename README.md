# 🛒 Sistema de autenticación de usuarios e integración con APIs E-Commerce

Este proyecto es una aplicación hecha en **Laravel** que utiliza **Breeze** para autenticación de usuarios y se conecta con **WooCommerce** para listar productos y pedidos con la posibilidad de extraerlos en un excel.

---

## 🚀 Requisitos

Antes de instalar, debe tener lo siguiente:
- PHP 8.1 o superior  
- Composer  
- MySQL  
- Node.js y npm  
- WordPress con WooCommerce instalado y funcionando, en caso de no tenerlo puede descargarlo desde https://github.com/CarlosFloresCaceres/tienda_woocommerce e instalarlo siguiendo los pasos que salen en su respectivo readme.
- API REST de WooCommerce habilitada y claves generadas (si no las tiene puede generarlas desde el wordpress descargado)

---

## 📥 Instalación

Para instalar correctamente el sistema debe realizar los siguientes pasos

1️⃣ **Clonar el proyecto**
```bash
git clone https://github.com/CarlosFloresCaceres/sistemacfc_woocommerce.git
cd sistemacfc_woocommerce
```

2️⃣ **Instalar dependencias de PHP**
```bash
composer install
```

3️⃣ **Instalar dependencias de JavaScript**
```bash
npm install
```

4️⃣ **Configurar variables de entorno**
para realizar este paso debe copiar el archivo de ejemplo y cambiar su nombre a .env:
```bash
cp .env.example .env
```
Edite el archivo `.env` e ingrese los datos de:
- Su base de datos MySQL (usada por Breeze para usuarios)
- URL y credenciales de WooCommerce  

Ejemplo:
```env
DB_DATABASE=mi_base
DB_USERNAME=mi_usuario
DB_PASSWORD=mi_password

WOOCOMMERCE_STORE_URL=https://mitienda.com
WOOCOMMERCE_CONSUMER_KEY=ck_xxxxx
WOOCOMMERCE_CONSUMER_SECRET=cs_xxxxx
```

5️⃣ **Generar clave de Laravel**
```bash
php artisan key:generate
```

6️⃣ **Migrar base de datos** *(solo si no tienes la BD creada)*
```bash
php artisan migrate
```

7️⃣ **Compilar archivos frontend**
```bash
npm run dev
```

8️⃣ **Iniciar servidor**
```bash
php artisan serve
```
Despues de ejecutar el comando podra ingresar al sistema desde la siguiente URL:
```
http://localhost:8000
```
