# Hotel & PMS / Laravel

[Leia em português](./README.pt-BR.md)

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](./LICENSE) ![Free](https://img.shields.io/badge/price-free-brightgreen)

A hotel app: booking site (rooms, availability, reserve) and a PMS with dashboard (occupancy, ADR, RevPAR), reservations, a room map by status, check-in and check-out, guests, and rates and availability.

Everything runs on mock data, so no backend, external API or service is needed.

## Highlights

- Internationalisation in Portuguese (pt-BR), English and Spanish
- Installable PWA
- Light and dark themes
- Responsive layout from phone to desktop
- Mock data in Portuguese (Brazil), easy to replace with a real API

## Tech stack

- Laravel 11
- PHP 8.2+
- Blade
- Alpine.js
- Tailwind CSS v4
- ApexCharts
- Vite

## Requirements

- PHP 8.2 or newer with Composer
- Node.js 20 or newer and npm

## Getting started

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

No database is required: the seed data lives in PHP classes and the login is simulated by middleware.

Use `npm run dev` instead of `npm run build` while editing, to get hot reload of the assets.

Demo account:

- `recepcao@hotel.com` / `demo123`

## Project structure

```
app/
├── Http/  Controllers, Middleware
├── Models/
├── Providers/
├── Support/
resources/  css/, js/, views/
routes/  console.php, web.php
```

## Other stacks

This template also exists in 4 other stacks, with the same screens and visual identity. All of them are free:

- React 19: https://github.com/danilo62x/hotel-react
- Vue 3: https://github.com/danilo62x/hotel-vue3
- Angular 19: https://github.com/danilo62x/hotel-angular
- Static HTML: https://github.com/danilo62x/hotel-html

More free templates (admin dashboards, vertical systems and Flutter apps): https://github.com/danilo62x?tab=repositories

## License

[MIT](./LICENSE), copyright 2026 Danilo Quinelato.
