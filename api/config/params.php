<?php
return [
    // React dev server runs on :3000 per the design project's vite.config.ts.
    // Override in params-local.php for production (e.g. ['https://fjsti.uz']).
    'cors.allowedOrigins' => ['http://localhost:3000', 'http://localhost:5173'],
    // Where DB-stored root-relative media paths (Post.img, Leader.rasm,
    // Logo.img, uploaded files, etc.) actually live — the legacy frontend/web
    // docroot. Override in params-local.php per environment (e.g. '' in
    // production if the React build is served from the same origin as
    // frontend/web, or the real asset host otherwise).
    'assets.baseUrl' => 'http://frontend.fjsti.local',
];
