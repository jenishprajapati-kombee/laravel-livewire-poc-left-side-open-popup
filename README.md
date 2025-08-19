# Project Setup
Follow these steps to set up and run the project:

## 1. Install Dependencies

Update the project dependencies:
composer update

Install Node dependencies:
npm install

2. Compile Assets
npm run dev

3. Install and Publish Telescope & Pulse

Install Laravel Telescope:
php artisan telescope:install

Publish the Laravel Pulse configuration:
php artisan vendor:publish --provider="Laravel\Pulse\PulseServiceProvider"

4. Storage and Database Setup
Create a symbolic link for storage:
php artisan storage:link

Run migrations:
php artisan migrate

Seed the database:
php artisan db:seed

5. Start the Queue Worker
php artisan queue:work

6. Environment Variables
Update the .env file with the following keys:
GOOGLE_RECAPTCHA_KEY=
GOOGLE_RECAPTCHA_SECRET=
TINIFY_API_KEY
