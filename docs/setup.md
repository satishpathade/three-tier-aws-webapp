# Web server (JUMP-serevr)
## Deployment Scripts https://d1cucqwckntydw.cloudfront.net/

### 🟢 Web Tier Deployment (Nginx)

ssh web jump server 
`ssh -i "key-pair-path" ec2-user@<public-ip>`

- update yum package
     `sudo yum update -y`
- install nginx and git
    `sudo yum install -y nginx git`
- start and enable nginx
    `sudo systemctl start nginx`
    `sudo systemctl enable nginx`

- Clone project repo
    `cd /home/ec2-user`
    `git clone https://github.com/satishpathade/three-tier-aws-webapp.git`

- Copy web tier code `sudo cp -r three-tier-aws-webapp/web/* /usr/share/nginx/html`

- Restart nginx `sudo systemctl restart nginx`

- Verify `http://<jump-server-public-ip>


# App server (JUMP-serevr)
### 🟢 Web Tier Deployment (Nginx)

ssh app jump server 
`ssh -i "key-pair-path" ec2-user@<public-ip>`

- update yum package
     `sudo yum update -y`
     
- install nginx and git, php, php-mysql connector
    `sudo yum install nginx php php-fpm php-mysqlnd git -y`
- start and enable service
    `sudo systemctl start nginx`
    `sudo systemctl enable nginx`

    `sudo systemctl start php-fpm`
    `sudo systemctl enable php-fpm`

- Clone project repo
    `cd /home/ec2-user`
    `git clone https://github.com/satishpathade/three-tier-aws-webapp.git`

- Copy app tier code `sudo cp -r three-tier-aws-webapp/app/* /usr/share/nginx/html`

- Restart nginx `sudo systemctl restart nginx`
- Update Database Configuration
    `sudo nano /usr/share/nginx/html/config.php`
