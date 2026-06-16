#!/bin/bash
set -e

DB_HOST="${MYSQLHOST:-${DB_HOST:-127.0.0.1}}"
DB_NAME="${MYSQLDATABASE:-${MYSQL_DATABASE:-${DB_NAME:-railway}}}"
DB_USER="${MYSQLUSER:-${MYSQL_USER:-${DB_USER:-root}}}"
DB_PASS="${MYSQLPASSWORD:-${MYSQL_PASSWORD:-${DB_PASS:-}}}"
DB_PORT="${MYSQLPORT:-${MYSQL_PORT:-${DB_PORT:-3306}}}"
cat > /var/www/html/.env << EOF
CI_ENVIRONMENT = development

app.baseURL = '${APP_BASE_URL:-http://localhost/}'
app.forceGlobalSecureRequests = false

database.default.hostname = ${DB_HOST}
database.default.database = ${DB_NAME}
database.default.username = ${DB_USER}
database.default.password = ${DB_PASS}
database.default.DBDriver = MySQLi
database.default.port = ${DB_PORT}

session.driver = 'CodeIgniter\Session\Handlers\DatabaseHandler'
session.savePath = ci_sessions
session.expiration = 7200
session.cookieHTTPOnly = true

encryption.key = ${ENCRYPTION_KEY:-hex2bin:9916468a90078d8c223ca242fc3f8a4841e9905f47f0301c2800fd44da9d3407}

email.fromEmail = ${EMAIL_FROM:-noreply@up.sekolah.com}
email.fromName = 'Unit Produksi Sekolah'
email.SMTPHost = smtp.gmail.com
email.SMTPUser = ${EMAIL_USER:-}
email.SMTPPass = ${EMAIL_PASS:-}
email.SMTPPort = 587
email.SMTPCrypto = tls
email.protocol = smtp
EOF

echo "Running migrations..."
php /var/www/html/spark migrate --all -n || true

echo "Running seeder..."
php /var/www/html/spark db:seed InitSeeder -n || true

echo "Starting PHP-FPM..."
php-fpm &

echo "Waiting for PHP-FPM socket..."
until [ -S /var/run/php/php-fpm.sock ]; do
    sleep 0.2
done
echo "PHP-FPM ready."

echo "Starting Nginx on port 80..."
exec nginx -g 'daemon off;'
