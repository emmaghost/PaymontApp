Sistema de Gestión de Cursos en Línea

![image](https://github.com/user-attachments/assets/a4e5a857-7c0d-4db7-9982-36ddd26012aa)



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

Este proyecto es un sistema de enseñanza en línea diseñado para permitir que usuarios (estudiantes) accedan a cursos categorizados por edades y temas, mientras que los administradores gestionan el contenido y visualizan estadísticas del avance y la actividad de los usuarios. Incluye una interfaz web y una API en el mismo proyecto para interactuar tanto con usuarios finales como con aplicaciones externas.

Funcionalidades Principales
Roles y Permisos:

El sistema emplea el paquete Spatie Laravel-Permission para gestionar roles y permisos, asegurando control de acceso a las diferentes funcionalidades.
Se utilizan dos roles:
Administrador: gestiona la creación de cursos, videos, categorías y grupos de edades; además, administra comentarios, estadísticas de visualización y likes.
Usuario: puede registrarse, acceder a cursos según categoría y edad, marcar videos como completados, comentar, y dar likes.
En el registro de nuevos usuarios, automáticamente se les asigna el rol de "Usuario".
Autenticación con Tokens:

Se utiliza Laravel Sanctum para la autenticación de API a través de tokens. Esto permite el acceso seguro a los endpoints de la API, donde los usuarios deben autenticarse antes de realizar acciones como registrarse en cursos o comentar en videos.
Administración de Cursos y Videos:

Los cursos son administrados por el rol de administrador y pueden ser categorizados por temas y grupos de edad.
Cada curso contiene múltiples videos, que pueden estar en YouTube. Los videos incluyen categorías, duraciones y otros metadatos.
Registro de Progreso y Avance en los Cursos:

Cada usuario puede registrarse en un curso y su progreso se mide automáticamente según los videos completados.
La funcionalidad para marcar videos como completados utiliza una tabla pivote (video_user) entre videos y usuarios, permitiendo el seguimiento de los videos vistos por cada usuario.
El progreso del curso se calcula dividiendo la cantidad de videos completados entre el total de videos del curso, multiplicando el resultado por 100 para obtener el porcentaje.
Interacción del Usuario (Comentarios y Likes):

Los usuarios pueden comentar en los videos, y estos comentarios pasan a una cola de moderación donde el administrador puede aprobarlos o rechazarlos.
Los usuarios pueden dar "likes" a los videos, y el sistema permite dar o quitar likes según el estado actual.
Estadísticas y Visualización:

El administrador puede ver la lista de usuarios registrados en cada curso, con detalles de su progreso y el último video visto.
Los administradores también pueden revisar estadísticas como el total de vistas de videos, comentarios, y likes.


Claro, aquí tienes una documentación ampliada para tu proyecto que cubre la funcionalidad de las APIs, la autenticación y roles, así como detalles específicos sobre el sistema de registro, progreso de videos y más.

Documentación del Proyecto de Sitio de Enseñanza en Línea
Descripción General
Este proyecto es un sistema de enseñanza en línea diseñado para permitir que usuarios (estudiantes) accedan a cursos categorizados por edades y temas, mientras que los administradores gestionan el contenido y visualizan estadísticas del avance y la actividad de los usuarios. Incluye una interfaz web y una API en el mismo proyecto para interactuar tanto con usuarios finales como con aplicaciones externas.

Funcionalidades Principales
Roles y Permisos:

El sistema emplea el paquete Spatie Laravel-Permission para gestionar roles y permisos, asegurando control de acceso a las diferentes funcionalidades.
Se utilizan dos roles:
Administrador: gestiona la creación de cursos, videos, categorías y grupos de edades; además, administra comentarios, estadísticas de visualización y likes.
Usuario: puede registrarse, acceder a cursos según categoría y edad, marcar videos como completados, comentar, y dar likes.
En el registro de nuevos usuarios, automáticamente se les asigna el rol de "Usuario".
Autenticación con Tokens:

Se utiliza Laravel Sanctum para la autenticación de API a través de tokens. Esto permite el acceso seguro a los endpoints de la API, donde los usuarios deben autenticarse antes de realizar acciones como registrarse en cursos o comentar en videos.
Administración de Cursos y Videos:

Los cursos son administrados por el rol de administrador y pueden ser categorizados por temas y grupos de edad.
Cada curso contiene múltiples videos, que pueden estar en YouTube. Los videos incluyen categorías, duraciones y otros metadatos.
Registro de Progreso y Avance en los Cursos:

Cada usuario puede registrarse en un curso y su progreso se mide automáticamente según los videos completados.
La funcionalidad para marcar videos como completados utiliza una tabla pivote (video_user) entre videos y usuarios, permitiendo el seguimiento de los videos vistos por cada usuario.
El progreso del curso se calcula dividiendo la cantidad de videos completados entre el total de videos del curso, multiplicando el resultado por 100 para obtener el porcentaje.
Interacción del Usuario (Comentarios y Likes):

Los usuarios pueden comentar en los videos, y estos comentarios pasan a una cola de moderación donde el administrador puede aprobarlos o rechazarlos.
Los usuarios pueden dar "likes" a los videos, y el sistema permite dar o quitar likes según el estado actual.
Estadísticas y Visualización:

El administrador puede ver la lista de usuarios registrados en cada curso, con detalles de su progreso y el último video visto.
Los administradores también pueden revisar estadísticas como el total de vistas de videos, comentarios, y likes.
Funcionalidades del API
El proyecto incluye una API que permite realizar varias operaciones relacionadas con el sistema de enseñanza en línea. A continuación se presentan los endpoints principales:

Endpoints Principales
Listar Cursos:

Endpoint: GET /api/courses
Función: Devuelve una lista de todos los cursos disponibles con información detallada.
Acceso: Requiere autenticación.
Buscar Cursos por Categoría, Edad o Nombre:

Endpoint: GET /api/courses/search
Parámetros: category_id, age_group, name (parámetros opcionales para filtrar resultados).
Función: Permite buscar cursos en función de una categoría específica, un grupo de edad, o por el nombre del curso.
Acceso: Requiere autenticación.
Registrar un Usuario en un Curso:

Endpoint: POST /api/courses/{course_id}/enroll
Función: Registra al usuario autenticado en un curso específico, si aún no lo está, y establece su progreso inicial en 0%.
Acceso: Requiere autenticación.
Obtener Videos de un Curso:

Endpoint: GET /api/courses/{course_id}/videos
Función: Devuelve todos los videos de un curso específico, permitiendo al usuario visualizar el contenido.
Acceso: Requiere autenticación.
Subir Comentarios en un Video:

Endpoint: POST /api/videos/{video_id}/comment
Parámetro: comment (contenido del comentario).
Función: Permite al usuario autenticado comentar en un video específico. El comentario queda pendiente hasta ser aprobado por un administrador.
Acceso: Requiere autenticación.
Dar Likes a un Video:

Endpoint: POST /api/videos/{video_id}/like
Función: Permite dar o quitar un "like" a un video. Si el usuario ya ha dado un "like", este se retira; si no, se añade.
Acceso: Requiere autenticación.
Marcar Video como Completado:

Endpoint: POST /api/videos/{video_id}/complete
Función: Marca un video como completado en la tabla pivote video_user, actualiza el progreso del usuario en el curso, y calcula el porcentaje completado.
Acceso: Requiere autenticación.
Implementación de Progreso de Curso
Para calcular el avance en un curso:

Al ver un video: Cuando un usuario marca un video como completado, se registra en la tabla pivote video_user con el campo is_completed.
Cálculo de progreso: Se cuenta el número de videos completados y se divide entre el total de videos en el curso. Este resultado se multiplica por 100 para obtener el porcentaje de avance.
Actualización en course_user: El porcentaje calculado se guarda en la tabla course_user en el campo progress.
Autenticación y Roles en el Sistema
Registro y Asignación de Roles:

En el proceso de registro, el sistema asigna automáticamente el rol "Usuario" a cada nuevo usuario registrado.
Se utiliza Spatie Laravel-Permission para asignar y verificar los roles.
Protección de Endpoints con Sanctum:

Todos los endpoints de la API requieren autenticación de usuario mediante tokens de Sanctum, asegurando así un acceso seguro.
Al iniciar sesión, el usuario obtiene un token que se debe enviar en cada solicitud API para realizar acciones autorizadas.
Conclusión y Resumen de Pruebas Unitarias
El sistema ha sido implementado y probado a través de pruebas unitarias que verifican la funcionalidad de los endpoints, la autenticación con tokens, la asignación de roles, y la lógica de avance en los cursos. Todas las pruebas relacionadas con las funcionalidades mencionadas han sido completadas satisfactoriamente y cubren tanto las acciones en el sistema web como las interacciones a través de la API.

1. Autenticación
Generar un Token de Acceso
Ruta: /api/login
Método: POST
Cuerpo de la Solicitud (JSON):
json
Copiar código
{
  "email": "user@example.com",
  "password": "yourpassword"
}
Respuesta Exitosa:
json
Copiar código
{
  "message": "Login successful",
  "token": "your_generated_token",
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com",
    ...
  }
}
Nota: Guarda el token de la respuesta para usarlo en todas las solicitudes que requieran autenticación. En Postman, añade este token en la pestaña de "Authorization" seleccionando "Bearer Token" y pegando el valor del token.
2. Listar Cursos
Listar todos los Cursos
Ruta: /api/courses
Método: GET
Cabecera: Autenticación Bearer Token.
Respuesta Exitosa:
json
Copiar código
{
  "data": [
    {
      "id": 1,
      "title": "Curso de Ejemplo",
      "category": "Programación",
      "age_group": "9-13",
      ...
    },
    ...
  ]
}
3. Buscar Cursos por Categoría, Edad o Nombre
Búsqueda de Cursos
Ruta: /api/courses/search
Método: GET
Cabecera: Autenticación Bearer Token.
Parámetros de Consulta (opcional, usa uno o varios):
category_id=1
age_group=9-13
name=Curso
Respuesta Exitosa:
json
Copiar código
{
  "data": [
    {
      "id": 2,
      "title": "Curso de Programación",
      "category": "Programación",
      "age_group": "9-13",
      ...
    },
    ...
  ]
}
4. Registrar un Usuario en un Curso
Inscribirse en un Curso
Ruta: /api/courses/{course_id}/enroll
Método: POST
Cabecera: Autenticación Bearer Token.
Cuerpo de la Solicitud: No es necesario.
Respuesta Exitosa:
json
Copiar código
{
  "message": "Enrolled successfully",
  "progress": 0
}
5. Obtener Videos de un Curso
Listar Videos de un Curso
Ruta: /api/courses/{course_id}/videos
Método: GET
Cabecera: Autenticación Bearer Token.
Respuesta Exitosa:
json
Copiar código
{
  "data": [
    {
      "id": 1,
      "title": "Introducción",
      "url": "https://www.youtube.com/watch?v=example",
      "duration": "10:35",
      ...
    },
    ...
  ]
}
6. Subir Comentarios en un Video
Comentar en un Video
Ruta: /api/videos/{video_id}/comment
Método: POST
Cabecera: Autenticación Bearer Token.
Cuerpo de la Solicitud (JSON):
json
Copiar código
{
  "comment": "Muy buen video, gracias por compartir!"
}
Respuesta Exitosa:
json
Copiar código
{
  "message": "Comment submitted for approval"
}
7. Dar Likes a un Video
Like o Unlike a un Video
Ruta: /api/videos/{video_id}/like
Método: POST
Cabecera: Autenticación Bearer Token.
Cuerpo de la Solicitud: No es necesario.
Respuesta Exitosa:
json
Copiar código
{
  "message": "Liked successfully"
}
Nota: Si el usuario ya dio like al video, este endpoint eliminará el like en lugar de agregar otro.
8. Marcar Video como Completado
Marcar un Video como Completado
Ruta: /api/videos/{video_id}/complete
Método: POST
Cabecera: Autenticación Bearer Token.
Cuerpo de la Solicitud: No es necesario.
Respuesta Exitosa:
json
Copiar código
{
  "message": "Video marked as completed",
  "progress": 50  // Indica el porcentaje de avance en el curso
}


Requisitos:

Apache, PHP, MySQL o cualquier otro servidor compatible.
Composer para la gestión de dependencias.
Laravel.


Algunas Pantallas de la aplicacion web:


![image](https://github.com/user-attachments/assets/9e3c5b87-5156-4529-9fd6-4d06b0e6023f)


![image](https://github.com/user-attachments/assets/6121311c-1881-432b-824d-bc66fd06bb93)

![image](https://github.com/user-attachments/assets/13491eaf-d72e-49a7-ae4e-73242ad4479e)

![image](https://github.com/user-attachments/assets/8573fdd6-e135-424a-8f0d-9c3f5cfe7c22)


Pasos de Instalación:



Clonar el repositorio en su entorno local.
Configurar el archivo .env con la conexión a su base de datos.
Ejecutar composer install para instalar dependencias.
Crear las tablas y semillar datos ejecutando php artisan migrate --seed.
Crear los roles y permisos :  php artisan db:seed --class=RoleAndPermissionSeeder
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

En las pruebas TDD todas salieron exitosas en la parte de las API :

![image](https://github.com/user-attachments/assets/9d09f5bd-9683-410f-a025-96a4a10f01bb)


