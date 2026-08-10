# AI Agent Instructions — cdeVision 7 Block Theme

## Project context
- Custom WordPress theme (cdeVision 7 Block Development).
- Uses ACF blocks with `block.json` registration.
- Theme code lives at repo root; block code in `blocks/`.
- See `AI_PROJECT_OVERVIEW.md` for full theme structure, Sass variables, helper functions, block patterns, and code samples.

## Coding preferences
- Prefer existing theme patterns/helpers before adding new abstractions.
- Keep changes minimal and localized to the requested task.
- Do not refactor unrelated code.
- Preserve backward compatibility with existing theme behavior.

## WordPress/PHP rules
- Follow WordPress template conventions.
- For ACF blocks, match existing folder/file structure and rendering patterns.
- Escape output where appropriate (`esc_html`, `esc_attr`, `wp_kses_post`, etc.).
- Keep templates readable; avoid unnecessary complexity.

## CSS/Sass rules
- Edit Sass source files (`sass/` and `blocks/<name>/_block.scss`), never the compiled CSS.
- Follow existing naming/spacing conventions.
- Avoid duplicate selectors unless front/editor parity is intentional.
- Use existing Sass variables and helper functions (`px-rem()`, `fluid-clamp()`, etc.).

## JavaScript rules
- Match existing project style (jQuery + WP APIs).
- Do not introduce new frameworks unless explicitly requested.
- Keep editor/admin logic separate from front-end logic.

## Response expectations for agents
- Provide exact file paths for changes.
- Show only necessary edits.
- Preserve existing behavior unless explicitly asked to change it.
