# Company Stock Insights 
- PR: https://github.com/skthon/stock-insights/pull/1
- Demo: https://drive.google.com/file/d/1JB6jPfBOiJK5QJZnC7NMRr89aTYwA_ou/view

# Table of Contents
- [Requirements and Installation](#requirements-and-installation)
- [Tests](#tests)
- [Improvements](#improvements)

# Requirements and Installation
- Docker & Docker compose
    - PHP 8.1
    - Apache web server
    - Mysql 8.0
    - Composer
    - Node Js
- Clone the code repository
```
git clone https://github.com/skthon/stock-insights.git
```
- After cloning, Run the below commands to setup the project
```
# Creates the app, db images and launches the containers
docker-compose up -d

# navigate to the app container
docker exec -it xm-app bash

# Go to project directory and run the composer, generate app key
composer install
php artisan key:generate

# install package dependencies
npm install
npm run build

# Run the migrations for tasks table
php artisan migrate

# seed the database with company symbols
php artisan db:seed

# Copy the environment file
cp .env.example .env

# update the .env file
RAPID_API_KEY=<>
RAPID_API_HOST=yh-finance.p.rapidapi.com

# To clear the cache
php artisan config:clear
```

- Navigate to http://localhost:8000 and you can fill the form and see the stock insights for the selected company

# Tests
```
# create testing environment
docker exec xm-app -it bash

# copy the env file
cp .env .env.testing

# modify the database
DB_DATABASE=xm_test

# Clear the config and Run the test database migrations
php artisan config:clear
php artisan migrate --env=testing

# Now run the tests
php artisan test                            
   PASS  Tests\Unit\Controllers\CompanySummaryControllerTest
  ✓ submit form with empty values
  ✓ submit form with invalid symbol
  ✓ submit form with valid symbol
  ✓ submit form with invalid email
  ✓ submit form with valid email
  ✓ submit form with invalid date inputs
  ✓ submit form successful

   PASS  Tests\Feature\Controllers\CompanyFormTest
  ✓ show form page can be rendered
  ✓ show form page contains input fields

  Tests:  9 passed
  Time:   0.25s
```

# Improvements

- Move sending an email over queue and add additional data with graph
- More tests coverage
