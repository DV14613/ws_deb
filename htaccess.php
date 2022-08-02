<IfModule mod_rewrite.c>
# Activar rewrite
RewriteEngine on
ErrorDocument 404 http://127.0.0.1/Error/404/

RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f

RewriteRule ^(.*)/(.*) index.php?controller=$1&action=$2
</IfModule>
