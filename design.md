# AMIK Taruna — Design System & Visual Guidelines (design.md)
*Source of Truth for Frontend UI/UX Redesign*

---

## 1. Design Philosophy

> **"Academic Prestige meets Digital Precision"**

* **Modern, but not generic:** Menampilkan karakter autentik AMIK Taruna sebagai kampus vokasi teknologi terkemuka, bukan template SaaS generik atau blog korporat hambar.
* **Premium, but not excessive:** Kualitas dan kemewahan dicapai melalui ritme spasial (whitespace), ketajaman tipografi, dan konsistensi layout—bukan efek visual berlebihan.
* **Technology-oriented, but still academic and human:** Menghadirkan presisi dunia komputasi yang dipadukan dengan kehangatan relasi dosen-mahasiswa dan etika keilmuan perguruan tinggi.
* **Animated, but not distracting:** Animasi hanya dihadirkan sebagai umpan balik interaksi mikro yang halus (micro-feedback), tidak pernah mengganggu fokus membaca pengguna.

---

## 2. Larangan Visual (Prohibited Clichés)

1. **Dilarang:** Glassmorphism berlebihan / blur tebal yang mengaburkan teks.
2. **Dilarang:** Gradien warna-warni spektrum luas (*rainbow/mesh gradients*).
3. **Dilarang:** Border bercahaya (*glowing/neon borders*).
4. **Dilarang:** Bentuk melayang acak (*floating blobs/confetti*).
5. **Dilarang:** Sudut kartu yang terlalu membulat (*excessive rounded corners > 24px*).
6. **Dilarang:** Bayangan hitam pekat bertumpuk (*deep drop shadows*).
7. **Dilarang:** Animasi mengambang terus-menerus (*infinite floating emojis/text glow*).
8. **Dilarang:** Layout yang menyerupai dashboard SaaS analitik.
9. **Dilarang:** Gaya visual artifisial hasil klise AI generator.

---

## 3. Color Tokens (Design System)

### Primary — Academic Forest Green
* Warna utama institusi; melambangkan pertumbuhan intelektual, stabilitas, dan integritas akademik.
* `--color-brand-950`: `#051f14` (Ultra dark, footer & dark surfaces)
* `--color-brand-900`: `#0a2e1e` (Dark header & contrast surfaces)
* `--color-brand-800`: `#0f472d` (Deep brand tone)
* `--color-brand-700`: `#14633f` (Primary Action & Accent Base)
* `--color-brand-600`: `#198754` (Standard interactive green / hover)
* `--color-brand-500`: `#22c55e` (Success indicator)
* `--color-brand-100`: `#dcfce7` (Pill badge background)
* `--color-brand-50`:  `#f0fdf4` (Subtle tinted surface)

### Accent — Amber Gold (PMB & Highlight)
* Digunakan secara selektif untuk Call-to-Action utama (Penerimaan Mahasiswa Baru) dan badge terakreditasi resmi.
* `--color-accent-amber`: `#d97706` (Amber dark, text & high contrast)
* `--color-accent-gold`:  `#f59e0b` (Amber base, CTA button & highlight)
* `--color-accent-light`: `#fef3c7` (Subtle amber badge background)

### Neutrals — Slate & Canvas
* Menjamin tingkat keterbacaan (readability) maksimal sesuai standar WCAG 2.1 AA (kontras rasio minimal 4.5:1).
* `--color-slate-900`: `#0f172a` (Primary Heading text)
* `--color-slate-700`: `#334155` (Sub-heading & active elements)
* `--color-slate-600`: `#475569` (Body text utama)
* `--color-slate-400`: `#94a3b8` (Muted caption & metadata)
* `--color-slate-200`: `#e2e8f0` (Borders & dividers)
* `--color-slate-100`: `#f1f5f9` (Subtle cards & backgrounds)
* `--color-surface`:   `#ffffff` (Pure white card surface)
* `--color-canvas`:    `#f8fafc` (Body canvas background)

---

## 4. Typography Scale

* **Font Family:** `'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif`

| Token | CSS Clamp / Size | Weight | Line Height | Penggunaan |
| :--- | :--- | :--- | :--- | :--- |
| `display` | `clamp(2.25rem, 5vw, 3.25rem)` | `800` (ExtraBold) | `1.15` | Hero Main Headline |
| `h1` | `clamp(1.85rem, 4vw, 2.5rem)` | `800` (ExtraBold) | `1.2` | Halaman Utama / Title |
| `h2` | `clamp(1.5rem, 3vw, 2rem)` | `700` (Bold) | `1.25` | Judul Section |
| `h3` | `1.25rem` (20px) | `700` (Bold) | `1.35` | Judul Kartu Utama |
| `h4` | `1.125rem` (18px) | `600` (SemiBold) | `1.4` | Sub-fitur / Item Title |
| `body-lg` | `1.125rem` (18px) | `400` / `500` | `1.7` | Hero Lead / Deskripsi |
| `body` | `1rem` (16px) | `400` (Regular) | `1.65` | Paragraf Standar |
| `body-sm` | `0.875rem` (14px) | `500` (Medium) | `1.5` | Caption, Tanggal, Label |
| `eyebrow` | `0.75rem` (12px) | `700` (Bold) | `1.2` | Tag Kategori, Uppercase 0.05em |

---

## 5. Spacing, Radius & Elevation

### Spacing Scale (8pt System)
* `space-1`: `4px` | `space-2`: `8px` | `space-3`: `12px` | `space-4`: `16px`
* `space-6`: `24px` | `space-8`: `32px` | `space-12`: `48px` | `space-16`: `64px` | `space-24`: `96px`

### Border Radius Scale
* `radius-sm`: `6px` (Badge, pill kecil)
* `radius-md`: `10px` (Input field, tombol)
* `radius-lg`: `14px` (Kartu fitur, berita, card umum)
* `radius-xl`: `20px` (Hero media card, panel modul besar)
*(Maksimal 20px, dilarang melebihi 24px)*

### Elevation / Bayangan
* `shadow-sm`: `0 1px 2px 0 rgba(15, 23, 42, 0.05)`
* `shadow-card`: `0 4px 12px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03)`
* `shadow-card-hover`: `0 12px 24px -4px rgba(15, 23, 42, 0.10), 0 4px 8px -2px rgba(15, 23, 42, 0.04)`
* `shadow-dropdown`: `0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.04)`

---

## 6. Motion & Interaction Guidelines

* **Default Duration:** `200ms`–`300ms`
* **Easing Function:** `cubic-bezier(0.16, 1, 0.3, 1)` (Smooth ease-out)
* **Hover State:** Kenaikan elevasi `translateY(-3px)` yang halus dan penajaman bayangan.
* **Navbar Transition:** Transisi background blur dan elevasi saat scroll melewati 20px.
* **Drawer Navigation:** Transisi geser horizontal (`translateX`) dari sisi kanan pada mobile viewport.
* **No Continuous Gimmicks:** Tidak ada animasi floating atau blinking yang berjalan otomatis terus-menerus.
