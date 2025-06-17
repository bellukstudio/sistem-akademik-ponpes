#!/bin/bash

echo "🚀 Starting siakadponpesdemo Deployment..."

# Set variables
USER_ID=$(id -u)
GROUP_ID=$(id -g)
PROJECT_DIR="/home/bellukstudio/projects/siakadponpesdemo.bellukstudio.my.id"
INFRASTRUCTURE_DIR="/home/bellukstudio/projects/containers"

# Export user IDs for docker compose
export USER_ID=$USER_ID
export GROUP_ID=$GROUP_ID

# Create network if not exists
docker network create siakadponpesdemo_network 2>/dev/null || true

# Step 1: Start Infrastructure (Nginx, PostgreSQL, pgAdmin)
echo "📦 Starting infrastructure containers..."
cd $INFRASTRUCTURE_DIR
docker compose -f docker compose.yml up -d

# Wait for PostgreSQL to be ready
echo "⏳ Waiting for PostgreSQL to be ready..."
sleep 15

# Step 2: Deploy siakadponpesdemo Application
echo "🐘 Deploying siakadponpesdemo application..."
cd $PROJECT_DIR

# Pull latest code
git pull origin main

# Build and start siakadponpesdemo containers
docker compose up -d --build

# Wait for containers to be ready
sleep 10

# Step 3: siakadponpesdemo setup
echo "🔧 Running siakadponpesdemo setup..."
docker compose exec -T app php artisan key:generate --force
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan db:seed --force
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan storage:link

# Step 4: Set proper permissions
echo "🔐 Setting permissions..."
docker compose exec -T app chown -R siakadponpesdemo.bellukstudio.my.id:siakadponpesdemo.bellukstudio.my.id /var/www/siakadponpesdemo.bellukstudio.my.id
docker compose exec -T app chmod -R 755 /var/www/siakadponpesdemo.bellukstudio.my.id.bellukstudio.my.id
docker compose exec -T app chmod -R 775 /var/www/siakadponpesdemo.bellukstudio.my.id/storage
docker compose exec -T app chmod -R 775 /var/www/siakadponpesdemo.bellukstudio.my.id/bootstrap/cache

echo "✅ siakadponpesdemo deployment completed successfully!"
echo "🌐 Application: https://siakadponpesdemo.bellukstudio.my.id"
echo "🗄️  pgAdmin: http://siakadponpesdemo.bellukstudio.my.id:8080"

# Show container status
docker compose ps
