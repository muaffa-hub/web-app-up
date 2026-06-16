#!/bin/bash
set -e

cat > /var/www/html/.env << EOF
CI_ENVIRONMENT = production

app.baseURL = '${APP_BASE_URL:-https://your-app.railway.app/}'
app.forceGlobalSecureRequests = false

database.default.hostname = ${DB_HOST:-localhost}
database.default.database = ${DB_NAME:-ecommerce_up}
database.default.username = ${DB_USER:-root}
database.default.password = ${DB_PASS:-}
database.default.DBDriver = MySQLi
database.default.port = ${DB_PORT:-3306}

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

exec "$@"
