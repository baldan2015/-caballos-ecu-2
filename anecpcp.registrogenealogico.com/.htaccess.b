RewriteEngine On
RewriteCond %{HTTP_HOST} registrogenealogicoecuador\.com [NC]
RewriteCond %{SERVER_PORT} 80
RewriteRule ^(.*)$ http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/$1 [R,L]