# Comandos de Git para el Proyecto E-commerce JMC

## Configuración Inicial

### Inicializar Git en el proyecto
```bash
# Ubicarte en la carpeta del proyecto
cd tu-proyecto

# Inicializar Git
git init

# Agregar todos los archivos
git add .

# Hacer el primer commit
git commit -m "Commit inicial del proyecto"
```

### Conectar con GitHub
```bash
# Agregar el repositorio remoto (reemplazar TU-USUARIO)
git remote add origin https://github.com/TU-USUARIO/ecommerce-JMC.git

# Verificar que se agregó correctamente
git remote -v
```

## Manejo de Ramas

### Crear y Configurar Ramas Principales
```bash
# Renombrar la rama actual a main
git branch -M main

# Subir la rama main a GitHub
git push -u origin main

# Crear y cambiar a la rama de desarrollo
git checkout -b develop

# Subir la rama develop a GitHub
git push -u origin develop
```

### Verificar Ramas
```bash
# Ver todas las ramas
git branch -a

# Ver en qué rama estás
git branch
```

## Flujo de Trabajo Diario

### Trabajar en una Nueva Característica
```bash
# Asegurarte de estar en develop
git checkout develop

# Actualizar develop con los últimos cambios
git pull origin develop

# Crear una rama para la nueva característica
git checkout -b feature/nueva-caracteristica

# [Hacer cambios en el código]

# Agregar y commitear cambios
git add .
git commit -m "tipo: descripción de los cambios"

# Subir la característica a GitHub
git push -u origin feature/nueva-caracteristica
```

### Fusionar una Característica Completada
```bash
# Volver a develop
git checkout develop

# Traer los últimos cambios de develop
git pull origin develop

# Fusionar tu característica
git merge feature/nueva-caracteristica

# Subir los cambios a develop
git push origin develop
```

### Crear, Fusionar y Eliminar Ramas Temporales
```bash
# 1. Crear una rama temporal desde develop
git checkout develop
git pull origin develop
git checkout -b feature/nueva-caracteristica

# 2. Trabajar en la rama temporal
# [Hacer cambios en los archivos]
git add .
git commit -m "feat: implementar nueva característica"
git push -u origin feature/nueva-caracteristica

# 3. Fusionar la rama temporal con develop
git checkout develop
git pull origin develop
git merge feature/nueva-caracteristica
git push origin develop

# 4. Eliminar la rama temporal
# Eliminar la rama local
git branch -d feature/nueva-caracteristica
# Si hay problemas, forzar la eliminación
# git branch -D feature/nueva-caracteristica

# Eliminar la rama remota
git push origin --delete feature/nueva-caracteristica

# 5. Verificar que la rama se haya eliminado
git branch
git branch -r
```

### Hacer un Release a Producción
```bash
# Cambiar a main
git checkout main

# Traer los últimos cambios de main
git pull origin main

# Fusionar develop en main
git merge develop

# Subir los cambios a main
git push origin main
```

### Pasar Cambios de Develop a Main y Eliminar Rama Temporal
```bash
# 1. Verificar que todos los cambios en develop estén commiteados
git checkout develop
git status
# Si hay cambios pendientes:
git add .
git commit -m "feat: completar última característica antes de merge a main"
git push origin develop

# 2. Actualizar la rama develop
git pull origin develop

# 3. Cambiar a la rama main
git checkout main

# 4. Actualizar la rama main
git pull origin main

# 5. Fusionar develop en main
git merge develop

# 6. Subir los cambios a main
git push origin main

# 7. Etiquetar la versión (opcional pero recomendado)
git tag -a v1.0.0 -m "Versión 1.0.0"
git push origin v1.0.0

# 8. Volver a develop para continuar trabajando
git checkout develop
```

## Comandos Útiles

### Ver Estado y Cambios
```bash
# Ver el estado de tus cambios
git status

# Ver el historial de commits
git log

# Ver cambios específicos
git diff
```

### Navegación entre Ramas
```bash
# Cambiar entre ramas
git checkout nombre-rama

# Crear y cambiar a nueva rama
git checkout -b nombre-rama
```

### Sincronización con Repositorio Remoto
```bash
# Traer cambios del repositorio remoto
git pull origin nombre-rama

# Subir cambios al repositorio remoto
git push origin nombre-rama
```

## Convenciones de Commits

### Formato de Mensajes de Commit
```bash
git commit -m "tipo: descripción corta"
```

### Tipos de Commits
- `feat`: Nueva característica
- `fix`: Corrección de bug
- `docs`: Cambios en documentación
- `style`: Cambios de formato
- `refactor`: Refactorización de código
- `test`: Agregar o modificar tests
- `chore`: Cambios en el build o herramientas

### Ejemplos de Commits
```bash
git commit -m "feat: agregar autenticación con Google"
git commit -m "fix: corregir error en formulario de registro"
git commit -m "docs: actualizar README con instrucciones de instalación"
git commit -m "style: formatear código según PSR-12"
git commit -m "refactor: optimizar consultas a base de datos"
git commit -m "test: agregar tests para autenticación"
git commit -m "chore: actualizar dependencias de composer"
```

## Resolución de Problemas Comunes

### Deshacer Cambios Locales
```bash
# Deshacer cambios en un archivo
git checkout -- nombre-archivo

# Deshacer último commit (manteniendo cambios)
git reset --soft HEAD~1

# Deshacer último commit (descartando cambios)
git reset --hard HEAD~1
```

### Manejo de Conflictos
```bash
# Ver archivos con conflictos
git status

# Después de resolver conflictos
git add .
git commit -m "fix: resolver conflictos de merge"
```

### Limpiar Archivos No Seguidos
```bash
# Ver archivos no seguidos
git clean -n

# Eliminar archivos no seguidos
git clean -f
```

## Buenas Prácticas

1. Siempre hacer pull antes de empezar a trabajar
2. Mantener commits pequeños y enfocados
3. Usar mensajes de commit descriptivos
4. Resolver conflictos localmente antes de push
5. Mantener la rama develop actualizada
6. No hacer push directo a main
7. Crear ramas específicas para cada característica
8. Revisar cambios antes de commitear
9. Mantener el .gitignore actualizado
10. Hacer backup regular del repositorio 