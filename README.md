# Laravel Project

## Prerequisites

Make sure you have the following installed on your machine:
- PHP (>= 8.2)
- Composer
- Node.js (>= 14.x)
- npm (>= 6.x)

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Lowriider/test-web-id/
   
   cd your-repo


### Install PHP Dependencies

2. **Use Composer to install PHP dependencies:**

    ```composer install```

3. **Use npm to install JavaScript dependencies:**

    ```npm install```
   
5. Set Up Environment File

    ```cp .env.example .env```

    Copy the example environment file to create your own .env file:**
    
    Update the .env file with your database and other environment configurations.

## Generate Application Key

6. **Generate a new application key:**

    ```php artisan key:generate```
