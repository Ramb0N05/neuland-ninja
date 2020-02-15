#!/bin/bash
if [[ $1 = *[!\ ]* ]]; then
	mkdir ./$1
	cd ./$1

	if [[ $2 = *[!\ ]* ]]; then
		d=$2
	else
		d=365
	fi

	openssl genrsa -out $1.key 2048
	openssl req -new -key $1.key -out $1.csr
	openssl x509 -req -in $1.csr -CA ../../../NeulandNinjaCA/ca-root.pem -CAkey ../../../NeulandNinjaCA/ca-key.pem -CAcreateserial -out $1.pem -days $d -sha256
	openssl x509 -req -in $1.csr -CA ../../../NeulandNinjaCA/ca-root.pem -CAkey ../../../NeulandNinjaCA/ca-key.pem -CAcreateserial -out $1.pem -days $d -sha256
	openssl pkcs12 -export -inkey $1.key -name "$1" -in $1.pem -certfile ../../../NeulandNinjaCA/ca-root.pem -out $1.p12

	rm $1.csr

	cp $1.p12 /var/www/neuland-ninja/certs/clients/
	chmod 0777 /var/www/neuland-ninja/certs/clients/$1.p12
else
	echo Please type in parameter 1!
fi
