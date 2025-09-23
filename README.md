![Reclo](https://github.com/user-attachments/assets/1de157a7-3e65-4361-a42b-f4360fea2bf5)
Second Chances, Timeless Style

# About Reclo
Reclo is an innovative e-commerce platform for second-hand clothing that tackles the challenges of fast fashion, overconsumption, and textile pollution. Built with **Laravel**, Reclo introduces a unique clothing exchange system that encourages a **circular economy** approach. Users can buy, sell, and swap second-hand clothing items, offering a sustainable and appealing alternative to mass-produced fashion.  

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Key Features  
- **Clothing Exchange System**: Users can send and accept swap requests for clothing items.  
- **Sustainability-Oriented**: Promotes conscious consumer habits and reduces textile waste.  
- **User-Friendly Platform**: Designed with Laravel best practices, including models, controllers, routes, and database migrations.  
- **Notifications System**: Keeps users informed about accepted or rejected swap requests.  
- **Scalable Architecture**: Developed with maintainability in mind, using clean code practices such as getters and setters in models.

Want to learn more about the project? Check out the [Wiki](https://github.com/SantiGomez2519/reclo/wiki) for additional information and documentation. 

## Requirements  

Make sure your system meets the following requirements before running the project:  

- **PHP** >= 8.1  
- **Composer** >= 2.0  
- **Node.js** >= 16.x and **npm** >= 8.x  
- **MySQL** or **MariaDB** (or another supported database)  
- **Git** for version control  
- **Laravel CLI** (installed via Composer)  

Optional but recommended:  
- **XAMPP** or **Docker** for an easier local development setup.  

## Installation  

Follow these steps to set up the project locally:  

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-username/reclo.git
   cd reclo

2. **Install dependencies**
    ```bash
   composer install

3. **Set up environment file**
   Copy the .env.example file and update it with your local configuration:
    ```bash
   cp .env.example .env

4. **Generate application key**
    ```bash
   php artisan key:generate

5. **Run migrations and seed the database**
   ```bash
   php artisan migrate --seed

6. **Start the development server**
   ```bash
   php artisan serve

Now you can access the application at <a>http://localhost:8000</a>.


