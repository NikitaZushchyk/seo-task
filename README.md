# SEO Rank Checker (DataForSEO API)

This is a single-page Laravel application built as a test task. It checks the organic search engine ranking of a specific domain based on a given keyword, location, and language using the **DataForSEO API v3**.

## 🚀 Features Implemented
* **Single-Page Application (SPA) UX:** The front-end uses Vanilla JavaScript (Fetch API) to communicate with the backend asynchronously, ensuring the page does not reload during searches.
* **Live Regular API Integration:** Utilizes the synchronous `/v3/serp/google/organic/live/regular` endpoint for immediate results.
* **Form Request Validation:** Ensures all incoming data from the frontend is strictly validated before hitting the API.
* **Tailwind CSS:** Responsive and clean user interface.

## 📋 Prerequisites
To run this project locally without Docker, you need to have the following installed on your system (Windows/Linux/macOS):
* PHP 8.2 or higher (with `xml` and `dom` extensions enabled)
* Composer

## 🛠️ Installation & Setup Guide

**1. Clone the repository and navigate into the directory:**
```bash
git clone https://github.com/NikitaZushchyk/seo-task.git
```
```bash
cd seo-task
```
**2. Install PHP dependencies:**
```bash
composer install
```
**3. Set up environment variables: Copy the example environment file to create your own .env file:**
```bash
cp .env.example .env
```
**4. Generate the application key:**
```bash
php artisan key:generate
```
**5. Configure DataForSEO Credentials: Open the .env file in your code editor and add your API credentials at the very bottom:**
```bash
DATAFORSEO_LOGIN=your_login@email.com
DATAFORSEO_PASSWORD=your_api_password
```
**6. Start the local development server:**
```bash
php artisan serve
```
