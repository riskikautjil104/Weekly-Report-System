---
name: Executive Precision
colors:
  surface: '#faf8ff'
  surface-dim: '#d8d9e5'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3ff'
  surface-container: '#ecedf9'
  surface-container-high: '#e6e7f3'
  surface-container-highest: '#e1e2ee'
  on-surface: '#191b24'
  on-surface-variant: '#424655'
  inverse-surface: '#2d3039'
  inverse-on-surface: '#eff0fc'
  outline: '#727787'
  outline-variant: '#c2c6d8'
  surface-tint: '#0057ce'
  primary: '#0057cd'
  on-primary: '#ffffff'
  primary-container: '#0d6efd'
  on-primary-container: '#ffffff'
  inverse-primary: '#b1c5ff'
  secondary: '#575f67'
  on-secondary: '#ffffff'
  secondary-container: '#d8e1ea'
  on-secondary-container: '#5b646b'
  tertiary: '#a63b00'
  on-tertiary: '#ffffff'
  tertiary-container: '#cf4b00'
  on-tertiary-container: '#ffffff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2ff'
  primary-fixed-dim: '#b1c5ff'
  on-primary-fixed: '#001946'
  on-primary-fixed-variant: '#00419e'
  secondary-fixed: '#dbe4ed'
  secondary-fixed-dim: '#bfc8d0'
  on-secondary-fixed: '#141d23'
  on-secondary-fixed-variant: '#3f484f'
  tertiary-fixed: '#ffdbce'
  tertiary-fixed-dim: '#ffb599'
  on-tertiary-fixed: '#370e00'
  on-tertiary-fixed-variant: '#7f2b00'
  background: '#faf8ff'
  on-background: '#191b24'
  surface-variant: '#e1e2ee'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-base:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  unit: 4px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 32px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 24px
---
## Brand & Style

The brand personality is **disciplined, organized, and modern**. This design system prioritizes high information density without sacrificing clarity, catering to corporate stakeholders who require immediate insights into weekly performance.

The design style is **Corporate / Modern**. It utilizes a systematic approach to hierarchy, leveraging ample whitespace and a rigid grid to convey reliability. The aesthetic is "invisible" by design—focusing entirely on data legibility and task efficiency. It avoids unnecessary decoration, opting for functional clarity and a sense of institutional stability.

## Colors

The palette is anchored by a professional blue to signify trust and authority.

- **Primary:** Used for actionable items, active states, and primary branding.
- **Surface:** A clean white background is used for content areas, while a very light neutral gray is reserved for page backgrounds to provide subtle contrast for cards.
- **Status Colors:** These are strictly reserved for performance indicators:
  - **Success (Green):** Indicates 'Selesai' (Completed) tasks.
  - **Warning (Yellow/Orange):** Indicates 'Progress' (In-Progress) states.
  - **Danger (Red):** Indicates 'Kendala' (Issues/Blockers).

## Typography

This design system utilizes **Inter** for all text roles. Inter’s tall x-height and neutral grotesque style ensure maximum readability in data-heavy tables and complex forms.

- **Headlines:** Use Semi-Bold (600) or Bold (700) weights with slight negative letter spacing to create a grounded, authoritative feel.
- **Body Text:** Standardized at 16px for general reading and 14px for dense data displays.
- **Labels:** Small, all-caps labels with medium weight are used for table headers and form field titles to differentiate from user input.

## Layout & Spacing

The layout follows a **Fixed Grid** model on desktop, centered within a 1280px container to prevent eye strain on wide monitors. It transitions to a fluid model on mobile devices.

- **Grid:** A 12-column system is used for dashboard layouts.
- **Spacing Rhythm:** Based on a 4px baseline unit.
- **Margins:** Use 32px for desktop page margins to create a spacious, professional air.
- **Gutters:** Standard 24px gutters between dashboard cards and table columns ensure distinct separation of data points.

## Elevation & Depth

To maintain a clean and professional look, depth is communicated through **low-contrast outlines** rather than heavy shadows.

- **Level 0 (Background):** Neutral light gray (#F8F9FA).
- **Level 1 (Cards/Tables):** Pure white background with a 1px solid border (#DEE2E6). No shadow is applied to maintain a "flat-modern" aesthetic.
- **Level 2 (Dropdowns/Modals):** Pure white background with a thin border and a soft, neutral ambient shadow (Offset 0 4px, Blur 12px, Opacity 5%) to indicate temporary overlay.

## Shapes

The shape language is **Soft**. A 0.25rem (4px) corner radius is applied to standard UI elements like input fields, buttons, and badges. Larger components like dashboard cards utilize a 0.5rem (8px) radius. This subtle rounding softens the professional "stiffness" while maintaining a precise, engineering-led feel.

## Components

### Dashboard Cards

Cards are the primary container for high-level metrics. They should feature a top-aligned label, a large display value, and a bottom-aligned status indicator or trend line. Use a white fill and a subtle light gray border.

### Data Tables

Tables are the backbone of the reporting system.

- **Headers:** Light gray background (#F8F9FA) with uppercase labels.
- **Rows:** Minimum height of 48px with 1px horizontal borders. Use zebra striping only if the table exceeds 10 columns.
- **Alignment:** Text is left-aligned; numerical data is right-aligned to assist in visual comparison.

### Status Badges

Badges are used for the Selesai/Progress/Kendala states.

- **Selesai:** Green background (10% opacity) with dark green text.
- **Progress:** Yellow background (15% opacity) with dark amber text.
- **Kendala:** Red background (10% opacity) with dark red text.
- **Shape:** Use "rounded-lg" (8px) for badges to make them distinct from square-edged buttons.

### Input Forms

Forms should follow a vertical stack pattern.

- **Fields:** 1px border (#CED4DA), 12px vertical padding. Focus state uses a 1px primary blue border with a subtle 2px blue glow (ring).
- **Buttons:** Primary buttons are solid Blue (#0D6EFD) with white text. Secondary buttons are outlined.

### Navigation

A sidebar navigation is recommended for the Weekly Report System to allow for quick switching between departments or weeks. Use high-contrast active states (Primary Blue) to clearly indicate the current view.
