# TVIP Product Design Context

## Product and Source

- Product: TVIP company profile and candidate-facing career portal.
- Audience: Indonesian visitors and job candidates, primarily on mobile and desktop web.
- Visual source of truth: Figma file `yn2rF2dwEivl7pQow9EBXp` and `docs/DESIGN-FIGMA-KARIR-V2.md`.
- Business source of truth: `docs/PRD-KARIR-V2.md`.
- Existing Home identity remains canonical; Career extends it rather than replacing it.

## North Star

Clear, credible corporate recruitment: strong TVIP blue surfaces, restrained elevation, legible Inter typography, and direct task-oriented interactions. The interface should feel established and trustworthy, not decorative or template-like.

## Runtime Token Ownership

`tailwind.config.js` is the runtime token adapter. It maps the documented Figma values to the `tvip-*` color, radius, shadow, gradient, width, and layer utilities. `resources/css/app.css` owns shared control, container, focus, scrollbar, wave, and reduced-motion behavior. Blade components consume those mapped tokens; screen-local raw values are limited to documented Figma exceptions.

## Visual Rules

- Brand: `#0f4c81`; dark brand: `#0a3254`; light brand: `#1a6ab3`.
- On-dark muted copy uses `#bedbff`; the hiring indicator uses `#ffd11a`.
- Main heading: `#101828`; body: `#4a5565`; muted: `#6a7282`.
- Typography: Inter 400/500/600/700 with system sans-serif fallback.
- Desktop content width: 1280px including responsive horizontal padding.
- Cards use 16px radius and low elevation; CTA/auth use 24px radius and higher elevation.
- Primary actions use TVIP solid/gradient blue. Danger color is reserved for errors or destructive actions.
- Career grid uses three columns and 24px gaps on wide screens, two on tablet, one on mobile.
- Job media reserves 208px height; drawer width is 600px on desktop and full width on mobile.

## Interaction Rules

- Links navigate; buttons perform actions. Every enabled control has hover and visible focus.
- Search/filter/page state is represented in URL query parameters. Native select popups are intentionally platform-owned.
- Modal and drawer layers lock background scroll, support Escape, trap focus, and keep internal content scrollable.
- Forms use app-owned inline validation (`novalidate`), accessible labels/errors, masked passwords, and stable disabled/busy buttons.
- Global scrollbars remain visible, tokenized, and usable in forced-colors mode.
- Target accessibility is WCAG 2.2 AA; motion is optional and respects reduced-motion.

## Version Boundaries

- V2: public catalog, search/filter/pagination, poster/detail layers, account register/login/logout, authenticated hero, honest disabled previews for apply/send CV.
- V3: candidate profile, photo/CV/portfolio, application and talent-pool submission.
- V4: HR/admin panel, permissions, application status workflow, and document access.

## Anti-References

- Do not introduce a parallel Career-only brand or duplicate token set.
- Do not enable controls whose backend behavior is deferred.
- Do not use browser alert/confirm/prompt or non-semantic click targets.
- Do not expose candidate documents through public URLs when V3 is implemented.
- Do not hide scrollbars or clip long drawer/form content.
