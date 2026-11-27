# Hotel / Laravel

[Read in English](./README.md)

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](./LICENSE) ![Free](https://img.shields.io/badge/price-free-brightgreen)

App de hotel em Laravel 11 + Tailwind: site de reservas (acomodações, disponibilidade, reservar) e PMS com dashboard (ocupação, ADR, RevPAR), reservas, mapa de quartos por status, check-in/check-out, hóspedes e tarifas/disponibilidade. i18n pt-BR/en/es, PWA, dark mode.

## Destaques

- Mapa de quartos por status (livre/ocupado/limpeza)
- Reservas, check-in/check-out e hóspedes
- Tarifas e disponibilidade por data
- Dashboard: ocupação, ADR, RevPAR e receita
- i18n pt-BR/en/es, PWA, dark mode

## Telas em destaque

- Acomodações: Quartos e reserva
- Mapa de quartos: Status por andar
- Reservas: Check-in/out e hóspedes
- Dashboard: Ocupação, ADR, RevPAR

## Stack

- Laravel 11
- PHP 8.2+
- Blade
- Alpine.js
- Tailwind CSS v4
- ApexCharts
- Vite

## Requisitos

- PHP 8.2 ou mais novo, com Composer
- Node.js 20 ou mais novo, com npm

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

Não precisa de banco de dados: os dados de exemplo ficam em classes PHP e o login é simulado por middleware.

Durante o desenvolvimento, use `npm run dev` no lugar de `npm run build` para ter hot reload dos assets.

Conta de demonstração:

- `recepcao@hotel.com` / `demo123`

## Estrutura do projeto

```
app/
├── Http/  Controllers, Middleware
├── Models/
├── Providers/
├── Support/
resources/  css/, js/, views/
routes/  console.php, web.php
```

## Outras tecnologias

Este template também existe em outras 4 tecnologias, com as mesmas telas e a mesma identidade visual. Todas são gratuitas:

- React 19: https://github.com/danilo62x/hotel-react
- Vue 3: https://github.com/danilo62x/hotel-vue3
- Angular 19: https://github.com/danilo62x/hotel-angular
- HTML estático: https://github.com/danilo62x/hotel-html

Mais templates gratuitos (painéis admin, sistemas por segmento e apps Flutter): https://github.com/danilo62x?tab=repositories

## Licença

[MIT](./LICENSE), copyright 2026 Danilo Quinelato.
