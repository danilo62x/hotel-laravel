<?php

namespace App\Support;

/**
 * Canonical mock data for the Hotel / PMS template — mirrors hotel/react
 * src/data/{mock,query,types}.ts + lib/format.ts.
 *
 * Raw values (room-type names, room numbers, guest names, documents, prices)
 * live here; human labels render via the JS i18n bundle (room status,
 * reservation status, channel, amenities). The resolved arrays are serialized
 * into the page (window.HT) so the Alpine stores read the same source:
 *   ht-pms     -> roomTypes / rooms / reservations / guests / rates / filters
 *   ht-booking -> booking draft (built client-side)
 * Occupancy / ADR / RevPAR / room-map / availability logic lives in JS
 * (window.htHelpers), ported from query.ts + format.ts.
 */
class HtData
{
    /** Mock "today" anchor so the dataset stays meaningful regardless of clock. */
    public const TODAY = '2026-05-31';

    /** Offset the TODAY anchor by N days, returning a yyyy-mm-dd string. */
    private static function iso(int $offsetDays): string
    {
        $d = new \DateTime(self::TODAY.'T00:00:00');
        $d->modify(($offsetDays >= 0 ? '+' : '').$offsetDays.' days');
        return $d->format('Y-m-d');
    }

    /** Curated Unsplash sets por tema (IDs verificados): quartos/resort/piscina -> hotel, staff/hóspede -> people. */
    private const IMG = [
        'hotel'  => ['1584132967334-10e028bd69f7', '1578683010236-d716f9a3f461', '1455587734955-081b22074882', '1611892440504-42a792e24d32', '1445019980597-93fa8acb246c', '1631049307264-da0ec9d70304', '1542314831-068cd1dbfeeb', '1568495248636-6432b97bd949', '1571003123894-1f0594d2b5d9', '1497366754035-f200968a6e72', '1618773928121-c32242e63f39', '1517825738774-7de9363ef735'],
        'people' => ['1500648767791-00dcc994a43e', '1494790108377-be9c29b29330', '1507003211169-0a1dd7228f2d', '1438761681033-6461ffad8d80', '1633332755192-727a05c4013d', '1573496359142-b8d87734a5a2'],
    ];

    private static function imgHash(string $s): int
    {
        $h = 0;
        $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            $h = ($h * 31 + ord($s[$i])) & 0xFFFFFFFF;
        }
        return $h;
    }

    private static function imgCategory(string $seed): string
    {
        $s = strtolower($seed);
        if (preg_match('/guest|client|user|person|team|member|author|testi|review|avatar|profile|staff/', $s)) return 'people';
        return 'hotel';
    }

    private static function unsplash(string $id, int $w, int $h): string
    {
        return "https://images.unsplash.com/photo-{$id}?w={$w}&h={$h}&fit=crop&q=70&auto=format";
    }

    /** Photo URL for a room-type gallery image (deterministic via slug + index). */
    public static function photoUrl(string $slug, int $i, int $w = 800, int $h = 600): string
    {
        $ids = self::IMG[self::imgCategory($slug)] ?? self::IMG['hotel'];
        return self::unsplash($ids[self::imgHash("{$slug}-{$i}") % count($ids)], $w, $h);
    }

    // ── Room types (6) ────────────────────────────────────────────────────

    /** @return list<array<string,mixed>> */
    public static function roomTypes(): array
    {
        return [
            [
                'id' => 1, 'slug' => 'standard-casal', 'name' => 'Standard Casal', 'capacity' => 2, 'bed' => 'double', 'baseRate' => 320, 'size' => 22,
                'description' => 'Quarto aconchegante com cama de casal, ideal para uma estadia confortável a dois. Ambiente silencioso e enxoval premium.',
                'amenities' => ['wifi', 'ac', 'tv', 'safe', 'coffee'], 'photos' => 5, 'featured' => false,
            ],
            [
                'id' => 2, 'slug' => 'superior-twin', 'name' => 'Superior Twin', 'capacity' => 2, 'bed' => 'twin', 'baseRate' => 380, 'size' => 26,
                'description' => 'Duas camas de solteiro, perfeito para amigos ou viagens a trabalho. Escrivaninha de trabalho e iluminação inteligente.',
                'amenities' => ['wifi', 'ac', 'tv', 'safe', 'workspace', 'coffee'], 'photos' => 5, 'featured' => false,
            ],
            [
                'id' => 3, 'slug' => 'deluxe-vista-mar', 'name' => 'Deluxe Vista Mar', 'capacity' => 2, 'bed' => 'queen', 'baseRate' => 540, 'size' => 32,
                'description' => 'Ampla suíte com cama queen e varanda privativa com vista para o mar. Banheira de imersão e mimos de boas-vindas.',
                'amenities' => ['wifi', 'ac', 'tv', 'minibar', 'safe', 'balcony', 'bathtub', 'seaView', 'coffee'], 'photos' => 6, 'featured' => true,
            ],
            [
                'id' => 4, 'slug' => 'family-suite', 'name' => 'Family Suite', 'capacity' => 4, 'bed' => 'king', 'baseRate' => 680, 'size' => 45,
                'description' => 'Suíte familiar com cama king e sofá-cama, sala de estar integrada e copa. Espaço para toda a família com conforto.',
                'amenities' => ['wifi', 'ac', 'tv', 'minibar', 'safe', 'livingRoom', 'sofaBed', 'kitchenette', 'coffee'], 'photos' => 6, 'featured' => true,
            ],
            [
                'id' => 5, 'slug' => 'master-suite', 'name' => 'Master Suite', 'capacity' => 2, 'bed' => 'king', 'baseRate' => 920, 'size' => 55,
                'description' => 'Suíte master com cama king, sala de estar, hidromassagem e vista panorâmica da cidade. Serviço de quarto 24h incluso.',
                'amenities' => ['wifi', 'ac', 'tv', 'minibar', 'safe', 'balcony', 'jacuzzi', 'cityView', 'livingRoom', 'coffee'], 'photos' => 6, 'featured' => true,
            ],
            [
                'id' => 6, 'slug' => 'studio-executivo', 'name' => 'Studio Executivo', 'capacity' => 1, 'bed' => 'queen', 'baseRate' => 420, 'size' => 28,
                'description' => 'Studio pensado para o viajante de negócios: estação de trabalho ergonômica, café premium e check-in expresso.',
                'amenities' => ['wifi', 'ac', 'tv', 'safe', 'workspace', 'minibar', 'coffee'], 'photos' => 5, 'featured' => false,
            ],
        ];
    }

    // ── Rooms (40 across 5 floors) ────────────────────────────────────────

    /** @return list<array<string,mixed>> */
    public static function rooms(): array
    {
        $cycle = ['livre', 'ocupado', 'limpeza', 'reservado', 'livre', 'ocupado', 'manutencao', 'livre'];
        $layout = [
            1 => [1, 1, 6, 6, 2, 2, 1, 6],
            2 => [1, 2, 2, 1, 3, 3, 2, 1],
            3 => [3, 3, 4, 4, 2, 1, 3, 2],
            4 => [4, 4, 5, 3, 3, 4, 1, 2],
            5 => [5, 5, 4, 3, 5, 3, 4, 1],
        ];
        $rooms = [];
        $id = 1;
        $c = 0;
        foreach ($layout as $floor => $typeIds) {
            foreach ($typeIds as $idx => $typeId) {
                $number = $floor.str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                $rooms[] = [
                    'id' => $id++,
                    'number' => $number,
                    'floor' => $floor,
                    'roomTypeId' => $typeId,
                    'status' => $cycle[$c % count($cycle)],
                ];
                $c++;
            }
        }
        return $rooms;
    }

    // ── Guests (20) ───────────────────────────────────────────────────────

    /** @return list<array<string,mixed>> */
    public static function guests(): array
    {
        return [
            ['id' => 1, 'name' => 'Mariana Lopes', 'email' => 'mariana.lopes@email.com', 'phone' => '+55 11 99100-3001', 'document' => '123.456.789-01', 'country' => 'BR', 'tier' => 'ouro', 'stays' => 12, 'notes' => 'Prefere andar alto, longe do elevador.'],
            ['id' => 2, 'name' => 'Carlos Eduardo Pinto', 'email' => 'carlos.pinto@email.com', 'phone' => '+55 21 99100-3002', 'document' => '234.567.890-12', 'country' => 'BR', 'tier' => 'prata', 'stays' => 6, 'notes' => 'Alergia a penas — travesseiro anti-alérgico.'],
            ['id' => 3, 'name' => 'Ana Beatriz Costa', 'email' => 'ana.costa@email.com', 'phone' => '+55 31 99100-3003', 'document' => '345.678.901-23', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 2, 'notes' => ''],
            ['id' => 4, 'name' => 'John Miller', 'email' => 'john.miller@email.com', 'phone' => '+1 415 555-0104', 'document' => 'US-PA-90381', 'country' => 'US', 'tier' => 'ouro', 'stays' => 9, 'notes' => 'Late check-out sempre que possível.'],
            ['id' => 5, 'name' => 'Sofía Hernández', 'email' => 'sofia.hernandez@email.com', 'phone' => '+34 600 555 105', 'document' => 'ES-PA-55210', 'country' => 'ES', 'tier' => 'prata', 'stays' => 4, 'notes' => 'Vegetariana — avisar restaurante.'],
            ['id' => 6, 'name' => 'Rafael Almeida', 'email' => 'rafael.almeida@email.com', 'phone' => '+55 11 99100-3006', 'document' => '456.789.012-34', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 1, 'notes' => ''],
            ['id' => 7, 'name' => 'Juliana Ferreira', 'email' => 'juliana.ferreira@email.com', 'phone' => '+55 41 99100-3007', 'document' => '567.890.123-45', 'country' => 'BR', 'tier' => 'prata', 'stays' => 5, 'notes' => 'Lua de mel — decoração especial.'],
            ['id' => 8, 'name' => 'Marco Rossi', 'email' => 'marco.rossi@email.com', 'phone' => '+39 320 555 0108', 'document' => 'IT-PA-77120', 'country' => 'IT', 'tier' => 'bronze', 'stays' => 1, 'notes' => ''],
            ['id' => 9, 'name' => 'Patrícia Souza', 'email' => 'patricia.souza@email.com', 'phone' => '+55 51 99100-3009', 'document' => '678.901.234-56', 'country' => 'BR', 'tier' => 'ouro', 'stays' => 14, 'notes' => 'Cliente corporativo — fatura para empresa.'],
            ['id' => 10, 'name' => 'Lucas Martins', 'email' => 'lucas.martins@email.com', 'phone' => '+55 11 99100-3010', 'document' => '789.012.345-67', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 3, 'notes' => ''],
            ['id' => 11, 'name' => 'Emily Clark', 'email' => 'emily.clark@email.com', 'phone' => '+44 7700 900111', 'document' => 'UK-PA-31002', 'country' => 'GB', 'tier' => 'prata', 'stays' => 7, 'notes' => 'Berço para bebê.'],
            ['id' => 12, 'name' => 'Fernanda Dias', 'email' => 'fernanda.dias@email.com', 'phone' => '+55 81 99100-3012', 'document' => '890.123.456-78', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 2, 'notes' => ''],
            ['id' => 13, 'name' => 'Diego Ramírez', 'email' => 'diego.ramirez@email.com', 'phone' => '+54 11 5555 0113', 'document' => 'AR-PA-44781', 'country' => 'AR', 'tier' => 'prata', 'stays' => 4, 'notes' => ''],
            ['id' => 14, 'name' => 'Beatriz Nogueira', 'email' => 'beatriz.nogueira@email.com', 'phone' => '+55 11 99100-3014', 'document' => '901.234.567-89', 'country' => 'BR', 'tier' => 'ouro', 'stays' => 11, 'notes' => 'Sempre solicita quarto silencioso.'],
            ['id' => 15, 'name' => 'Thiago Barbosa', 'email' => 'thiago.barbosa@email.com', 'phone' => '+55 62 99100-3015', 'document' => '012.345.678-90', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 1, 'notes' => ''],
            ['id' => 16, 'name' => 'Hannah Schmidt', 'email' => 'hannah.schmidt@email.com', 'phone' => '+49 151 5550116', 'document' => 'DE-PA-66510', 'country' => 'DE', 'tier' => 'prata', 'stays' => 6, 'notes' => 'Check-in tardio (após 22h).'],
            ['id' => 17, 'name' => 'Gustavo Henrique', 'email' => 'gustavo.henrique@email.com', 'phone' => '+55 11 99100-3017', 'document' => '111.222.333-44', 'country' => 'BR', 'tier' => 'bronze', 'stays' => 2, 'notes' => ''],
            ['id' => 18, 'name' => 'Camila Ribeiro', 'email' => 'camila.ribeiro@email.com', 'phone' => '+55 71 99100-3018', 'document' => '222.333.444-55', 'country' => 'BR', 'tier' => 'prata', 'stays' => 5, 'notes' => ''],
            ['id' => 19, 'name' => 'Pedro Carvalho', 'email' => 'pedro.carvalho@email.com', 'phone' => '+55 11 99100-3019', 'document' => '333.444.555-66', 'country' => 'BR', 'tier' => 'ouro', 'stays' => 10, 'notes' => 'Programa de fidelidade — upgrade cortesia.'],
            ['id' => 20, 'name' => 'Laura Gómez', 'email' => 'laura.gomez@email.com', 'phone' => '+57 300 555 0120', 'document' => 'CO-PA-88210', 'country' => 'CO', 'tier' => 'bronze', 'stays' => 1, 'notes' => ''],
        ];
    }

    // ── Reservations (30 around TODAY) ─────────────────────────────────────

    /** @return list<array<string,mixed>> */
    public static function reservations(): array
    {
        $types = [];
        foreach (self::roomTypes() as $rt) {
            $types[$rt['id']] = $rt;
        }

        // [guestId, roomTypeId, roomId, inOffset, nights, guests, status, channel, paidPct, notes]
        $seeds = [
            [1, 5, 33, -2, 4, 2, 'checkin', 'direto', 1, 'VIP — upgrade aplicado.'],
            [9, 2, 9, -1, 3, 1, 'checkin', 'direto', 1, ''],
            [4, 3, 18, -3, 5, 2, 'checkin', 'booking', 1, ''],
            [14, 1, 2, -1, 2, 2, 'checkin', 'expedia', 1, ''],
            [19, 4, 26, -2, 3, 4, 'checkin', 'direto', 1, 'Família com criança.'],
            [2, 1, 6, -2, 2, 1, 'checkin', 'airbnb', 1, ''],
            [11, 3, 19, -1, 1, 2, 'checkin', 'booking', 1, 'Berço solicitado.'],
            [5, 3, null, 0, 3, 2, 'confirmada', 'direto', 0.5, 'Vegetariana.'],
            [7, 5, null, 0, 2, 2, 'confirmada', 'direto', 1, 'Lua de mel.'],
            [16, 2, null, 0, 4, 2, 'confirmada', 'expedia', 1, 'Check-in tardio.'],
            [20, 1, null, 0, 1, 1, 'confirmada', 'booking', 1, ''],
            [8, 6, null, 0, 2, 1, 'confirmada', 'airbnb', 1, ''],
            [3, 4, null, 2, 3, 3, 'confirmada', 'direto', 1, ''],
            [6, 1, null, 3, 2, 2, 'confirmada', 'booking', 1, ''],
            [10, 2, null, 1, 2, 2, 'confirmada', 'expedia', 1, ''],
            [12, 3, null, 4, 5, 2, 'confirmada', 'direto', 1, ''],
            [13, 6, null, 5, 1, 1, 'confirmada', 'booking', 1, ''],
            [15, 5, null, 6, 2, 2, 'confirmada', 'direto', 1, ''],
            [17, 4, null, 7, 4, 4, 'confirmada', 'airbnb', 1, ''],
            [18, 1, null, 2, 2, 1, 'confirmada', 'expedia', 1, ''],
            [3, 2, 25, -5, 2, 2, 'checkout', 'direto', 1, ''],
            [13, 1, 1, -6, 3, 1, 'checkout', 'booking', 1, ''],
            [18, 3, 18, -7, 2, 2, 'checkout', 'expedia', 1, ''],
            [6, 6, 3, -4, 1, 1, 'checkout', 'direto', 1, ''],
            [11, 4, 26, -8, 4, 3, 'checkout', 'booking', 1, ''],
            [8, 5, null, 1, 2, 2, 'cancelada', 'airbnb', 0, ''],
            [15, 1, null, -2, 2, 1, 'cancelada', 'expedia', 0, ''],
            [20, 2, null, -1, 1, 1, 'noshow', 'booking', 0, ''],
            [17, 3, 34, -1, 3, 2, 'checkin', 'direto', 1, ''],
            [10, 6, 4, -2, 2, 1, 'checkin', 'booking', 1, ''],
        ];

        $out = [];
        foreach ($seeds as $i => $s) {
            [$guestId, $roomTypeId, $roomId, $inOffset, $nights, $guests, $status, $channel, $paidPct, $notes] = $s;
            $rt = $types[$roomTypeId];
            $total = $rt['baseRate'] * $nights;
            $out[] = [
                'id' => $i + 1,
                'code' => 'HT-'.(2000 + $i + 1),
                'guestId' => $guestId,
                'roomTypeId' => $roomTypeId,
                'roomId' => $roomId,
                'checkIn' => self::iso($inOffset),
                'checkOut' => self::iso($inOffset + $nights),
                'guests' => $guests,
                'status' => $status,
                'channel' => $channel,
                'total' => $total,
                'paid' => (int) round($total * $paidPct),
                'notes' => $notes,
                'createdAt' => self::iso($inOffset - 7).'T10:00:00',
            ];
        }
        return $out;
    }

    // ── Rates & availability (per type, next 14 days) ──────────────────────

    /** @return list<array<string,mixed>> */
    public static function rates(): array
    {
        $rooms = self::rooms();
        $out = [];
        foreach (self::roomTypes() as $rt) {
            $totalOfType = count(array_filter($rooms, fn ($r) => $r['roomTypeId'] === $rt['id']));
            for ($d = 0; $d < 14; $d++) {
                $date = self::iso($d);
                $weekday = (int) (new \DateTime($date.'T00:00:00'))->format('w'); // 0=Sun..6=Sat
                $weekend = $weekday === 5 || $weekday === 6;
                $rate = (int) round($rt['baseRate'] * ($weekend ? 1.25 : 1));
                $sold = ($d + $rt['id']) % ($totalOfType + 1);
                $out[] = [
                    'roomTypeId' => $rt['id'],
                    'date' => $date,
                    'rate' => $rate,
                    'available' => max(0, $totalOfType - $sold),
                    'closed' => $rt['id'] === 1 && ($d === 9 || $d === 10),
                ];
            }
        }
        return $out;
    }

    // ── Hotel amenities ────────────────────────────────────────────────────

    /** @return list<array<string,string>> */
    public static function hotelAmenities(): array
    {
        return [
            ['key' => 'wifi', 'icon' => 'wifi'],
            ['key' => 'pool', 'icon' => 'wave'],
            ['key' => 'restaurant', 'icon' => 'concierge-bell'],
            ['key' => 'gym', 'icon' => 'dumbbell'],
            ['key' => 'spa', 'icon' => 'sparkles'],
            ['key' => 'parking', 'icon' => 'car'],
            ['key' => 'bar', 'icon' => 'coffee'],
            ['key' => 'roomService', 'icon' => 'concierge-bell'],
            ['key' => 'reception', 'icon' => 'concierge-bell'],
            ['key' => 'laundry', 'icon' => 'sparkles'],
            ['key' => 'meeting', 'icon' => 'briefcase'],
            ['key' => 'petFriendly', 'icon' => 'heart'],
        ];
    }

    // ── Dashboard chart series (mock) ──────────────────────────────────────

    /** @return array<string,mixed> */
    public static function occupancySeries(): array
    {
        return [
            'categories' => ['25 mai', '26 mai', '27 mai', '28 mai', '29 mai', '30 mai', '31 mai'],
            'occupancy' => [62, 68, 71, 65, 78, 84, 80],
            'adr' => [410, 425, 440, 418, 470, 510, 495],
        ];
    }

    /** @return list<array<string,string>> */
    public static function testimonials(): array
    {
        return [['key' => 't1'], ['key' => 't2'], ['key' => 't3']];
    }
}
