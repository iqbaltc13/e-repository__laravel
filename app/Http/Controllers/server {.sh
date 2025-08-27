server {
    server_name e-repository.iainkediri.ac.id www.e-repository.iainkediri.ac.id;
    root /var/www/html/e-repository__laravel/public;
    index index.html index.php;
    location / {
         try_files $uri $uri/ /index.php$is_args$args;
    }
  location ~ \.php$ {
        include fastcgi_params;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
location ~ /\.ht {
        deny all;
    }
  location ~ /.well-known/acme-challenge/ {
        allow all;
    }

}
server {
    listen 80;
    listen [::]:80;
    server_name e-repository.uinkediri.site www.e-repository.uinkediri.site;
    return 404; # managed by Certbot
}
