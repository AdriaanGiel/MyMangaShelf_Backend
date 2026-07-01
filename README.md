# MyMangaShelf Backend

Backend API for the MyMangaShelf ecosystem.

MyMangaShelf Backend is a Laravel-based REST API that powers the MyMangaShelf mobile application. It provides user authentication, manga catalog management, personal libraries, reading progress tracking, custom folders, provider management, and scraping automation.

---

## Overview

The backend acts as the central data and business logic layer for the MyMangaShelf platform.

Core responsibilities include:

* User authentication and authorization
* Manga catalog management
* User manga collections
* Custom folder organization
* Reading spot management
* Chapter retrieval and updates
* Provider management
* Background job processing
* AI-assisted content generation and scraping workflows

---

## Features

### Authentication

* User registration
* User login
* Token-based authentication
* Secure logout
* Laravel Sanctum integration

### Manga Management

* Browse manga catalog
* Manga detail retrieval
* Chapter retrieval
* Media provider relationships
* Metadata management

### Personal Library

* Add manga to personal collection
* Remove manga from collection
* Change reading status
* Search user library
* Manage reading progress

### Custom Organization

* Create custom folders
* Update folders
* Delete folders
* Organize manga collections

### Reading Features

* Reading spots
* Reading history tracking
* Chapter tracking
* Reading analytics foundations

### Provider System

* Manga provider management
* Source configuration
* External catalog integrations

### Background Processing

* Queue-driven jobs
* Chapter synchronization
* Scraping file generation
* Long-running task support

### AI Integration

* Anthropic Claude integration
* AI-assisted workflows
* Content automation services

---

## Tech Stack

### Backend Framework

* Laravel 12
* PHP 8.2+

### Authentication

* Laravel Sanctum
* Laravel Fortify

### Database

* SQLite (default)
* MySQL compatible
* PostgreSQL compatible

### Queue System

* Laravel Queues
* Database queue driver

### AI Services

* Anthropic Claude API

### Testing

* Pest PHP
* Laravel Testing Suite

### Code Quality

* Laravel Pint
* GitHub Actions CI

---

## Architecture

```text
Mobile App (React Native)
          │
          ▼
     Laravel API
          │
 ┌────────┼────────┐
 │        │        │
 ▼        ▼        ▼
Auth   Manga    User Library
Layer  System   Management
 │        │        │
 └────────┼────────┘
          ▼
      Database
          │
          ▼
 Queue Jobs & Scrapers
          │
          ▼
    External Providers
```

---

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   └── Settings/
│
├── Models/
│   ├── Media.php
│   ├── User.php
│   ├── UserMediaList.php
│   ├── Folder.php
│   ├── CustomFolder.php
│   ├── Provider.php
│   ├── ReadingSpot.php
│   └── ...
│
├── Jobs/
│   ├── GenerateScrapingFiles.php
│   └── GetMediaChapters.php
│
├── Services/
│   ├── ClaudeAgent.php
│   └── ClaudeAgentService.php
│
routes/
├── api.php
└── web.php

database/
├── migrations/
├── factories/
└── seeders/
```

---

## API Endpoints

### Authentication

| Method | Endpoint        |
| ------ | --------------- |
| POST   | `/api/register` |
| POST   | `/api/login`    |
| POST   | `/api/logout`   |

### Manga

| Method | Endpoint            |
| ------ | ------------------- |
| GET    | `/api/media`        |
| GET    | `/api/media/{id}`   |
| POST   | `/api/get-chapters` |

### User Library

| Method | Endpoint                      |
| ------ | ----------------------------- |
| GET    | `/api/user-media-list`        |
| POST   | `/api/user-media-list/add`    |
| DELETE | `/api/user-media-list/remove` |
| PUT    | `/api/user-media-list/change` |
| POST   | `/api/user-media-list/search` |

### Custom Folders

| Method | Endpoint                 |
| ------ | ------------------------ |
| GET    | `/api/user-folders`      |
| POST   | `/api/user-folders`      |
| PUT    | `/api/user-folders/{id}` |
| DELETE | `/api/user-folders/{id}` |

### Providers

| Method | Endpoint        |
| ------ | --------------- |
| GET    | `/api/provider` |
| POST   | `/api/provider` |

---

## Installation

### Clone Repository

```bash
git clone https://github.com/AdriaanGiel/MyMangaShelf_Backend.git

cd MyMangaShelf_Backend
```

### Install Dependencies

```bash
composer install
```

```bash
npm install
```

### Configure Environment

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### Configure Database

Update the `.env` file with your database settings.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mymangashelf
DB_USERNAME=root
DB_PASSWORD=password
```

### Run Migrations

```bash
php artisan migrate
```

### Start Development Server

```bash
php artisan serve
```

The API will be available at:

```text
http://localhost:8000
```

---

## Queue Workers

Some features rely on queued background jobs.

Start a queue worker:

```bash
php artisan queue:listen
```

or

```bash
php artisan queue:work
```

---

## Claude Integration

The project includes Anthropic Claude services.

Configure:

```env
ANTHROPIC_API_KEY=your_api_key
```

before using AI-powered features.

---

## Running Tests

Execute the full test suite:

```bash
composer test
```

or

```bash
php artisan test
```

---

## Code Style

Run formatting:

```bash
./vendor/bin/pint
```

Validate formatting:

```bash
./vendor/bin/pint --test
```

---

## Continuous Integration

GitHub Actions automatically run:

* Code linting
* Formatting validation
* Automated tests

Workflow files are located in:

```text
.github/workflows/
```

---

## Related Projects

### Frontend

MyMangaShelf Frontend (React Native + Expo)

Provides:

* Mobile UI
* Authentication screens
* Manga browsing
* Reading spot management
* Personal library experience

---

## Future Roadmap

* Advanced recommendation engine
* Enhanced AI-assisted metadata generation
* Multi-provider synchronization
* Reading statistics dashboard
* Push notification support
* Offline synchronization support
* Community and social features

---

## License

MIT License.

---

## Author

Developed by Adriaan Giel.
