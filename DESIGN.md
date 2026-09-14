# TVIP Product Design Context

## Product and Source

- Product: TVIP company profile and candidate-facing career portal.
- Audience: Indonesian visitors and job candidates, primarily on mobile and desktop web.
- Visual source of truth: Figma file `yn2rF2dwEivl7pQow9EBXp`, `docs/DESIGN-FIGMA-KARIR-V2.md`, and `docs/DESIGN-FIGMA-KARIR-V3.md`.
- Business source of truth: `docs/PRD-KARIR-V2.md` and `docs/PRD-KARIR-V3.md`.
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
- Candidate pages use a 1024px shell, 960px white content card, 14px card radius, 32px desktop padding, and natural document scrolling.
- Candidate step status uses brand blue for current, `#00c950` for complete, and divider gray for upcoming. Informational, success, and waiting states use the mapped `tvip-info-*`, `tvip-success-*`, and `tvip-warning-*` tokens.

## Interaction Rules

- Links navigate; buttons perform actions. Every enabled control has hover and visible focus.
- Search/filter/page state is represented in URL query parameters. Native select popups are intentionally platform-owned.
- Modal and drawer layers lock background scroll, support Escape, trap focus, and keep internal content scrollable.
- Forms use app-owned inline validation (`novalidate`), accessible labels/errors, masked passwords, and stable disabled/busy buttons.
- Candidate forms persist one server-confirmed step at a time. Profile completion and application submission are pessimistic mutations; application keys prevent duplicate submission.
- Candidate upload controls always expose a file-picker action and accepted format/size copy. Uploaded files are private and accessible only through an authorized controller.
- Native select, date, and month inputs are an intentional platform-owned choice for this Blade application; exact popup geometry is outside the authored design contract.
- Complete profiles open in read-only summary mode. Editing is entered through explicit per-section actions, and unsaved values are discarded by normal navigation rather than silently auto-saved.
- Global scrollbars remain visible, tokenized, and usable in forced-colors mode.
- Target accessibility is WCAG 2.2 AA; motion is optional and respects reduced-motion.

## Version Boundaries

- V2: public catalog, search/filter/pagination, poster/detail layers, account register/login/logout, and authenticated hero.
- V3: four-step candidate profile, private photo/CV/education/employment documents, read-only profile summary/edit flow, application and talent-pool submission, duplicate prevention, and candidate-owned history.
- V4: HR/admin panel, permissions, application status workflow, and document access.

## Anti-References

- Do not introduce a parallel Career-only brand or duplicate token set.
- Do not enable HR processing controls whose backend behavior is deferred to V4.
- Do not use browser alert/confirm/prompt or non-semantic click targets.
- Do not expose candidate documents through public storage URLs or include full NIK in application snapshots.
- Do not claim uploaded documents are malware-free while scan status remains pending.
- Do not hide scrollbars or clip long drawer/form content.
