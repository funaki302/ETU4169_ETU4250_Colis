<!-- Auto-generated guidance for AI coding agents working on this repository. -->
# Copilot instructions for ETU4169_ETU4250_Colis

Summary
- This is a small PHP MVC-style web project (no tests). The app uses a lightweight routing/runtime shipped under `vendor/flightphp` and a simple in-repo MVC layout under `app/`.

Quick architecture
- Entrypoints: `public/index.php` and `index-simple.php` — HTTP requests are routed here.
- Routing/bootstrap: see `app/config/bootstrap.php` and `app/config/routes.php` for route definitions and global bootstrapping.
- Controllers: `app/controllers/*.php` — extend `app/controllers/Controller.php` and implement action methods that return or include view templates.
- Models: `app/models/model.php` — shared model utilities and DB access patterns live here.
- Views: `app/views/` and `app/views/inc/` — PHP templates; titles and partials (header/footer) are included directly.
- Config & services: `app/config/config.php`, `app/config/services.php` — application configuration and service wiring.
- Middlewares: `app/middlewares/` (example: `SecurityHeadersMiddleware.php`) — middleware is registered during bootstrap.

Important files to read first (order matters)
- `app/config/bootstrap.php` — shows framework initialization and middleware registration.
- `app/config/routes.php` — maps URLs to controller actions and shows URL parameters conventions.
- `app/controllers/Controller.php` and `app/controllers/*` — controller base patterns and common helper usage.
- `app/models/model.php` — DB access patterns, expected return shapes, and any global query helpers.
- `public/index.php` and `index-simple.php` — how requests reach the app and which front-controller is used in different environments.

Project-specific conventions & patterns
- Simple MVC: controllers include views directly (no heavy templating engine). Follow existing view partial patterns (`app/views/inc/header.php`, `footer.php`).
- Route handlers generally call model helpers and then `require` or `include` the view; preserve this synchronous flow.
- Single shared model file: extend or add functions in `app/models/model.php` instead of scattering DB helpers.
- Config values are read from `app/config/config.php` and `services.php` — add new service wiring there for DI-like behavior.
- Assets served from `public/assets/` — modify paths in views accordingly.

Developer workflows (discoverable)
- Install dependencies: run `composer install` (uses `composer.json`).
- DB import: SQL files available at `db.sql` and `Data/data.sql`; `scripts/entreMysql.sh` may be used to import — inspect it for exact commands.
- Launch helpers: `scripts/lancerXamp.sh` and `lancerProjet.sh` are provided; inspect them before running to understand environment assumptions (XAMPP paths, etc.).

Integration & external dependencies
- FlightPHP framework under `vendor/flightphp` handles routing and command utilities.
- Tracy and other helper libs are vendored under `vendor/` — debugging output may use these.
- No external CI/tests detected in repo; assume manual testing via browser and DB.

Editing guidance for AI agents
- Make minimal, localised changes. Preserve existing controller method signatures and view variable names.
- When adding features, update `app/config/routes.php`, create a controller in `app/controllers/`, add model helpers in `app/models/model.php`, and a view in `app/views/`.
- Prefer non-breaking changes: add new services in `app/config/services.php` and registration in `bootstrap.php` rather than large refactors.
- When updating SQL or DB structure, include migration notes and update `db.sql` and `Data/data.sql` consistently.

Examples (copy patterns)
- New route: add an entry in `app/config/routes.php` mapping `/foo` to `FooController@index`.
- Controller example: create `app/controllers/FooController.php` extending `Controller.php`; call `Model::someHelper()` then `require 'app/views/foo.php'`.

What not to assume
- Do not assume a Docker or PHPUnit setup exists; none found. Ask before adding CI or test scaffolding.
- Do not assume environment variables without checking `app/config/config.php` or `services.php`.

If something's unclear
- Point to the exact file(s) and line ranges you inspected and request clarification. The maintainer can provide runtime instructions, database credentials, or preferred deployment steps.

Next step
- After edits, run `composer dump-autoload` and use the provided scripts to start the local environment and import SQL for manual verification.

-- End of guidance
