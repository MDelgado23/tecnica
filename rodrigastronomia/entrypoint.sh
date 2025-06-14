#!/bin/sh

echo "Esperando a MySQL..."
until mysql --host="$DB_HOST" --user="$DB_USER" --password="$DB_PASS" -e "SELECT 1;" >/dev/null 2>&1; do
  >&2 echo "MySQL no está disponible - esperando..."
  sleep 2
done

echo "MySQL está activo. Ejecutando migraciones e inicialización..."

php spark migrate
php spark app:inicializar

exec apache2-foreground
