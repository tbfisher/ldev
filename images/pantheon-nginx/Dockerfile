FROM tbfisher/drupal-web:nginx-1.14-dev-1

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/fastcgi_params /etc/nginx/conf.d/fastcgi_params
COPY conf/drupal.conf /etc/nginx/conf.d/default.conf
