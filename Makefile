# Make sure to run the given command in a container identified by the given service.
# Enter into given container to execute the command only if /.dockerenv file does not exist
#
# $(1) the user with which run the command
# $(2) the Docker Compose service
# $(3) the command to run
#
#define run-in-container
#	@if [ ! -f /.dockerenv -a "$$(docker-compose ps -q $(2) 2>/dev/null)" ]; then \
#		docker-compose exec -T --user $(1) $(2) /bin/sh -c "$(3)"; \
#	else \
#		$(3); \
#	fi
#endef

infra-install: ## install docker containers
	docker-compose up -d
