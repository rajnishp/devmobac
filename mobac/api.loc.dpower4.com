<VirtualHost *:80>
    DocumentRoot "/var/www/html/demoweb/smartshare/backend/src"
    ServerAdmin webmaster@localhost
    ServerName api.loc.dpower4.com
    ServerAlias www.api.loc.dpower4.com
    <IfModule mod_php5.c>
        php_value include_path ".:/usr/share/php:/usr/share/pear/php:/usr/share/pear:/usr/share/php/collap-upload:/usr/share/php/collap-conf"
    </IfModule>
    <Directory "/var/www/html/demoweb/smartshare/backend/src">
        Options -Indexes
        Options FollowSymLinks
        AllowOverride All
    </Directory>
    
#LogFormat "[%P] %h %l %u %t %D \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogFormat "[%P] %{forensic-id}<n %h %l %u %t %D \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogLevel warn
ErrorLog "/var/log/apache2/errors/api_dpower4_error.log"
CustomLog "/var/log/apache2/access/api_dpower4_access.log" combined env=!dontlog
ServerSignature On
</VirtualHost>
