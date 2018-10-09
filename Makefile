.PHONY: lint test proto
ROOT_DIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

proto:
	protoc --php_out=gen \
		--proto_path=$(ROOT_DIR)/vendor/github.com/nats-rpc \
		--proto_path=$(ROOT_DIR)/../xbus-api/nogogo \
		--proto_path=$(ROOT_DIR)/vendor \
		$(ROOT_DIR)/vendor/github.com/nats-rpc/nrpc/nrpc.proto \
		$(ROOT_DIR)/../xbus-api/nogogo/xbus/xbus.proto
	sed 's/\\GPBMetadata\\Google\\Protobuf\\Descriptor/\\GPBMetadata\\Google\\Protobuf\\Internal\\Descriptor/' \
		-i gen/GPBMetadata/Nrpc/Nrpc.php

test:
	./vendor/bin/phpunit tests \
		--bootstrap vendor/autoload.php \
		--debug

lint:
	find src -name *.php -exec php -l {} \;
	find tests -name *.php -exec php -l {} \;
