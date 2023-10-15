## Installation

1. Clone the repo locally: `git clone https://github.com/AlexProfffi/Zoho_CRM_Form`
2. Navigate in your Laravel project folder: `cd /your-path/Zoho_CRM_Form`
3. Run docker containers: `docker-compose up -d`
4. Install project dependencies: `docker exec container_app composer install`
5. Create a new .env file: `cp .env.example .env`
6. Generate application key: `docker exec container_app php artisan key:generate`
7. Install NPM dependencies: `npm install`
8. Clear all cache: `docker exec container_app php artisan optimize:clear`
9. Start the application: `vite`
