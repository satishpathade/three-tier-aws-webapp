#!/bin/bash

# VARIABLES (CHANGE AS NEEDED)

ROLE=$1   # web or app
REPO_URL="https://github.com/your-username/3tier-aws-job-portal.git"
APP_DIR="/usr/share/nginx/html"

# -----------------------------
# SYSTEM UPDATE
# -----------------------------
echo "Updating system..."
sudo yum update -y

# -----------------------------
# INSTALL NGINX
# -----------------------------
echo "Installing Nginx..."
sudo yum install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# -----------------------------
# INSTALL PHP (ONLY FOR APP TIER)
# -----------------------------
if [ "$ROLE" == "app" ]; then
    echo "Installing PHP..."
    sudo amazon-linux-extras enable php8.0
    sudo yum clean metadata
    sudo yum install -y php php-fpm php-mysqlnd

    sudo systemctl start php-fpm
    sudo systemctl enable php-fpm
fi

# -----------------------------
# DEPLOY APPLICATION
# -----------------------------
echo "Cloning repository..."
cd /home/ec2-user
rm -rf 3tier-aws-job-portal
git clone $REPO_URL

# -----------------------------
# DEPLOY BASED ON ROLE
# -----------------------------
echo "Deploying files..."

if [ "$ROLE" == "web" ]; then
    sudo cp -r 3tier-aws-job-portal/web/* $APP_DIR/
elif [ "$ROLE" == "app" ]; then
    sudo cp -r 3tier-aws-job-portal/app/* $APP_DIR/
else
    echo "Invalid role! Use: web or app"
    exit 1
fi

# -----------------------------
# PERMISSIONS
# -----------------------------
sudo chown -R nginx:nginx $APP_DIR
sudo chmod -R 755 $APP_DIR

# -----------------------------
# RESTART SERVICES
# -----------------------------
echo "Restarting services..."
sudo systemctl restart nginx

if [ "$ROLE" == "app" ]; then
    sudo systemctl restart php-fpm
fi

echo "Deployment completed successfully!"