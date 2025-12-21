# Theme Documentation - Warung Bali Sangeh Order System

## 📋 Table of Contents
1. [Color Palette](#color-palette)
2. [Typography](#typography)
3. [Component Styles](#component-styles)
4. [Spacing & Layout](#spacing--layout)
5. [Interactive Elements](#interactive-elements)

---

## 🎨 Color Palette

### Primary Colors

#### Orange (Brand Primary)
- **Primary Orange**: `#f05a28` 
  - Usage: Primary buttons, active states, brand elements
  - Hover: `#d94a1c`
  - Example: "Continue to Payment", "Pay", "Sign In" buttons

#### Red (Accent)
- **Red**: `#ef4444` / `red-500` (Tailwind)
  - Usage: Active nav items, add buttons, important accents
  - Border: `border-red-500`, `border-red-600`
  - Text: `text-red-600`, `text-red-500`

### Background Colors

#### Neutral Backgrounds
- **Primary Background**: `#ffffff` (white)
  - Usage: Main container, cards, modals
  
- **Secondary Background**: `#f3f4f6` / `gray-100`
  - Usage: Page background, section separators
  
- **Tertiary Background**: `#f9fafb` / `gray-50`
  - Usage: Subtle backgrounds, content areas

#### Accent Backgrounds
- **Orange Light**: `bg-orange-50` / `#fff7ed`
  - Usage: Order type badges, highlights, step indicators
  - Border: `border-orange-100`, `border-orange-400`

- **Warning Background**: `#fff8de`
  - Usage: Warning boxes, important notices

- **Yellow Light**: `bg-yellow-100`
  - Usage: Icon backgrounds in payment methods

- **Green Light**: `bg-green-100`
  - Usage: Cash icon backgrounds

### Text Colors

#### Primary Text
- **Dark Gray**: `#1b1b18` / `gray-900`
  - Usage: Headings, primary text, important labels
  
- **Medium Gray**: `#374151` / `gray-700`
  - Usage: Body text, secondary headings
  
- **Gray**: `#6b7280` / `gray-600`
  - Usage: Supporting text, labels

- **Light Gray**: `#9ca3af` / `gray-500` / `#706f6c`
  - Usage: Placeholder text, disabled states
  
- **Very Light Gray**: `#d1d5db` / `gray-400`
  - Usage: Subtle text, icons

#### Colored Text
- **Orange Text**: `text-orange-500`, `text-orange-600`
  - Usage: Links, active states, emphasis
  
- **Red Text**: `text-red-500`, `text-red-600`
  - Usage: Errors, required fields, active nav

- **Green Text**: `text-green-500`, `text-green-600`
  - Usage: Success states, checkmarks

### Border Colors

- **Light Border**: `border-gray-100` / `#f3f4f6`
  - Usage: Subtle dividers, card borders
  
- **Medium Border**: `border-gray-200` / `#e5e7eb`
  - Usage: Input fields, section dividers
  
- **Dark Border**: `border-gray-300` / `#d1d5db`
  - Usage: Stronger dividers

- **Orange Border**: `border-orange-100`, `border-orange-400`, `border-orange-500`
  - Usage: Active states, highlighted sections

- **Red Border**: `border-red-500`
  - Usage: Add buttons, active selections, QR corners

### Semantic Colors

#### Success
- **Green**: `#10b981` / `green-500`
  - Background: `bg-green-500`, `bg-green-600`
  - Text: `text-green-600`
  - Usage: Checkmarks, confirmation states

#### Warning
- **Orange**: `#f59e0b` / `orange-500`
  - Text: `text-orange-600`
  - Usage: Warnings, alerts

#### Error/Required
- **Red**: `#ef4444` / `red-500`
  - Text: `text-red-500`
  - Usage: Required field indicators, errors

---

## 🔤 Typography

### Font Family
- **Primary Font**: `'Outfit', sans-serif`
  - Weights used: 300, 400, 500, 600, 700
  - Import: `https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap`

### Font Sizes

#### Headings
- **Large Heading**: `text-3xl` (30px) - Timer displays
- **Page Title**: `text-lg` (18px) - Header titles
- **Section Heading**: `text-lg` / `font-bold` - Section titles
- **Card Title**: `text-sm` / `font-bold` - Menu item names

#### Body Text
- **Regular**: `text-sm` (14px) - Most body text
- **Small**: `text-xs` (12px) - Supporting text, labels
- **Large Price**: `text-xl` / `text-2xl` (20px/24px) - Total amounts

### Font Weights
- **Light**: `font-light` / 300 - Rarely used
- **Regular**: `font-normal` / 400 - Default text
- **Medium**: `font-medium` / 500 - Emphasized text
- **Semibold**: `font-semibold` / 600 - Sub-headings
- **Bold**: `font-bold` / 700 - Headings, important text

---

## 🧩 Component Styles

### Buttons

#### Primary Button
```css
Background: #f05a28
Hover: #d94a1c
Text: white
Padding: py-3 px-6 (12px 24px)
Border Radius: rounded-xl (12px) / rounded-lg (8px)
Font: font-bold
Shadow: shadow-md
Transition: transition-all, active:scale-95
```

#### Secondary Button (Outline)
```css
Background: white
Border: border-orange-400 / border-red-500
Text: text-orange-500 / text-red-500
Padding: py-2 px-4
Border Radius: rounded-full / rounded-lg
Font: font-semibold
Hover: bg-orange-50 / bg-red-50
```

#### Icon Button
```css
Background: white / bg-gray-100
Padding: p-1 / p-2
Border Radius: rounded-full
Hover: bg-gray-100
```

### Cards

#### Standard Card
```css
Background: white
Border: border border-gray-100
Border Radius: rounded-xl (12px)
Padding: p-3 / p-4
Shadow: shadow-sm
```

#### Highlighted Card
```css
Background: bg-orange-50
Border: border border-orange-100 / border-orange-400
Border Radius: rounded-lg / rounded-xl
Padding: px-4 py-2
```

### Input Fields

#### Text Input
```css
Background: white
Border: border border-gray-300
Border Radius: rounded-xl (12px)
Padding: pl-10 pr-3 py-2.5 (with icon) / px-4 py-3
Focus: border-orange-500, ring-1 ring-orange-500
Placeholder: text-gray-400
Text: text-gray-900
```

#### Textarea
```css
Background: white
Border: border border-gray-300
Border Radius: rounded-lg
Padding: p-3
Focus: ring-2 ring-orange-500, border-orange-500
```

### Badges & Labels

#### Order Type Badge
```css
Background: bg-orange-50
Border: border border-orange-400
Border Radius: rounded-lg
Padding: px-4 py-2
Text: text-sm font-medium
```

#### Count Badge
```css
Background: white (on orange) / bg-orange-500 (on white)
Text: text-[#f05a28] / text-white
Size: w-5 h-5
Border Radius: rounded-full
Font: text-xs font-bold
Position: absolute -top-2 -right-2
```

### Navigation

#### Active Nav Item
```css
Text: text-red-600
Border: border-b-2 border-red-600
Font: font-bold
Padding: pb-2
```

#### Inactive Nav Item
```css
Text: text-gray-500
Font: font-semibold
Hover: text-gray-900
Padding: pb-2
```

### Modals

#### Modal Overlay
```css
Background: bg-black bg-opacity-50
Position: fixed inset-0
Z-index: z-[60]
Transition: opacity duration-300
```

#### Modal Container
```css
Background: white
Border Radius: rounded-t-2xl / rounded-2xl
Padding: p-4 / p-6
Shadow: shadow-lg / shadow-2xl
Max Height: max-h-[90vh]
Position: fixed bottom-0 (bottom sheet) / centered
```

---

## 📐 Spacing & Layout

### Container
```css
Max Width: max-w-[500px] (mobile-first design)
Background: white
Shadow: shadow-2xl
Margin: mx-auto
```

### Common Spacing
- **Extra Small**: `gap-1`, `space-y-1` (4px)
- **Small**: `gap-2`, `space-y-2` (8px)
- **Medium**: `gap-3`, `space-y-3` (12px)
- **Regular**: `gap-4`, `space-y-4` (16px)
- **Large**: `gap-6`, `space-y-6` (24px)
- **Extra Large**: `gap-8`, `space-y-8` (32px)

### Padding
- **Tight**: `p-1` / `p-2` (4px / 8px)
- **Standard**: `p-3` / `p-4` (12px / 16px)
- **Comfortable**: `p-6` (24px)
- **Spacious**: `p-8` (32px)

### Border Radius
- **Small**: `rounded` (4px)
- **Medium**: `rounded-lg` (8px)
- **Large**: `rounded-xl` (12px)
- **Extra Large**: `rounded-2xl` (16px)
- **Circle**: `rounded-full`

---

## 🎯 Interactive Elements

### Hover States
```css
Buttons: hover:bg-[#d94a1c] (darker shade)
Cards: hover:bg-gray-50
Icons: hover:bg-gray-100
Links: hover:text-gray-900
Border: hover:border-gray-300
```

### Active States
```css
Buttons: active:scale-95
Selected: border-orange-500, bg-orange-50, text-orange-600
Checkmark: bg-green-500 rounded-full with white check icon
```

### Focus States
```css
Inputs: focus:border-orange-500, focus:ring-1 ring-orange-500
Outline: focus:outline-none (custom focus styles used)
```

### Transitions
```css
Standard: transition-colors
All Properties: transition-all
Duration: duration-200 / duration-300
Transform: active:scale-95
Opacity: opacity-0 / opacity-100 with duration-300
```

### Disabled States
```css
Background: bg-gray-200 / bg-gray-300
Text: text-gray-500
Cursor: cursor-not-allowed
Opacity: Reduced (implied by color)
```

---

## 📱 Responsive Design

### Breakpoints
- **Mobile First**: Default styles for mobile (< 500px)
- **Tablet**: Uses same styles with max-w-[500px] container
- **Desktop**: Uses same styles with max-w-[500px] container (mobile-optimized experience)

### Mobile Optimizations
- Fixed sticky headers: `sticky top-0 z-50`
- Bottom sheets for modals: `fixed bottom-0`
- Horizontal scrolling sections: `overflow-x-auto no-scrollbar`
- Full-width buttons on mobile
- Touch-friendly sizes (min 44px tap targets)

---

## 🎨 Shadow System

### Elevation Levels
- **Level 1**: `shadow-sm` - Subtle cards
- **Level 2**: `shadow-md` - Buttons, prominent cards
- **Level 3**: `shadow-lg` - Modals
- **Level 4**: `shadow-2xl` - Main container, overlays
- **Custom**: `shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]` - Bottom bar

---

## 🔧 Special Effects

### Scrollbar Hiding
```css
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
```

### Glass/Blur Effects
```css
backdrop-blur: blur-sm
overlay: bg-white/30
```

### Border Styles
- **Solid**: `border`
- **Dashed**: `border-dashed` (used in payment details)

---

## 📝 Notes

### Design System Philosophy
- **Mobile-First**: Entire design optimized for mobile devices
- **Consistent Orange Brand**: `#f05a28` as primary brand color
- **Clean & Modern**: Heavy use of white space and rounded corners
- **Touch-Friendly**: Large tap targets, clear spacing
- **Visual Feedback**: Active states, hover effects, transitions

### Color Accessibility
- Text contrast ratios meet WCAG AA standards
- Dark text on light backgrounds
- Orange primary color reserved for important actions
- Gray scale for hierarchy

### Common Patterns
1. **Page Header**: White sticky header with back button and centered title
2. **Order Type Badge**: Orange background with border
3. **Bottom Action Bar**: Fixed white bar with shadow and action button
4. **Cards**: White with subtle border and shadow
5. **Icons**: Heroicons (outline style) from `xmlns="http://www.w3.org/2000/svg"`

---

## 🎯 Key Components Color Usage

| Component | Background | Text | Border | Accent |
|-----------|-----------|------|--------|--------|
| Primary Button | #f05a28 | white | - | shadow-md |
| Secondary Button | white | #f05a28 | border-orange-400 | - |
| Add Button | white | red-500 | border-red-500 | - |
| Active Nav | - | red-600 | border-b-2 red-600 | - |
| Order Badge | orange-50 | gray-900 | orange-400 | - |
| Header | white | gray-800 | border-b gray-100 | - |
| Menu Card | white | gray-800 | gray-100 | shadow-sm |
| Price | - | orange-600 (total) / gray-900 | - | - |
| Input Field | white | gray-900 | gray-300 | focus: orange-500 |
| Modal Overlay | black/50 | - | - | - |
| Success State | green-500 | white | - | - |
| Warning Box | #fff8de | gray-800 | - | orange icon |

---

*Last Updated: 2025-12-19*
*Application: Warung Bali Sangeh Order System*
*Framework: Tailwind CSS v4.0.7*
