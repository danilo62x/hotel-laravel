import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import i18n, { LANGUAGES } from './i18n.js';
import './pwa.js';

window.Alpine = Alpine;

// ─── Magics do Alpine expostos como globais ─────────────────────────────────
// As fábricas de página (dashboardPage(), ordersPage(), …) são funções
// declaradas num <script>, fora do escopo de expressão do Alpine — que é onde
// o with(scope) coloca os magics. O Alpine injeta os magics no OBJETO DE DADOS
// (injectMagics), não no window, então um `$store` ou `$t` nu dentro dessas
// funções seria ReferenceError. Espelhamos os magics em window para que elas
// continuem legíveis. Alpine.store() devolve o mesmo proxy reativo do magic,
// então os getters que leem daqui continuam reativos.
window.$store = new Proxy(
  {},
  { get: (_target, name) => (typeof name === 'string' ? Alpine.store(name) : undefined) }
);
const registerMagic = Alpine.magic.bind(Alpine);
Alpine.magic = (name, callback) => {
  registerMagic(name, callback);
  Object.defineProperty(window, `$${name}`, { configurable: true, get: () => callback() });
};

Alpine.plugin(collapse);

// ─── localStorage helpers (mirror zustand persist) ──────────────────────────
function load(key, fallback) {
  try {
    const raw = localStorage.getItem(key);
    if (!raw) return fallback;
    const parsed = JSON.parse(raw);
    return parsed && parsed.state ? parsed.state : parsed;
  } catch (_) {
    return fallback;
  }
}
function save(key, state) {
  try {
    localStorage.setItem(key, JSON.stringify({ state, version: 0 }));
  } catch (_) {}
}

const HT = window.HT || {};

// ─── Formatting — ported from hotel/react src/lib/format.ts ──────────────────
const LOCALE_MAP = {
  'pt-BR': { locale: 'pt-BR', currency: 'BRL' },
  en: { locale: 'en-US', currency: 'USD' },
  es: { locale: 'es-ES', currency: 'EUR' },
};
function cfg(lang) {
  return LOCALE_MAP[lang] || LOCALE_MAP['pt-BR'];
}
function formatCurrency(value, lang = 'pt-BR') {
  const c = cfg(lang);
  return new Intl.NumberFormat(c.locale, { style: 'currency', currency: c.currency, maximumFractionDigits: 0 }).format(value);
}
function formatNumber(value, lang = 'pt-BR') {
  return new Intl.NumberFormat(cfg(lang).locale).format(value);
}
function formatPercent(value, lang = 'pt-BR') {
  return new Intl.NumberFormat(cfg(lang).locale, { style: 'percent', maximumFractionDigits: 0 }).format(value / 100);
}
function formatDate(iso, lang = 'pt-BR') {
  return new Intl.DateTimeFormat(cfg(lang).locale, { dateStyle: 'medium' }).format(new Date(iso));
}
function formatDateShort(iso, lang = 'pt-BR') {
  return new Intl.DateTimeFormat(cfg(lang).locale, { day: '2-digit', month: 'short' }).format(new Date(iso));
}
function formatDateTime(iso, lang = 'pt-BR') {
  return new Intl.DateTimeFormat(cfg(lang).locale, { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(iso));
}

const MS_PER_DAY = 86400000;
function nights(checkIn, checkOut) {
  const a = new Date(checkIn + (checkIn.length === 10 ? 'T00:00:00' : ''));
  const b = new Date(checkOut + (checkOut.length === 10 ? 'T00:00:00' : ''));
  return Math.max(0, Math.round((b.getTime() - a.getTime()) / MS_PER_DAY));
}
function todayISO() {
  return new Date().toISOString().slice(0, 10);
}
function addDays(iso, days) {
  const d = new Date(iso + (iso.length === 10 ? 'T00:00:00' : ''));
  d.setDate(d.getDate() + days);
  return d.toISOString().slice(0, 10);
}

// ─── i18n magics ─────────────────────────────────────────────────────────────
const touchLang = () => {
  if (Alpine.store('ui')) Alpine.store('ui').lang;
};
Alpine.magic('t', () => (key, params) => {
  touchLang();
  return i18n.t(key, params);
});
Alpine.magic('lang', () => {
  touchLang();
  return i18n.lang;
});
Alpine.magic('currency', () => (value) => {
  touchLang();
  return formatCurrency(value, i18n.lang);
});
Alpine.magic('number', () => (value) => {
  touchLang();
  return formatNumber(value, i18n.lang);
});
Alpine.magic('percent', () => (value) => {
  touchLang();
  return formatPercent(value, i18n.lang);
});
Alpine.magic('date', () => (iso) => {
  touchLang();
  return formatDate(iso, i18n.lang);
});
Alpine.magic('dateShort', () => (iso) => {
  touchLang();
  return formatDateShort(iso, i18n.lang);
});
Alpine.magic('datetime', () => (iso) => {
  touchLang();
  return formatDateTime(iso, i18n.lang);
});

// ─── UI store — key: ht-ui (theme, lang, sidebar, toasts) ────────────────────
let toastId = 0;
const savedUi = load('ht-ui', {});
Alpine.store('ui', {
  darkMode: savedUi.darkMode ?? false,
  sidebarCollapsed: savedUi.sidebarCollapsed ?? false,
  sidebarMobileOpen: false,
  toasts: [],
  lang: i18n.lang,

  init() {
    this.applyTheme();
    Alpine.effect(() => {
      this.darkMode;
      this.applyTheme();
      save('ht-ui', { darkMode: this.darkMode, sidebarCollapsed: this.sidebarCollapsed });
    });
    document.addEventListener('i18n:changed', (e) => {
      this.lang = e.detail.lang;
    });
  },
  applyTheme() {
    const root = document.documentElement;
    if (this.darkMode) root.classList.add('dark');
    else root.classList.remove('dark');
  },
  toggleDarkMode() {
    this.darkMode = !this.darkMode;
  },
  setDarkMode(v) {
    this.darkMode = v;
  },
  toggleSidebar() {
    this.sidebarCollapsed = !this.sidebarCollapsed;
  },
  toggleSidebarMobile(v) {
    this.sidebarMobileOpen = v !== undefined ? v : !this.sidebarMobileOpen;
  },
  setLang(lang) {
    i18n.setLang(lang);
    this.lang = lang;
  },
  get languages() {
    return LANGUAGES;
  },
  get currentLanguage() {
    return LANGUAGES.find((l) => l.code === this.lang) || LANGUAGES[0];
  },

  notify(message, type = 'info', duration = 4000) {
    const id = ++toastId;
    this.toasts.push({ id, message, type, duration });
    setTimeout(() => this.dismissToast(id), duration);
  },
  notifySuccess(m) {
    this.notify(m, 'success');
  },
  notifyError(m) {
    this.notify(m, 'error');
  },
  notifyWarning(m) {
    this.notify(m, 'warning');
  },
  dismissToast(id) {
    const i = this.toasts.findIndex((t) => t.id === id);
    if (i !== -1) this.toasts.splice(i, 1);
  },
});

// ─── Auth store — key: ht-auth (demo recepcao@hotel.com / demo123) ───────────
Alpine.store('auth', {
  user: load('ht-auth', { user: null }).user ?? null,

  init() {
    if (HT.user && !this.user) {
      this.user = HT.user;
    }
    Alpine.effect(() => {
      this.user;
      save('ht-auth', { user: this.user });
    });
  },
  get isAuthenticated() {
    return this.user !== null;
  },
  setUser(user) {
    this.user = user;
  },
  logout() {
    this.user = null;
  },
  updateProfile(patch) {
    if (!this.user) return;
    this.user = { ...this.user, ...patch };
  },
});

// ─── PMS store — key: ht-pms ─────────────────────────────────────────────────
// Mirrors hotel/react stores/pms.ts: roomTypes/rooms/reservations/guests/rates +
// createReservation/setReservationStatus/checkIn/checkOut/setRoomStatus/setRate/
// toggleClosed/addGuest/setFilters.
let seq = 5000;
const nextId = () => ++seq;
const DEFAULT_FILTERS = { query: '', status: '', channel: '', from: '', to: '' };
const savedPms = load('ht-pms', {});

Alpine.store('pms', {
  roomTypes: HT.roomTypes || [],
  rooms: savedPms.rooms ?? (HT.rooms || []),
  reservations: savedPms.reservations ?? (HT.reservations || []),
  guests: savedPms.guests ?? (HT.guests || []),
  rates: savedPms.rates ?? (HT.rates || []),
  filters: savedPms.filters ?? { ...DEFAULT_FILTERS },

  init() {
    Alpine.effect(() => {
      this.rooms.length;
      this.reservations.length;
      this.guests.length;
      this.rates.length;
      JSON.stringify(this.filters);
      // touch nested status changes
      this.rooms.map((r) => r.status).join();
      this.reservations.map((r) => r.status + (r.roomId ?? '')).join();
      save('ht-pms', {
        rooms: this.rooms,
        reservations: this.reservations,
        guests: this.guests,
        rates: this.rates,
        filters: this.filters,
      });
    });
  },

  // lookups
  roomTypeById(id) {
    return this.roomTypes.find((r) => r.id === id);
  },
  roomTypeBySlug(slug) {
    return this.roomTypes.find((r) => r.slug === slug);
  },
  guestById(id) {
    return this.guests.find((g) => g.id === id);
  },
  roomById(id) {
    if (id == null) return undefined;
    return this.rooms.find((r) => r.id === id);
  },

  createReservation(input) {
    const id = nextId();
    const rt = this.roomTypeById(input.roomTypeId);
    const total = (rt ? rt.baseRate : 0) * Math.max(1, nights(input.checkIn, input.checkOut));
    const reservation = {
      id,
      code: `HT-${3000 + id}`,
      guestId: input.guestId,
      roomTypeId: input.roomTypeId,
      roomId: input.roomId ?? null,
      checkIn: input.checkIn,
      checkOut: input.checkOut,
      guests: input.guests,
      status: 'confirmada',
      channel: input.channel,
      total,
      paid: 0,
      notes: input.notes ?? '',
      createdAt: new Date().toISOString(),
    };
    this.reservations.unshift(reservation);
    return reservation;
  },

  setReservationStatus(id, status) {
    const r = this.reservations.find((x) => x.id === id);
    if (r) r.status = status;
  },

  checkIn(reservationId, roomId) {
    const r = this.reservations.find((x) => x.id === reservationId);
    if (r) {
      r.status = 'checkin';
      r.roomId = roomId;
    }
    const rm = this.roomById(roomId);
    if (rm) rm.status = 'ocupado';
  },

  checkOut(reservationId) {
    const r = this.reservations.find((x) => x.id === reservationId);
    if (!r) return;
    r.status = 'checkout';
    r.paid = r.total;
    if (r.roomId) {
      const rm = this.roomById(r.roomId);
      if (rm) rm.status = 'limpeza';
    }
  },

  setRoomStatus(roomId, status) {
    const rm = this.roomById(roomId);
    if (rm) rm.status = status;
  },

  setRate(roomTypeId, date, rate) {
    const e = this.rates.find((x) => x.roomTypeId === roomTypeId && x.date === date);
    if (e) e.rate = rate;
  },

  toggleClosed(roomTypeId, date) {
    const e = this.rates.find((x) => x.roomTypeId === roomTypeId && x.date === date);
    if (e) e.closed = !e.closed;
  },

  addGuest(g) {
    const id = nextId();
    const guest = { ...g, id, stays: g.stays ?? 0 };
    this.guests.unshift(guest);
    return guest;
  },

  setFilters(patch) {
    this.filters = { ...this.filters, ...patch };
  },
  resetFilters() {
    this.filters = { ...DEFAULT_FILTERS };
  },
});

// ─── Booking store — key: ht-booking (public-site booking draft) ─────────────
const initialCheckIn = todayISO();
const savedBooking = load('ht-booking', null);
Alpine.store('booking', {
  checkIn: savedBooking?.checkIn ?? initialCheckIn,
  checkOut: savedBooking?.checkOut ?? addDays(initialCheckIn, 2),
  guests: savedBooking?.guests ?? 2,
  roomTypeSlug: savedBooking?.roomTypeSlug ?? null,

  init() {
    Alpine.effect(() => {
      save('ht-booking', {
        checkIn: this.checkIn,
        checkOut: this.checkOut,
        guests: this.guests,
        roomTypeSlug: this.roomTypeSlug,
      });
    });
  },
  setDates(checkIn, checkOut) {
    this.checkIn = checkIn;
    this.checkOut = checkOut;
  },
  setGuests(g) {
    this.guests = Math.max(1, g);
  },
  selectRoomType(slug) {
    this.roomTypeSlug = slug;
  },
  reset() {
    this.checkIn = todayISO();
    this.checkOut = addDays(todayISO(), 2);
    this.guests = 2;
    this.roomTypeSlug = null;
  },
});

// ─── Shared PMS helpers — ported from hotel/react src/data/query.ts ──────────
const CHANNELS = ['direto', 'booking', 'expedia', 'airbnb'];
const ROOM_STATUSES = ['livre', 'ocupado', 'limpeza', 'manutencao', 'reservado'];

function filterRoomTypes(list, f) {
  let out = list;
  if (f.capacity) out = out.filter((r) => r.capacity >= f.capacity);
  if (f.minRate != null && f.minRate !== '') out = out.filter((r) => r.baseRate >= f.minRate);
  if (f.maxRate != null && f.maxRate !== '') out = out.filter((r) => r.baseRate <= f.maxRate);
  if (f.amenities && f.amenities.length) out = out.filter((r) => f.amenities.every((a) => r.amenities.includes(a)));
  return out;
}

function searchReservations(list, guests, query) {
  const q = (query || '').trim().toLowerCase();
  if (!q) return list;
  return list.filter((r) => {
    const g = guests.find((x) => x.id === r.guestId);
    return (
      r.code.toLowerCase().includes(q) ||
      (g ? g.name.toLowerCase().includes(q) : false) ||
      (g ? g.email.toLowerCase().includes(q) : false)
    );
  });
}

function filterReservations(list, guests, f) {
  let out = list;
  if (f.query) out = searchReservations(out, guests, f.query);
  if (f.status) out = out.filter((r) => r.status === f.status);
  if (f.channel) out = out.filter((r) => r.channel === f.channel);
  if (f.from) out = out.filter((r) => r.checkOut >= f.from);
  if (f.to) out = out.filter((r) => r.checkIn <= f.to);
  return out;
}

function paginate(list, page, pageSize) {
  const total = list.length;
  const pageCount = Math.max(1, Math.ceil(total / pageSize));
  const safe = Math.min(Math.max(1, page), pageCount);
  const start = (safe - 1) * pageSize;
  return { items: list.slice(start, start + pageSize), page: safe, pageCount, total };
}

function roomsByFloor(rooms) {
  const map = new Map();
  for (const r of rooms) {
    if (!map.has(r.floor)) map.set(r.floor, []);
    map.get(r.floor).push(r);
  }
  return Array.from(map.entries())
    .sort((a, b) => a[0] - b[0])
    .map(([floor, list]) => ({ floor, rooms: [...list].sort((a, b) => String(a.number).localeCompare(String(b.number))) }));
}

function countRoomsByStatus(rooms) {
  const out = { livre: 0, ocupado: 0, limpeza: 0, manutencao: 0, reservado: 0 };
  for (const r of rooms) out[r.status]++;
  return out;
}

function arrivalsToday(reservations, today) {
  return reservations.filter((r) => r.checkIn === today && (r.status === 'confirmada' || r.status === 'checkin'));
}
function departuresToday(reservations, today) {
  return reservations.filter((r) => r.checkOut === today && (r.status === 'checkin' || r.status === 'checkout'));
}
function inHouse(reservations, today) {
  return reservations.filter((r) => r.status === 'checkin' && r.checkIn <= today && r.checkOut > today);
}

function computeMetrics(rooms, reservations, roomTypes, today) {
  const totalRooms = rooms.length;
  const occupiedRooms = rooms.filter((r) => r.status === 'ocupado').length;
  const stays = inHouse(reservations, today);

  let roomRevenue = 0;
  for (const r of stays) {
    const n = Math.max(1, nights(r.checkIn, r.checkOut));
    roomRevenue += r.total / n;
  }
  if (roomRevenue === 0 && occupiedRooms > 0) {
    for (const room of rooms.filter((r) => r.status === 'ocupado')) {
      const rt = roomTypes.find((t) => t.id === room.roomTypeId);
      roomRevenue += rt ? rt.baseRate : 0;
    }
  }

  const soldRooms = Math.max(occupiedRooms, stays.length);
  const occupancy = totalRooms ? Math.round((soldRooms / totalRooms) * 100) : 0;
  const adr = soldRooms ? Math.round(roomRevenue / soldRooms) : 0;
  const revpar = totalRooms ? Math.round(roomRevenue / totalRooms) : 0;

  return {
    occupancy,
    adr,
    revpar,
    occupiedRooms: soldRooms,
    totalRooms,
    arrivals: arrivalsToday(reservations, today).length,
    departures: departuresToday(reservations, today).length,
    revenueToday: Math.round(roomRevenue),
  };
}

function revenueByChannel(reservations) {
  const out = { direto: 0, booking: 0, expedia: 0, airbnb: 0 };
  for (const r of reservations) {
    if (r.status === 'cancelada' || r.status === 'noshow') continue;
    out[r.channel] += r.total;
  }
  return out;
}

function totalRevenue(reservations) {
  return reservations
    .filter((r) => r.status !== 'cancelada' && r.status !== 'noshow')
    .reduce((s, r) => s + r.total, 0);
}

function ratesForType(rates, roomTypeId, from, to) {
  return rates
    .filter((e) => e.roomTypeId === roomTypeId)
    .filter((e) => (from ? e.date >= from : true) && (to ? e.date < to : true))
    .sort((a, b) => a.date.localeCompare(b.date));
}
function rateOn(rates, roomTypeId, date) {
  return rates.find((e) => e.roomTypeId === roomTypeId && e.date === date);
}
function isAvailable(rates, roomTypeId, checkIn, checkOut) {
  const span = ratesForType(rates, roomTypeId, checkIn, checkOut);
  if (span.length === 0) return true;
  return span.every((e) => !e.closed && e.available > 0);
}
function quoteStay(rates, roomTypeId, checkIn, checkOut, fallbackRate) {
  const span = ratesForType(rates, roomTypeId, checkIn, checkOut);
  if (span.length === 0) return fallbackRate * Math.max(1, nights(checkIn, checkOut));
  return span.reduce((s, e) => s + e.rate, 0);
}
function rateDates(rates) {
  return Array.from(new Set(rates.map((e) => e.date))).sort();
}

// Room-map status tones (mirror hotel/react components/hotel/RoomStatusTile.tsx).
const ROOM_STATUS_TONE = {
  livre: 'bg-success-50 text-success-700 border-success-200 dark:bg-success-500/15 dark:text-success-400 dark:border-success-500/30',
  ocupado: 'bg-brand-50 text-brand-700 border-brand-200 dark:bg-brand-500/15 dark:text-brand-400 dark:border-brand-500/30',
  limpeza: 'bg-warning-50 text-warning-700 border-warning-200 dark:bg-warning-500/15 dark:text-warning-400 dark:border-warning-500/30',
  manutencao: 'bg-error-50 text-error-700 border-error-200 dark:bg-error-500/15 dark:text-error-400 dark:border-error-500/30',
  reservado: 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
};
const ROOM_STATUS_DOT = {
  livre: 'bg-success-500',
  ocupado: 'bg-brand-500',
  limpeza: 'bg-warning-500',
  manutencao: 'bg-error-500',
  reservado: 'bg-gray-400',
};
const RES_STATUS_COLOR = {
  confirmada: 'brand',
  checkin: 'success',
  checkout: 'gray',
  cancelada: 'error',
  noshow: 'warning',
};
const TIER_COLOR = { bronze: 'warning', prata: 'gray', ouro: 'success' };

window.htHelpers = {
  CHANNELS,
  ROOM_STATUSES,
  TODAY: HT.today || '2026-05-31',
  nights,
  todayISO,
  addDays,
  formatCurrency: (v) => formatCurrency(v, i18n.lang),
  formatNumber: (v) => formatNumber(v, i18n.lang),
  formatPercent: (v) => formatPercent(v, i18n.lang),
  formatDate: (iso) => formatDate(iso, i18n.lang),
  formatDateShort: (iso) => formatDateShort(iso, i18n.lang),
  formatDateTime: (iso) => formatDateTime(iso, i18n.lang),
  photoUrl: (slug, i, w = 800, h = 600) => { const IMG = { hotel: ['1584132967334-10e028bd69f7','1578683010236-d716f9a3f461','1455587734955-081b22074882','1611892440504-42a792e24d32','1445019980597-93fa8acb246c','1631049307264-da0ec9d70304','1542314831-068cd1dbfeeb','1568495248636-6432b97bd949','1571003123894-1f0594d2b5d9','1497366754035-f200968a6e72','1618773928121-c32242e63f39','1517825738774-7de9363ef735'], people: ['1500648767791-00dcc994a43e','1494790108377-be9c29b29330','1507003211169-0a1dd7228f2d','1438761681033-6461ffad8d80','1633332755192-727a05c4013d','1573496359142-b8d87734a5a2'] }; const cat = /guest|client|user|person|team|member|author|testi|review|avatar|profile|staff/.test(String(slug).toLowerCase()) ? 'people' : 'hotel'; const ids = IMG[cat]; let h2 = 0; const key = `${slug}-${i}`; for (let k = 0; k < key.length; k++) h2 = (h2 * 31 + key.charCodeAt(k)) >>> 0; return `https://images.unsplash.com/photo-${ids[h2 % ids.length]}?w=${w}&h=${h}&fit=crop&q=70&auto=format`; },
  filterRoomTypes,
  searchReservations,
  filterReservations,
  paginate,
  roomsByFloor,
  countRoomsByStatus,
  arrivalsToday,
  departuresToday,
  inHouse,
  computeMetrics,
  revenueByChannel,
  totalRevenue,
  ratesForType,
  rateOn,
  isAvailable,
  quoteStay,
  rateDates,
  roomStatusTone: (s) => ROOM_STATUS_TONE[s] || ROOM_STATUS_TONE.reservado,
  roomStatusDot: (s) => ROOM_STATUS_DOT[s] || ROOM_STATUS_DOT.reservado,
  resStatusColor: (s) => RES_STATUS_COLOR[s] || 'gray',
  tierColor: (t) => TIER_COLOR[t] || 'gray',
  initials(name) {
    if (!name) return '?';
    return name.split(' ').slice(0, 2).map((w) => (w[0] || '').toUpperCase()).join('');
  },
};

// ─── ApexCharts theme-aware factory (mirrors ui/ApexChart.tsx) ───────────────
// ApexCharts is loaded via CDN per chart page (@push('head')).
window.htChart = {
  base() {
    const dark = !!(Alpine.store('ui') && Alpine.store('ui').darkMode);
    const fg = dark ? '#98a2b3' : '#667085';
    const grid = dark ? '#1f2937' : '#e4e7ec';
    return {
      chart: { fontFamily: 'Outfit, sans-serif', foreColor: fg, toolbar: { show: false }, zoom: { enabled: false } },
      colors: ['#465fff', '#12b76a', '#f79009', '#f04438', '#0ba5ec'],
      grid: { borderColor: grid, strokeDashArray: 4 },
      tooltip: { theme: dark ? 'dark' : 'light' },
      legend: { labels: { colors: fg } },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
    };
  },
};

// Apply static DOM translations once Alpine is up.
document.addEventListener('alpine:initialized', () => i18n.applyDom(document));

Alpine.start();
