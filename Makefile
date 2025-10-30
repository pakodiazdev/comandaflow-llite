# ComandaFlow Lite - Docker Management
.PHONY: help dev prod build up down logs shell clean

# Default help command
help: ## Show this help message
	@echo "ComandaFlow Lite - Docker Commands"
	@echo "=================================="
	@awk 'BEGIN {FS = ":.*##"} /^[a-zA-Z_-]+:.*##/ { printf "  %-15s %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

# Development commands
dev: ## Start development environment
	docker-compose up -d --build
	@echo "🚀 Development environment started!"
	@echo "📱 Application: http://localhost:8001"
	@echo "🗄️  Database: localhost:5433"

dev-logs: ## View development logs
	docker-compose logs -f

dev-shell: ## Access development container shell
	docker-compose exec app bash

dev-down: ## Stop development environment
	docker-compose down

# Production commands
prod: ## Start production environment
	docker-compose -f docker-compose.prod.yml up -d --build
	@echo "🚀 Production environment started!"
	@echo "📱 Application: http://localhost"

prod-logs: ## View production logs
	docker-compose -f docker-compose.prod.yml logs -f

prod-shell: ## Access production container shell
	docker-compose -f docker-compose.prod.yml exec app bash

prod-down: ## Stop production environment
	docker-compose -f docker-compose.prod.yml down

# Build commands
build-dev: ## Build development image
	docker-compose build --no-cache app

build-prod: ## Build production image
	docker-compose -f docker-compose.prod.yml build --no-cache app

# Database commands
db-migrate: ## Run database migrations (development)
	docker-compose exec app php artisan migrate

db-seed: ## Seed database (development)
	docker-compose exec app php artisan db:seed

db-reset: ## Reset database (development)
	docker-compose exec app php artisan migrate:fresh --seed

# Laravel commands
artisan: ## Run artisan command (usage: make artisan cmd="command")
	docker-compose exec app php artisan $(cmd)

composer: ## Run composer command (usage: make composer cmd="command")
	docker-compose exec app composer $(cmd)

# Cleanup commands
clean: ## Clean up containers, images and volumes
	docker-compose down -v
	docker-compose -f docker-compose.prod.yml down -v
	docker system prune -f

clean-all: ## Clean everything including images
	docker-compose down -v --rmi all
	docker-compose -f docker-compose.prod.yml down -v --rmi all
	docker system prune -af

# Testing commands
test: ## Run tests
	docker-compose exec app php artisan test

# Health check
health: ## Check application health
	@echo "Checking development environment..."
	@curl -f http://localhost:8001/health > /dev/null 2>&1 && echo "✅ Development: OK" || echo "❌ Development: Failed"
	@echo "Checking production environment..."
	@curl -f http://localhost/health > /dev/null 2>&1 && echo "✅ Production: OK" || echo "❌ Production: Not running"

# Monitor
monitor: ## Monitor resource usage
	docker stats

# Status
status: ## Show container status
	@echo "Development Environment:"
	@docker-compose ps
	@echo ""
	@echo "Production Environment:"
	@docker-compose -f docker-compose.prod.yml ps