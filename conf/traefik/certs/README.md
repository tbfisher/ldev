```bash
VIRTUAL_HOST=stage.example.com

openssl genrsa -des3 -passout pass:x -out ${VIRTUAL_HOST}.pass.key 2048
openssl rsa -passin pass:x -in ${VIRTUAL_HOST}.pass.key -out ${VIRTUAL_HOST}.key
rm ${VIRTUAL_HOST}.pass.key
openssl req -new -key ${VIRTUAL_HOST}.key -out ${VIRTUAL_HOST}.csr
#Country Name (2 letter code) [AU]:US
#State or Province Name (full name) [Some-State]:California
# no password
openssl x509 -req -days 365 -in ${VIRTUAL_HOST}.csr -signkey ${VIRTUAL_HOST}.key -out ${VIRTUAL_HOST}.crt
rm ${VIRTUAL_HOST}.csr
```
