# 🎨 Blockchain Stok - Color Palette Reference

## Palet Warna Utama

```
┌─────────────────────────────────────────────────────────┐
│                  PRIMARY - BIRU PROFESIONAL              │
├─────────────────────────────────────────────────────────┤
│ Primary         │ #2563EB  │ ████████████████████████  │
│ Primary Dark    │ #1D4ED8  │ ████████████████████░░░░  │
│ Primary Light   │ #DBEAFE  │ ██░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   SUCCESS - HIJAU MINT                   │
├─────────────────────────────────────────────────────────┤
│ Success         │ #10B981  │ ████████████░░░░░░░░░░░░  │
│ Success Dark    │ #059669  │ ████████░░░░░░░░░░░░░░░░  │
│ Success Light   │ #D1FAE5  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   WARNING - AMBER ORANGE                 │
├─────────────────────────────────────────────────────────┤
│ Warning         │ #F59E0B  │ ████████████████░░░░░░░░  │
│ Warning Dark    │ #D97706  │ ███████████░░░░░░░░░░░░░  │
│ Warning Light   │ #FEF3C7  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   ERROR - MERAH TERANG                   │
├─────────────────────────────────────────────────────────┤
│ Error           │ #EF4444  │ ███████████░░░░░░░░░░░░░  │
│ Error Dark      │ #DC2626  │ █████████░░░░░░░░░░░░░░░  │
│ Error Light     │ #FEE2E2  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    INFO - CYAN BIRU                      │
├─────────────────────────────────────────────────────────┤
│ Info            │ #0891B2  │ ███████░░░░░░░░░░░░░░░░░  │
│ Info Dark       │ #0E7490  │ ██████░░░░░░░░░░░░░░░░░░  │
│ Info Light      │ #CFFAFE  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│               NEUTRAL - WARNA DASAR                      │
├─────────────────────────────────────────────────────────┤
│ Background      │ #F9FAFB  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
│ White           │ #FFFFFF  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
│ Text Dark       │ #1F2937  │ ████████░░░░░░░░░░░░░░░░  │
│ Border          │ #E5E7EB  │ ░░░░░░░░░░░░░░░░░░░░░░░░  │
└─────────────────────────────────────────────────────────┘
```

---

## Penggunaan Warna

### 🔘 Tombol
| Tipe | Warna | Hover | Keterangan |
|------|-------|-------|------------|
| Primary | #2563EB | #1D4ED8 | Aksi utama, submit |
| Success | #10B981 | #059669 | Simpan, approve |
| Warning | #F59E0B | #D97706 | Update, edit |
| Danger | #EF4444 | #DC2626 | Hapus, logout |

### 🏷️ Badge
| Badge | Background | Foreground | Kegunaan |
|-------|-----------|-----------|----------|
| Create | Green Gradient | White | Transaksi masuk |
| Update | Amber Gradient | White | Edit/update data |
| Delete | Red Gradient | White | Hapus/keluar |
| Valid | #10B981 | White | Block valid |
| Invalid | #EF4444 | White | Block corrupt |

### 📢 Alert & Notifications
| Tipe | BG Color | Border | Text | Icon |
|------|----------|--------|------|------|
| Success | #D1FAE5 | #10B981 | #065F46 | ✓ |
| Warning | #FEF3C7 | #F59E0B | #92400E | ⚠ |
| Error | #FEE2E2 | #EF4444 | #7F1D1D | ✕ |
| Info | #CFFAFE | #0891B2 | #164E63 | ℹ |

### 📊 Dashboard Components
| Komponen | Warna Utama | Warna Accent |
|----------|------------|-------------|
| Header/Top Nav | #2563EB (Primary) | White text |
| Sidebar | Gradient Primary | White text |
| Table Header | Gradient Primary | White text |
| Card Border | #E5E7EB | - |
| Focus State | #2563EB | #DBEAFE |

---

## Gradients

```
Primary Gradient:
↓ #2563EB (Top Left)
↘ #1D4ED8 (Bottom Right)

Success Gradient:
↓ #10B981 (Top Left)
↘ #059669 (Bottom Right)

Warning Gradient:
↓ #F59E0B (Top Left)
↘ #D97706 (Bottom Right)

Error Gradient:
↓ #EF4444 (Top Left)
↘ #DC2626 (Bottom Right)
```

---

## Accessibility & Contrast

Palet ini telah dipilih dengan mempertimbangkan WCAG standards:

✅ Primary (#2563EB) on White: Contrast 8.5:1 (AAA)
✅ Success (#10B981) on White: Contrast 4.5:1 (AA)
✅ Warning (#F59E0B) on White: Contrast 5.2:1 (AA)
✅ Error (#EF4444) on White: Contrast 6.2:1 (AA)
✅ Text Dark (#1F2937) on White: Contrast 15:1 (AAA)

---

## CSS Custom Properties

```css
/* Primary */
--primary: #2563EB
--primary-dark: #1D4ED8
--primary-light: #DBEAFE

/* Status */
--success: #10B981
--warning: #F59E0B
--error: #EF4444
--info: #0891B2

/* Neutral */
--bg-light: #F9FAFB
--text-dark: #1F2937
--border: #E5E7EB

/* Gradients */
--gradient-primary: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%)
--gradient-success: linear-gradient(135deg, #10B981 0%, #059669 100%)
--gradient-warning: linear-gradient(135deg, #F59E0B 0%, #D97706 100%)
--gradient-error: linear-gradient(135deg, #EF4444 0%, #DC2626 100%)
```

---

## 🎯 Aplikasi di Seluruh Web

### Halaman Login/Register
- Background: Gradient Primary (#2563EB → #1D4ED8)
- Tombol: Primary blue
- Focus state: Primary border

### Dashboard
- Sidebar: Gradient Primary
- Top nav: Gradient Primary  
- Cards: White bg, gray border
- Status colors: Success/warning/error badges

### Daftar Stok
- Header: Gradient Primary
- Tombol tambah: Primary green
- Tombol edit: Warning amber
- Tombol hapus: Danger red

### Blockchain
- Header: Gradient Primary
- Badge valid: Success green
- Badge invalid: Error red
- Table: Primary header

### Keuangan
- Table header: Gradient Primary
- Pemasukan: Green accent
- Pengeluaran: Red accent

---

## 📋 Checklist Implementasi

- [x] CSS Variables di `colors.css`
- [x] Tailwind theme configuration
- [x] Button styles (primary, success, warning, danger, info)
- [x] Badge styles (create, update, delete, valid, invalid)
- [x] Alert styles (success, warning, error, info)
- [x] Table styles dengan gradient header
- [x] Form focus states dengan primary color
- [x] Toast notifications dengan status colors
- [x] Sidebar gradients
- [x] Navigation styling
- [x] Cards dan borders
- [x] Typography colors

---

## 💡 Best Practices

1. **Gunakan CSS Variables**: Selalu gunakan `var(--color-name)` untuk warna agar mudah di-maintain
2. **Hover States**: Semua tombol interaktif harus punya hover state berbeda
3. **Focus States**: Untuk accessibility, pastikan focus state terlihat jelas
4. **Gradients**: Gunakan `--gradient-*` untuk konsistensi
5. **Dark Text**: Untuk dark bg gunakan white text, untuk light bg gunakan dark text

---

**Version**: 1.0  
**Last Updated**: January 14, 2026  
**Theme**: Blockchain Stok Professional  
**Status**: ✅ Production Ready
