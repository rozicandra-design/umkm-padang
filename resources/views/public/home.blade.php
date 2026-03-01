@extends('public.layouts.app')

@section('title', 'Beranda')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ===== RESET & BASE ===== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ===== CONTAINER ===== */
.container {
  width: 100%;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 40px;
  padding-right: 40px;
}
@media (max-width: 640px) {
  .container { padding-left: 20px; padding-right: 20px; }
}

/* ===== CSS VARIABLES ===== */
:root {
  --green-50:  #f0fdf4;
  --green-100: #dcfce7;
  --green-200: #bbf7d0;
  --green-500: #22c55e;
  --green-600: #16a34a;
  --green-700: #15803d;
  --gray-50:   #f9fafb;
  --gray-100:  #f3f4f6;
  --gray-200:  #e5e7eb;
  --gray-300:  #d1d5db;
  --gray-400:  #9ca3af;
  --gray-500:  #6b7280;
  --gray-700:  #374151;
  --gray-900:  #111827;
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 20px;
  --shadow-sm: 0 1px 4px rgba(0,0,0,.06);
  --shadow-md: 0 4px 16px rgba(0,0,0,.08);
  --shadow-lg: 0 8px 32px rgba(0,0,0,.1);
}

/* ===== ANIMATIONS ===== */
@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: .5; transform: scale(1.4); }
}
@keyframes float-badge {
  0%, 100% { transform: translateY(0); }
  50%       { transform: translateY(-6px); }
}
@keyframes fade-up {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-fade-up { animation: fade-up .6s ease both; }
.animate-fade-up-2 { animation: fade-up .6s .15s ease both; }
.animate-fade-up-3 { animation: fade-up .6s .3s ease both; }

/* ===== HERO ===== */
.hero {
  background: #fff;
  padding: 88px 0 72px;
  border-bottom: 1px solid var(--gray-100);
  overflow: hidden;
  position: relative;
}
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 50% at 70% 50%, rgba(22,163,74,.05) 0%, transparent 70%),
    radial-gradient(ellipse 30% 40% at 10% 80%, rgba(34,197,94,.04) 0%, transparent 60%);
  pointer-events: none;
}
.hero .container {
  display: flex;
  align-items: center;
  gap: 48px;
}
.hero-text { flex: 1; min-width: 0; }

.hero-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--green-50);
  color: var(--green-600);
  font-size: 13px;
  font-weight: 600;
  padding: 6px 16px;
  border-radius: 100px;
  margin-bottom: 24px;
  letter-spacing: .3px;
  border: 1px solid var(--green-200);
}
.hero-eyebrow-dot {
  width: 7px; height: 7px;
  background: var(--green-500);
  border-radius: 50%;
  animation: pulse-dot 2s infinite;
  flex-shrink: 0;
}
.hero h1 {
  font-family: 'Playfair Display', serif;
  font-size: 46px;
  font-weight: 900;
  line-height: 1.15;
  color: var(--gray-900);
  margin-bottom: 18px;
  letter-spacing: -.4px;
}
.hero h1 span { color: var(--green-600); }
.hero-desc {
  font-size: 17px;
  color: var(--gray-500);
  line-height: 1.75;
  margin-bottom: 36px;
  max-width: 460px;
}
.hero-btns {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 52px;
}

/* Buttons */
.btn-primary {
  background: var(--green-600);
  color: #fff;
  padding: 13px 26px;
  border-radius: var(--radius-md);
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: background .2s, transform .15s, box-shadow .2s;
  box-shadow: 0 2px 8px rgba(22,163,74,.3);
}
.btn-primary:hover {
  background: var(--green-700);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(22,163,74,.35);
}
.btn-outline {
  background: #fff;
  color: var(--gray-700);
  padding: 13px 26px;
  border-radius: var(--radius-md);
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  border: 1.5px solid var(--gray-200);
  transition: border-color .2s, transform .15s, box-shadow .2s;
}
.btn-outline:hover {
  border-color: var(--gray-400);
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}

/* Hero Stats */
.hero-stats {
  display: flex;
  gap: 40px;
  padding-top: 8px;
}
.hero-stat .num {
  font-family: 'Playfair Display', serif;
  font-size: 30px;
  font-weight: 900;
  color: var(--gray-900);
  line-height: 1;
}
.hero-stat .num span { color: var(--green-600); }
.hero-stat .lbl {
  font-size: 12px;
  color: var(--gray-400);
  font-weight: 500;
  margin-top: 5px;
  text-transform: uppercase;
  letter-spacing: .6px;
}

/* Hero Visual */
.hero-visual {
  flex: 0 0 420px;
  max-width: 420px;
  position: relative;
}
.hero-card-stack { position: relative; height: 380px; }
.hero-main-card {
  background: linear-gradient(145deg, var(--green-50), var(--green-100));
  border-radius: var(--radius-xl);
  padding: 36px;
  border: 1.5px solid var(--green-200);
  height: 290px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
  box-shadow: var(--shadow-md);
}
.hero-main-card::before {
  content: '🏪';
  position: absolute;
  right: 28px; top: 28px;
  font-size: 52px;
  opacity: .8;
}
.hero-main-card::after {
  content: '';
  position: absolute;
  bottom: -30px; right: -30px;
  width: 120px; height: 120px;
  background: var(--green-200);
  border-radius: 50%;
  opacity: .4;
}
.hero-card-label {
  font-size: 13px;
  font-weight: 600;
  color: var(--green-700);
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: .6px;
}
.hero-card-big {
  font-family: 'Playfair Display', serif;
  font-size: 40px;
  font-weight: 900;
  color: var(--gray-900);
  line-height: 1;
}
.hero-card-sub {
  font-size: 14px;
  color: var(--gray-500);
  margin-top: 10px;
}

/* Floating Badges */
.badge-float {
  position: absolute;
  background: #fff;
  border-radius: var(--radius-md);
  padding: 12px 18px;
  box-shadow: 0 8px 28px rgba(0,0,0,.12);
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  font-weight: 600;
  color: var(--gray-900);
  z-index: 2;
  border: 1px solid var(--gray-100);
}
.badge-float.bl {
  bottom: 8px;
  left: -24px;
  animation: float-badge 3s 0.5s ease-in-out infinite;
}
.badge-float.tr {
  top: -20px;
  right: -24px;
  animation: float-badge 3s 1.2s ease-in-out infinite;
}
.badge-float-icon {
  width: 34px; height: 34px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  flex-shrink: 0;
}
.badge-float-icon.green { background: var(--green-100); }
.badge-float-icon.blue  { background: #dbeafe; }
.badge-float-meta { font-size: 11px; color: var(--gray-400); font-weight: 500; margin-bottom: 1px; }

/* ===== SEARCH ===== */
.search-section {
  background: var(--gray-50);
  border-bottom: 1px solid var(--gray-100);
  padding: 24px 0 28px;
}
.search-form {
  display: flex;
  align-items: center;
  background: #fff;
  border: 1.5px solid var(--gray-200);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: border-color .2s, box-shadow .2s;
}
.search-form:focus-within {
  border-color: var(--green-500);
  box-shadow: 0 0 0 3px rgba(34,197,94,.12);
}
.search-icon {
  padding: 0 16px;
  color: var(--gray-400);
  font-size: 15px;
  flex-shrink: 0;
}
.search-form input {
  flex: 1;
  border: none;
  outline: none;
  padding: 14px 0;
  font-size: 15px;
  color: var(--gray-900);
  background: transparent;
  font-family: inherit;
}
.search-form input::placeholder { color: var(--gray-400); }
.search-form .btn-search {
  background: var(--green-600);
  color: #fff;
  border: none;
  padding: 14px 28px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: background .2s;
  font-family: inherit;
  white-space: nowrap;
}
.search-form .btn-search:hover { background: var(--green-700); }
.search-tags {
  margin-top: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.search-tags .tag-label { font-size: 13px; color: var(--gray-400); font-weight: 500; }
.tag-pill {
  background: #fff;
  border: 1.5px solid var(--gray-200);
  color: var(--gray-700);
  font-size: 13px;
  padding: 5px 14px;
  border-radius: 100px;
  text-decoration: none;
  font-family: inherit;
  transition: border-color .2s, color .2s, background .2s;
}
.tag-pill:hover {
  border-color: var(--green-500);
  color: var(--green-600);
  background: var(--green-50);
}

/* ===== SECTION BASE ===== */
.section { padding: 80px 0; }
.section-gray { background: var(--gray-50); }
.section-head { margin-bottom: 48px; }
.section-head-centered { text-align: center; }
.section-head-centered .section-desc { margin-left: auto; margin-right: auto; }
.badge-label {
  display: inline-block;
  background: var(--green-50);
  color: var(--green-600);
  font-size: 11px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 100px;
  text-transform: uppercase;
  letter-spacing: .9px;
  margin-bottom: 14px;
  border: 1px solid var(--green-200);
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 36px;
  font-weight: 900;
  color: var(--gray-900);
  margin-bottom: 12px;
  line-height: 1.2;
}
.section-desc {
  font-size: 16px;
  color: var(--gray-500);
  max-width: 520px;
  line-height: 1.65;
}

/* ===== CATEGORIES ===== */
.cats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 14px;
}
.cat-item {
  background: #fff;
  border: 1.5px solid var(--gray-100);
  border-radius: var(--radius-lg);
  padding: 24px 14px 20px;
  text-align: center;
  text-decoration: none;
  display: block;
  transition: border-color .2s, box-shadow .2s, transform .2s;
}
.cat-item:hover {
  border-color: var(--green-500);
  box-shadow: 0 4px 20px rgba(22,163,74,.1);
  transform: translateY(-3px);
}
.cat-emoji { font-size: 34px; display: block; margin-bottom: 10px; }
.cat-name { font-size: 14px; font-weight: 600; color: var(--gray-900); margin-bottom: 4px; }
.cat-count { font-size: 12px; color: var(--gray-400); }

/* ===== UMKM CARDS ===== */
.umkm-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(286px, 1fr));
  gap: 24px;
}
.umkm-card {
  background: #fff;
  border: 1.5px solid var(--gray-100);
  border-radius: var(--radius-lg);
  overflow: hidden;
  text-decoration: none;
  display: block;
  transition: box-shadow .25s, transform .2s, border-color .2s;
}
.umkm-card:hover {
  box-shadow: var(--shadow-lg);
  transform: translateY(-4px);
  border-color: var(--gray-200);
}
.umkm-cover {
  height: 130px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 44px;
  position: relative;
}
/* Cover gradient variants */
.umkm-cover.c1 { background: linear-gradient(135deg,#fef9c3,#fde68a); }
.umkm-cover.c2 { background: linear-gradient(135deg,#dcfce7,#a7f3d0); }
.umkm-cover.c3 { background: linear-gradient(135deg,#dbeafe,#bfdbfe); }
.umkm-cover.c4 { background: linear-gradient(135deg,#fce7f3,#fbcfe8); }
.umkm-cover.c5 { background: linear-gradient(135deg,#f3e8ff,#ddd6fe); }
.umkm-cover.c6 { background: linear-gradient(135deg,#ffedd5,#fed7aa); }

.badge-verified {
  position: absolute;
  top: 10px; right: 10px;
  background: var(--green-600);
  color: #fff;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 100px;
  display: flex;
  align-items: center;
  gap: 4px;
}
.umkm-body { padding: 18px 20px; }
.umkm-name { font-size: 16px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
.umkm-cat { font-size: 13px; color: var(--green-600); font-weight: 500; margin-bottom: 8px; }
.umkm-loc {
  font-size: 13px;
  color: var(--gray-400);
  display: flex;
  align-items: center;
  gap: 5px;
  margin-bottom: 14px;
}
.umkm-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 12px;
  border-top: 1px solid var(--gray-100);
}
.umkm-rating { font-size: 13px; color: var(--gray-700); font-weight: 600; }
.umkm-product-count { font-size: 12px; color: var(--gray-400); }
.badge-open {
  font-size: 11px;
  color: var(--green-600);
  font-weight: 600;
  background: var(--green-50);
  padding: 3px 10px;
  border-radius: 100px;
}

/* ===== PRODUCT CARDS ===== */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(224px, 1fr));
  gap: 20px;
}
.product-card {
  background: #fff;
  border: 1.5px solid var(--gray-100);
  border-radius: var(--radius-lg);
  overflow: hidden;
  transition: box-shadow .25s, transform .2s;
}
.product-card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-3px);
}
.product-img {
  height: 190px;
  background: var(--gray-50);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 48px;
  position: relative;
  overflow: hidden;
}
.product-img img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .3s;
}
.product-card:hover .product-img img { transform: scale(1.04); }
.wishlist-btn {
  position: absolute;
  top: 10px; right: 10px;
  background: rgba(255,255,255,.9);
  backdrop-filter: blur(4px);
  border: none;
  width: 34px; height: 34px;
  border-radius: var(--radius-sm);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-sm);
  color: var(--gray-400);
  transition: color .2s, background .2s;
  z-index: 1;
}
.wishlist-btn:hover { color: #ef4444; background: #fff; }
.product-body { padding: 16px; }
.product-store { font-size: 12px; color: var(--gray-400); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.product-name {
  font-size: 14px;
  font-weight: 600;
  color: var(--gray-900);
  text-decoration: none;
  display: block;
  margin-bottom: 8px;
  line-height: 1.45;
  /* Clamp to 2 lines */
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.product-name:hover { color: var(--green-600); }
.product-price {
  font-size: 16px;
  font-weight: 700;
  color: var(--green-600);
  margin-bottom: 12px;
}
.product-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 10px;
  border-top: 1px solid var(--gray-100);
}
.product-rating { font-size: 12px; color: var(--gray-500); }
.btn-order {
  background: var(--green-600);
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  padding: 7px 14px;
  border-radius: var(--radius-sm);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: background .2s, transform .15s;
}
.btn-order:hover { background: var(--green-700); transform: translateY(-1px); }

/* ===== MAP ===== */
.map-section {
  background: var(--gray-50);
  padding: 80px 0;
  border-top: 1px solid var(--gray-100);
}
#map {
  border-radius: var(--radius-lg);
  border: 1.5px solid var(--gray-200);
  box-shadow: var(--shadow-sm);
}
.map-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-top: 20px;
}
.map-stat {
  background: #fff;
  border: 1.5px solid var(--gray-100);
  border-radius: var(--radius-md);
  padding: 18px 24px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.map-stat-icon { font-size: 26px; flex-shrink: 0; }
.map-stat-num { font-size: 22px; font-weight: 800; color: var(--gray-900); line-height: 1; }
.map-stat-label { font-size: 12px; color: var(--gray-400); font-weight: 500; margin-top: 3px; }

/* ===== HOW IT WORKS ===== */
.steps-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  position: relative;
}
.steps-grid::before {
  content: '';
  position: absolute;
  top: 36px;
  left: calc(12.5% + 20px);
  right: calc(12.5% + 20px);
  height: 2px;
  background: linear-gradient(90deg, var(--green-600) 0%, var(--green-200) 100%);
  z-index: 0;
  border-radius: 2px;
}
.step-card {
  background: #fff;
  border: 1.5px solid var(--gray-100);
  border-radius: var(--radius-lg);
  padding: 28px 20px 24px;
  text-align: center;
  position: relative;
  z-index: 1;
  transition: box-shadow .2s, transform .2s, border-color .2s;
}
.step-card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-3px);
  border-color: var(--green-200);
}
.step-number {
  width: 42px; height: 42px;
  background: var(--green-600);
  color: #fff;
  border-radius: 11px;
  font-size: 16px;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  box-shadow: 0 4px 12px rgba(22,163,74,.3);
}
.step-icon { font-size: 34px; margin-bottom: 12px; }
.step-title { font-size: 15px; font-weight: 700; color: var(--gray-900); margin-bottom: 8px; }
.step-desc { font-size: 13px; color: var(--gray-500); line-height: 1.65; }

/* ===== CTA ===== */
.cta-section {
  background: var(--green-50);
  border-top: 1px solid var(--green-200);
  border-bottom: 1px solid var(--green-200);
  padding: 88px 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cta-section::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(22,163,74,.08) 0%, transparent 70%);
  pointer-events: none;
}
.cta-section h2 {
  font-family: 'Playfair Display', serif;
  font-size: 42px;
  font-weight: 900;
  color: var(--gray-900);
  margin-bottom: 16px;
  letter-spacing: -.3px;
}
.cta-section p {
  font-size: 16px;
  color: var(--gray-500);
  margin-bottom: 40px;
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
  line-height: 1.7;
}
.cta-btns {
  display: flex;
  gap: 14px;
  justify-content: center;
  flex-wrap: wrap;
}

/* ===== UTILITIES ===== */
.text-center { text-align: center; }
.mt-10 { margin-top: 48px; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .hero h1 { font-size: 38px; }
  .hero-visual { flex: 0 0 340px; max-width: 340px; }
  .hero .container { gap: 36px; }
}
@media (max-width: 900px) {
  .hero .container { flex-direction: column; gap: 40px; }
  .hero-visual { display: none; }
  .hero { padding: 60px 0 48px; }
  .hero h1 { font-size: 36px; }
  .hero-desc { max-width: 100%; }
  .steps-grid { grid-template-columns: repeat(2, 1fr); }
  .steps-grid::before { display: none; }
  .cta-section h2 { font-size: 32px; }
}
@media (max-width: 640px) {
  .hero h1 { font-size: 32px; }
  .hero-stats { flex-direction: column; gap: 18px; }
  .map-stats { grid-template-columns: 1fr; }
  .steps-grid { grid-template-columns: 1fr; }
  .cats-grid { grid-template-columns: repeat(3, 1fr); }
  .section { padding: 56px 0; }
  .section-title { font-size: 28px; }
  .hero-btns { gap: 10px; }
  .btn-primary, .btn-outline { padding: 12px 20px; font-size: 14px; }
}
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
  <div class="container">
    <div class="hero-text animate-fade-up">
      <div class="hero-eyebrow">
        <span class="hero-eyebrow-dot"></span>
        Marketplace Resmi UMKM Kota Padang
      </div>
      <h1>Temukan Produk <span>Terbaik</span><br>dari UMKM Lokal</h1>
      <p class="hero-desc">
        Platform digital untuk menghubungkan Anda dengan ratusan UMKM unggulan di Kota Padang.
        Belanja mudah, dukung ekonomi lokal.
      </p>
      <div class="hero-btns animate-fade-up-2">
        <a href="{{ route('katalog') }}" class="btn-primary">
          <i class="fa fa-shopping-bag"></i> Jelajahi Produk
        </a>
        <a href="{{ route('umkm.index') }}" class="btn-outline">
          <i class="fa fa-store"></i> Lihat UMKM
        </a>
      </div>
      <div class="hero-stats animate-fade-up-3">
        <div class="hero-stat">
          <div class="num">{{ number_format($stats['total_umkm']) }}<span>+</span></div>
          <div class="lbl">UMKM Terdaftar</div>
        </div>
        <div class="hero-stat">
          <div class="num">{{ number_format($stats['total_produk']) }}<span>+</span></div>
          <div class="lbl">Produk Tersedia</div>
        </div>
        <div class="hero-stat">
          <div class="num">{{ number_format($stats['total_customer']) }}<span>+</span></div>
          <div class="lbl">Pelanggan Aktif</div>
        </div>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-card-stack">
        <div class="hero-main-card">
          <div class="hero-card-label">UMKM Unggulan</div>
          <div class="hero-card-big">{{ number_format($stats['total_umkm']) }}+</div>
          <div class="hero-card-sub">Terverifikasi &amp; aktif di Kota Padang</div>
        </div>
        <div class="badge-float bl">
          <div class="badge-float-icon green">📦</div>
          <div>
            <div class="badge-float-meta">Produk Tersedia</div>
            <div>{{ number_format($stats['total_produk']) }}+</div>
          </div>
        </div>
        <div class="badge-float tr">
          <div class="badge-float-icon blue">👤</div>
          <div>
            <div class="badge-float-meta">Pelanggan Aktif</div>
            <div>{{ number_format($stats['total_customer']) }}+</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== SEARCH ===== --}}
<section class="search-section">
  <div class="container">
    <form action="{{ route('katalog') }}" method="GET" class="search-form">
      <span class="search-icon"><i class="fa fa-search"></i></span>
      <input
        type="text"
        name="q"
        placeholder="Cari produk, UMKM, atau kecamatan..."
        value="{{ request('q') }}"
        autocomplete="off"
      >
      <button type="submit" class="btn-search">Cari Sekarang</button>
    </form>
    <div class="search-tags">
      <span class="tag-label">Populer:</span>
      @foreach(['Rendang','Songket','Kopi','Kerajinan Tangan','Kue Tradisional'] as $tag)
        <a href="{{ route('katalog', ['q' => $tag]) }}" class="tag-pill">{{ $tag }}</a>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== CATEGORIES ===== --}}
<section class="section">
  <div class="container">
    <div class="section-head">
      <div class="badge-label">Kategori Usaha</div>
      <h2 class="section-title">Temukan Berdasarkan Kategori</h2>
      <p class="section-desc">Pilih kategori untuk menemukan UMKM dan produk yang Anda butuhkan</p>
    </div>
    <div class="cats-grid">
      @foreach($categories as $cat)
        <a href="{{ route('umkm.index', ['category' => $cat->id]) }}" class="cat-item">
          <span class="cat-emoji">{{ $cat->icon ?? '🏪' }}</span>
          <div class="cat-name">{{ $cat->name }}</div>
          <div class="cat-count">{{ $cat->umkm_profiles_count ?? 0 }} UMKM</div>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== FEATURED UMKM ===== --}}
<section class="section section-gray">
  <div class="container">
    <div class="section-head">
      <div class="badge-label">UMKM Unggulan</div>
      <h2 class="section-title">UMKM Terpilih Kota Padang</h2>
      <p class="section-desc">Usaha terverifikasi terbaik dari berbagai kecamatan di Kota Padang</p>
    </div>
    <div class="umkm-grid">
      @foreach($featuredUmkm as $umkm)
        @php $colors = ['c1','c2','c3','c4','c5','c6']; @endphp
        <a href="{{ route('umkm.show', $umkm->slug) }}" class="umkm-card">
          <div class="umkm-cover {{ $colors[$loop->index % 6] }}">
            {{ $umkm->category->icon ?? '🏪' }}
            <div class="badge-verified"><i class="fa fa-check"></i> Terverifikasi</div>
          </div>
          <div class="umkm-body">
            <div class="umkm-name">{{ $umkm->name }}</div>
            <div class="umkm-cat">{{ $umkm->category->name ?? '-' }}</div>
            <div class="umkm-loc"><i class="fa fa-map-marker-alt"></i> Kec. {{ $umkm->kecamatan }}</div>
            <div class="umkm-footer">
              {{-- BUG FIX: Simplified avg rating calculation to avoid nested collection issues --}}
              @php
                $avgRating = $umkm->products->flatMap(fn($p) => $p->reviews)->avg('rating') ?? 5;
              @endphp
              <div class="umkm-rating">⭐ {{ number_format($avgRating, 1) }}</div>
              <div class="umkm-product-count">{{ $umkm->products_count ?? $umkm->products->count() }} Produk</div>
              <span class="badge-open">● Buka</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>
    <div class="text-center mt-10">
      <a href="{{ route('umkm.index') }}" class="btn-primary">Lihat Semua UMKM <i class="fa fa-arrow-right"></i></a>
    </div>
  </div>
</section>

{{-- ===== PRODUCTS ===== --}}
<section class="section">
  <div class="container">
    <div class="section-head">
      <div class="badge-label">Produk Terbaru</div>
      <h2 class="section-title">Produk Pilihan Minggu Ini</h2>
    </div>
    <div class="products-grid">
      @foreach($latestProducts as $product)
        <div class="product-card">
          <div class="product-img">
            <a href="{{ route('katalog.show', $product->slug) }}" style="display:contents;">
              @if($product->images->isNotEmpty())
                <img
                  src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                  alt="{{ $product->name }}"
                  loading="lazy"
                >
              @else
                🛍️
              @endif
            </a>
            @auth
              @if(auth()->user()->role === 'customer')
                <button
                  class="wishlist-btn"
                  data-product="{{ $product->id }}"
                  title="Tambah ke wishlist"
                  type="button"
                >
                  <i class="far fa-heart"></i>
                </button>
              @endif
            @endauth
          </div>
          <div class="product-body">
            <div class="product-store">{{ $product->umkm->name ?? '-' }}</div>
            <a href="{{ route('katalog.show', $product->slug) }}" class="product-name">{{ $product->name }}</a>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="product-footer">
              {{-- BUG FIX: Null-safe avg with fallback to 0 --}}
              <div class="product-rating">
                ⭐ {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}
                ({{ $product->reviews->count() }})
              </div>
              <a href="{{ route('katalog.show', $product->slug) }}" class="btn-order">
                <i class="fa fa-shopping-cart"></i> Pesan
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="text-center mt-10">
      <a href="{{ route('katalog') }}" class="btn-primary">Lihat Semua Produk <i class="fa fa-arrow-right"></i></a>
    </div>
  </div>
</section>

{{-- ===== MAP ===== --}}
<section class="map-section">
  <div class="container">
    <div class="section-head">
      <div class="badge-label">Peta Interaktif</div>
      <h2 class="section-title">Sebaran UMKM Kota Padang</h2>
      <p class="section-desc">Temukan UMKM terdekat di seluruh kecamatan Kota Padang</p>
    </div>
    <div id="map" style="height: 420px;"></div>
    <div class="map-stats">
      <div class="map-stat">
        <span class="map-stat-icon">📍</span>
        <div>
          <div class="map-stat-num">{{ $stats['total_umkm'] }}</div>
          <div class="map-stat-label">Total UMKM</div>
        </div>
      </div>
      <div class="map-stat">
        <span class="map-stat-icon">🏘️</span>
        <div>
          <div class="map-stat-num">11</div>
          <div class="map-stat-label">Kecamatan</div>
        </div>
      </div>
      <div class="map-stat">
        <span class="map-stat-icon">✅</span>
        <div>
          <div class="map-stat-num">{{ $stats['total_umkm'] }}</div>
          <div class="map-stat-label">UMKM Aktif</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="section">
  <div class="container">
    <div class="section-head section-head-centered text-center">
      <div class="badge-label">Cara Kerja</div>
      <h2 class="section-title">Mudah, Cepat, Terpercaya</h2>
    </div>
    <div class="steps-grid">
      @foreach([
        ['1','📝','Daftar Akun','Buat akun gratis dalam hitungan menit sebagai pelanggan atau daftarkan UMKM Anda.'],
        ['2','🔍','Temukan Produk','Jelajahi ratusan produk dari berbagai kategori dengan filter lokasi dan harga.'],
        ['3','🛒','Pesan &amp; Bayar','Tambahkan ke keranjang dan bayar dengan metode pembayaran pilihan Anda.'],
        ['4','🚀','Terima Pesanan','Produk dikirim langsung oleh UMKM. Lacak status pesanan secara real-time.']
      ] as [$num, $icon, $title, $desc])
        <div class="step-card">
          <div class="step-number">{{ $num }}</div>
          <div class="step-icon">{{ $icon }}</div>
          <div class="step-title">{{ $title }}</div>
          <p class="step-desc">{!! $desc !!}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== CTA ===== --}}
<section class="cta-section">
  <div class="container">
    <h2>Daftarkan UMKM Anda Sekarang</h2>
    <p>
      Bergabunglah dengan {{ number_format($stats['total_umkm']) }}+ UMKM yang telah berkembang
      bersama kami. Gratis dan terpercaya.
    </p>
    <div class="cta-btns">
      <a href="{{ route('register.umkm') }}" class="btn-primary">
        <i class="fa fa-store"></i> Daftar UMKM Gratis
      </a>
      <a href="{{ route('register') }}" class="btn-outline">
        <i class="fa fa-user"></i> Daftar Pelanggan
      </a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // ===== MAP INIT =====
  const map = L.map('map', {
    center: [-0.9492, 100.3543],
    zoom: 12,
    zoomControl: true,
    scrollWheelZoom: false  // BUG FIX: disable scroll zoom to prevent page scroll hijack
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
  }).addTo(map);

  // Custom green marker icon
  const greenIcon = L.divIcon({
    className: '',
    html: `<div style="
      width:32px;height:32px;
      background:#16a34a;
      border-radius:50% 50% 50% 0;
      transform:rotate(-45deg);
      border:3px solid #fff;
      box-shadow:0 2px 8px rgba(0,0,0,.25);
    "></div>`,
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -34]
  });

  // BUG FIX: Filter out entries without valid coordinates before mapping
  const umkmData = @json($featuredUmkm->whereNotNull('latitude')->whereNotNull('longitude')->values());

  umkmData.forEach(function (u) {
    const lat = parseFloat(u.latitude);
    const lng = parseFloat(u.longitude);

    // BUG FIX: Validate that lat/lng are actual numbers and within valid range
    if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
      L.marker([lat, lng], { icon: greenIcon })
        .addTo(map)
        .bindPopup(`
          <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:180px;">
            <div style="font-weight:700;font-size:14px;color:#111827;margin-bottom:4px;">${u.name}</div>
            <div style="font-size:12px;color:#6b7280;margin-bottom:8px;">📍 Kec. ${u.kecamatan}</div>
            <a href="/umkm/${u.slug}" style="
              display:inline-flex;align-items:center;gap:5px;
              background:#16a34a;color:#fff;text-decoration:none;
              font-size:12px;font-weight:600;padding:6px 12px;
              border-radius:6px;
            ">Lihat Detail →</a>
          </div>
        `);
    }
  });

  // ===== WISHLIST BUTTONS =====
  document.querySelectorAll('.wishlist-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const icon = this.querySelector('i');
      const productId = this.dataset.product;

      // Toggle heart icon visually (actual AJAX call should be wired to your endpoint)
      if (icon.classList.contains('far')) {
        icon.classList.replace('far', 'fas');
        icon.style.color = '#ef4444';
      } else {
        icon.classList.replace('fas', 'far');
        icon.style.color = '';
      }

      // BUG FIX: Commented-out fetch skeleton — wire to your real wishlist route
      // fetch(`/wishlist/toggle/${productId}`, {
      //   method: 'POST',
      //   headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
      // });
    });
  });
});
</script>
@endpush