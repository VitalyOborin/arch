CURRENT-DIR := $(dir $(lastword $(MAKEFILE_LIST)))
DOCKER_COMPOSE := docker-compose
DOCKER := docker
RED := "\033[0;31m"
GREEN := "\033[0;32m"
YELLOW := "\033[0;33m"
CCEND := "\033[0m"

up:
	@echo $(GREEN) "\n=====> Docker containers are building and starting <=====\n" $(CCEND)
	$(DOCKER_COMPOSE) up --build -d
	$(DOCKER) exec app composer install
	$(DOCKER) exec app php bin/console about

down:
	@echo $(RED) "\n=====> Docker containers are stopping <=====\n" $(CCEND)
	$(DOCKER_COMPOSE) down --remove-orphans