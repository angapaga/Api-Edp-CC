1. Crear un archivo .htaccess en /var/www/html

<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "POST, GET, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type"
</IfModule>


2. Verificar Configuración de Apache:
Asegúrate de que la configuración de Apache permita la lectura de archivos .htaccess. Dentro del archivo de configuración principal de Apache (/etc/httpd/conf/httpd.conf), deberías tener algo como esto:


<Directory "/var/www/html">
    AllowOverride All
    # ...
</Directory>

3. sudo service httpd restart


