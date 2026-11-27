// ─── i18n — mirrors hotel/react src/i18n + lib/format ───────────────────────
// The same pt-BR/en/es bundles, with i18next-style interpolation ({{x}}) and
// `_plural` pluralization, exposed both as a vanilla helper (data-i18n
// attributes) and as an Alpine magic `$t()` so Blade templates can localize
// reactively.
import ptBR from './locales/pt-BR.json';
import en from './locales/en.json';
import es from './locales/es.json';

export const LANGUAGES = [
  { code: 'pt-BR', label: 'Português', flag: '🇧🇷' },
  { code: 'en', label: 'English', flag: '🇺🇸' },
  { code: 'es', label: 'Español', flag: '🇪🇸' },
];

const RESOURCES = { 'pt-BR': ptBR, en, es };
const FALLBACK = 'pt-BR';

function detect() {
  try {
    const stored = localStorage.getItem('lang');
    if (stored && RESOURCES[stored]) return stored;
    const nav = (navigator.language || '').toLowerCase();
    if (nav.startsWith('pt')) return 'pt-BR';
    if (nav.startsWith('es')) return 'es';
    if (nav.startsWith('en')) return 'en';
  } catch (_) {}
  return FALLBACK;
}

function lookup(dict, key) {
  return key.split('.').reduce((o, k) => (o && o[k] != null ? o[k] : undefined), dict);
}

function interpolate(str, params) {
  return str.replace(/\{\{\s*(\w+)\s*\}\}/g, (_, name) =>
    params[name] != null ? String(params[name]) : ''
  );
}

const LOCALE_MAP = {
  'pt-BR': { locale: 'pt-BR', currency: 'BRL' },
  en: { locale: 'en-US', currency: 'USD' },
  es: { locale: 'es-ES', currency: 'EUR' },
};

// ─── format helpers — mirror hotel/react src/lib/format.ts ──────────────────
export function formatCurrency(value, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.NumberFormat(cfg.locale, {
    style: 'currency',
    currency: cfg.currency,
    maximumFractionDigits: 0,
  }).format(value);
}

export function formatCompact(value, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.NumberFormat(cfg.locale, { notation: 'compact', maximumFractionDigits: 1 }).format(value);
}

export function formatNumber(value, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.NumberFormat(cfg.locale).format(value);
}

export function formatPercent(value, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.NumberFormat(cfg.locale, { style: 'percent', maximumFractionDigits: 0 }).format(value / 100);
}

export function formatDate(iso, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.DateTimeFormat(cfg.locale, { dateStyle: 'medium' }).format(new Date(iso));
}

export function formatDateShort(iso, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.DateTimeFormat(cfg.locale, { day: '2-digit', month: 'short' }).format(new Date(iso));
}

export function formatWeekday(iso, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.DateTimeFormat(cfg.locale, { weekday: 'short' }).format(new Date(iso));
}

export function formatDateTime(iso, lang) {
  const cfg = LOCALE_MAP[lang] || LOCALE_MAP[FALLBACK];
  return new Intl.DateTimeFormat(cfg.locale, { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(iso));
}

class I18n {
  constructor() {
    this.lang = detect();
    this.dict = RESOURCES[this.lang] || RESOURCES[FALLBACK];
    this.fallbackDict = RESOURCES[FALLBACK];
  }

  t(key, params = {}) {
    // pluralization: count !== 1 → look for `${key}_plural`
    let realKey = key;
    if (params && typeof params.count === 'number' && params.count !== 1) {
      if (lookup(this.dict, `${key}_plural`) != null) realKey = `${key}_plural`;
    }
    let val = lookup(this.dict, realKey);
    if (val == null) val = lookup(this.fallbackDict, realKey);
    if (typeof val !== 'string') return key;
    return interpolate(val, params);
  }

  tArray(key) {
    let val = lookup(this.dict, key);
    if (val == null) val = lookup(this.fallbackDict, key);
    return Array.isArray(val) ? val : [];
  }

  setLang(lang) {
    if (!RESOURCES[lang]) return;
    this.lang = lang;
    this.dict = RESOURCES[lang];
    try {
      localStorage.setItem('lang', lang);
    } catch (_) {}
    document.documentElement.lang = lang;
    this.applyDom(document);
    document.dispatchEvent(new CustomEvent('i18n:changed', { detail: { lang } }));
  }

  applyDom(root) {
    (root || document).querySelectorAll('[data-i18n]').forEach((el) => {
      const v = this.t(el.getAttribute('data-i18n'));
      if (typeof v === 'string') el.textContent = v;
    });
    (root || document).querySelectorAll('[data-i18n-ph]').forEach((el) => {
      const v = this.t(el.getAttribute('data-i18n-ph'));
      if (typeof v === 'string') el.setAttribute('placeholder', v);
    });
  }
}

const i18n = new I18n();
window.I18n = i18n;
document.documentElement.lang = i18n.lang;

export default i18n;
