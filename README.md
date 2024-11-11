Sistema de Gestión de Cursos en Línea
Este sistema de enseñanza en línea, desarrollado en Laravel y Livewire, permite a usuarios y administradores gestionar cursos con contenido en video de forma dinámica e interactiva. La aplicación incluye tanto una interfaz web como una API, asegurando flexibilidad y accesibilidad para administradores y usuarios. Este proyecto incorpora roles, administración de contenido y monitoreo de progreso, cumpliendo con los objetivos de pruebas unitarias, diseño de APIs, y código reutilizable.

Para mejorar la presentación y usabilidad de la interfaz, se utilizó el tema gratuito Soft UI Dashboard Laravel Livewire de Creative Tim, que aporta una estructura visual moderna y atractiva. Esto asegura que el sistema sea fácil de navegar y visualmente agradable, tanto para administradores como para usuarios.

Funcionalidades Principales
Funcionalidades Web
Administración de Cursos y Videos:

El rol de Administrador permite la creación y edición de cursos, asignación de categorías y grupos de edad a cada curso, y gestión de los videos asociados.
Los videos se pueden subir con enlaces a YouTube y están categorizados para facilitar la organización.
Cada curso incluye un grupo de edad específico (5-8, 9-13, 14-16, 16+), lo que permite filtrar el contenido según la audiencia.
Gestión de Usuarios y Progreso en Cursos:

Usuarios registrados pueden buscar cursos según el rango de edad, la categoría y el nombre del curso.
Los usuarios pueden inscribirse en cursos, ver videos, marcar el avance de visualización, y dejar comentarios o likes en cada video.
Cada usuario tiene acceso a una vista detallada de los cursos en los que está inscrito, junto con un progreso en porcentaje de los videos completados.
Revisión de Comentarios y Análisis de Actividad:

Los administradores pueden visualizar comentarios y likes hechos por los usuarios, permitiéndoles aprobar o rechazar comentarios para mantener la calidad del contenido.
También pueden monitorear estadísticas de visualización de videos y ver el progreso y los videos actuales de cada usuario inscrito.
Funcionalidades de la API
Listado de Cursos:

La API permite listar todos los cursos disponibles, proporcionando una vista general para los usuarios.
Búsqueda de Cursos:

Se puede buscar cursos utilizando filtros por categoría, rango de edad, y nombre, facilitando el acceso a contenido específico.
Registro en Cursos:

Los usuarios pueden registrarse en cursos a través de la API, lo cual guarda la inscripción en la base de datos y habilita el acceso a los contenidos del curso.
Visualización de Videos del Curso:

Los videos asociados a un curso específico pueden consultarse, lo que permite a los usuarios visualizar el contenido de manera organizada.
Interacciones en Videos:

Los usuarios pueden subir comentarios y dar likes a los videos. Cada interacción queda registrada y puede ser moderada por los administradores.
Progreso de Visualización de Videos:

A medida que el usuario marca un video como completo, el progreso en el curso se actualiza automáticamente en la base de datos, permitiendo que los administradores monitoreen el avance de cada usuario.
Requisitos de la Prueba Técnica
El proyecto implementa:

Laravel y Livewire para construir una interfaz de usuario dinámica y modular.
Sanctum para autenticación de API, lo cual asegura que solo los usuarios registrados y autenticados puedan acceder a los endpoints.
Código reutilizable y organizado a través de controladores específicos y, en caso necesario, servicios para operaciones más complejas.
Pruebas Unitarias que validan la correcta funcionalidad de los endpoints y funcionalidades principales del sistema. Todas las pruebas cumplen con los escenarios requeridos, y la cobertura asegura la calidad del código.
Configuración e Instalación
Requisitos:

Apache, PHP, MySQL o cualquier otro servidor compatible.
Composer para la gestión de dependencias.
Laravel.
Pasos de Instalación:

Clonar el repositorio en su entorno local.
Configurar el archivo .env con la conexión a su base de datos.
Ejecutar composer install para instalar dependencias.
Crear las tablas y semillar datos ejecutando php artisan migrate --seed.
Crear el enlace de almacenamiento con php artisan storage:link.
Acceso y Pruebas:

Iniciar sesión como administrador utilizando los credenciales admin@softui.com y secret.
Ejecutar php artisan test para verificar que todas las pruebas unitarias están funcionando correctamente.
Pruebas Unitarias y Cobertura
Las pruebas cubren los endpoints de la API, asegurando que:

Los cursos pueden listarse y buscarse con distintos criterios.
Los usuarios pueden registrarse en cursos y consultar los videos de cada curso.
Los comentarios y likes en los videos funcionan correctamente y el progreso de visualización se registra de forma precisa.
Las pruebas están diseñadas bajo el enfoque de TDD, asegurando que cada funcionalidad cumple con los requisitos específicos antes de desplegarse en el sistema.

Estructura de Archivos
El sistema sigue la estructura estándar de Laravel, con controladores organizados en carpetas para segmentar la lógica de administración y las interacciones en los cursos:

arduino
Copiar código
app
├── Console
├── Exceptions
├── Http
│   ├── Controllers
│   │   └── Api
│   │       ├── CourseController.php      // Gestión de cursos
│   │       ├── InteractionController.php // Interacciones en videos
│   │       └── VideoController.php       // Gestión de videos
│   ├── Kernel.php
│   ├── Livewire
│   │   ├── Auth
│   │   │   ├── ForgotPassword.php
│   │   │   ├── Login.php
│   │   │   └── SignUp.php
│   └── Middleware
├── Models
│   ├── Course.php
│   ├── Video.php
│   └── User.php
└── Tests
    └── Feature
        ├── CourseControllerTest.php
        ├── InteractionControllerTest.php
        └── VideoControllerTest.php
