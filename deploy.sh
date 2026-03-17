#!/bin/bash

# ============================================
# Script de Despliegue de Base de Datos
# Zoo Arcadia
# ============================================
# Este script ejecuta los archivos SQL en el orden correcto
# para inicializar la base de datos con todas las tablas,
# constraints, índices, procedimientos y datos de seed.
# ============================================

# Colores para output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Variables de conexión (pueden ser pasadas como variables de entorno)
DB_HOST="${DB_HOST:-localhost}"
DB_NAME="${DB_NAME:-zoo_arcadia}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-root}"
DB_PORT="${DB_PORT:-3306}"

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Despliegue de Base de Datos Zoo Arcadia${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""

# Función para ejecutar un archivo SQL
execute_sql_file() {
    local file=$1
    local description=$2
    
    if [ ! -f "$file" ]; then
        echo -e "${RED}❌ Error: No se encontró el archivo $file${NC}"
        return 1
    fi
    
    echo -e "${YELLOW}📄 Ejecutando: $description${NC}"
    echo -e "   Archivo: $file"
    
    mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$file" 2>&1
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ $description completado${NC}"
        echo ""
        return 0
    else
        echo -e "${RED}❌ Error ejecutando $description${NC}"
        return 1
    fi
}

# Orden de ejecución de los archivos SQL
echo -e "${GREEN}Iniciando despliegue...${NC}"
echo ""

# 1. Inicializar base de datos
execute_sql_file "01_init.sql" "Inicialización de base de datos"

# 2. Crear tablas
execute_sql_file "02_tables.sql" "Creación de tablas"

# 3. Añadir constraints (claves foráneas)
execute_sql_file "03_constraints.sql" "Constraints y claves foráneas"

# 4. Añadir índices
if [ -f "04_indexes.sql" ] && [ -s "04_indexes.sql" ]; then
    execute_sql_file "04_indexes.sql" "Índices"
else
    echo -e "${YELLOW}⚠️  Saltando índices (archivo vacío o no existe)${NC}"
    echo ""
fi

# 5. Procedimientos almacenados (opcional)
if [ -f "05_procedures.sql" ] && [ -s "05_procedures.sql" ]; then
    execute_sql_file "05_procedures.sql" "Procedimientos almacenados"
else
    echo -e "${YELLOW}⚠️  Saltando procedimientos (archivo vacío o no existe)${NC}"
    echo ""
fi

# 6. Datos de seed (animales, roles, usuarios, etc.)
execute_sql_file "06_seed_data.sql" "Datos iniciales (Seed data - Animales, Roles, Usuarios, etc.)"

# 7. Limpieza (eliminar tabla de password reset si existe)
if [ -f "07_cleanup.sql" ] && [ -s "07_cleanup.sql" ]; then
    execute_sql_file "07_cleanup.sql" "Limpieza de tablas no utilizadas"
else
    echo -e "${YELLOW}⚠️  Saltando limpieza (archivo vacío o no existe)${NC}"
    echo ""
fi

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}✅ Despliegue completado exitosamente${NC}"
echo -e "${GREEN}========================================${NC}"

