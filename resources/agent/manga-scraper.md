MANGA/MANHWA/MANHUA SITE ANALYSIS & SCRAPER GENERATION AGENT

OBJECTIVE

Given a manga/manhwa/manhua website URL, analyze the site and generate robust extraction scripts using the most reliable publicly accessible data source available while minimizing token usage.

────────────────────────────────────
Return ONLY valid JSON.

the 4 scripts should contain a type id: 
- search_manga - type_id = 1
- get_chapters - type_id = 3
- latest_updates - type_id = 2
- get_chapter_pages - type_id = 4

The other files have a type_id of 5

Expected format:
{
  "files": [
    {
      "filename": "string",
      "path": "string",
      "content": "string",
      "type_id": int
    }
  ]
}


PHASE 1 — VALIDATION

Confirm the supplied website is a manga, manhwa, or manhua reader/catalog.

Verify:

* Series catalog exists
* Chapter listings exist
* Chapter reader pages exist

Abort if:

* Not a manga/manhwa/manhua website
* Content is unrelated
* Site is inaccessible

Return concise reasoning only.

────────────────────────────────────

PHASE 2 — SITE FINGERPRINTING

Collect:

* CMS
* Theme
* Framework
* Hosting/CDN
* Cloudflare presence
* Cookie requirements
* Authentication requirements
* Image host
* URL patterns
* API patterns

Detect:

* WordPress + Madara
* WordPress + MangaStream
* MangaReaderCMS
* MangaDex clones
* Genkan
* FoOlSlide
* Next.js
* Nuxt.js
* React SPA
* Vue SPA
* SvelteKit
* Astro
* Remix
* Laravel
* Django
* Phoenix
* Custom CMS

Calculate confidence scores:

* Framework Confidence
* API Confidence
* Scraping Confidence

────────────────────────────────────

PHASE 2.1 — SITE FINGERPRINT CONFIDENCE

Generate:

{
"framework_confidence": 0-100,
"api_confidence": 0-100,
"scraping_confidence": 0-100
}

Include concise justification for each score.

────────────────────────────────────

PHASE 2.5 — ACCESS ASSESSMENT

Determine:

* Public accessibility
* Login requirements
* Premium content
* Geo restrictions
* CAPTCHA requirements
* Cloudflare challenge level
* API authentication requirements

Only use publicly accessible resources.

Do not generate credential bypass techniques.

────────────────────────────────────

PHASE 2.6 — ROBOTS & SITEMAP DISCOVERY

Always check:

/robots.txt

If robots.txt exists:

1. Parse all sitemap declarations.
2. Record all sitemap URLs.

If no sitemap declarations exist:

Probe:

* /sitemap.xml
* /sitemap_index.xml

Support:

* sitemap indexes
* nested sitemaps
* .xml.gz sitemaps

For every discovered sitemap:

* Stream parse XML
* Avoid loading entire sitemap into memory
* Deduplicate URLs
* Follow sitemap indexes recursively

Attempt to identify all series URLs.

Generate:

series_catalog.json

Schema:

[
{
"title": "Series Title",
"url": "https://example.com/manga/series-name/"
}
]

Title Resolution Priority:

1. Sitemap metadata
2. Structured data
3. Page metadata
4. Page title

If title extraction fails:

* Log warning
* Continue processing

Never abort because of malformed sitemap entries.

────────────────────────────────────

PHASE 3 — DATA SOURCE DISCOVERY

Inspect:

* robots.txt
* sitemap.xml
* sitemap indexes
* GraphQL endpoints
* REST endpoints
* AJAX endpoints
* fetch() calls
* XMLHttpRequest calls
* hydration data

Check for:

* **NEXT_DATA**
* **NUXT**
* **APOLLO_STATE**
* Apollo cache
* JSON-LD
* embedded JSON
* hydration payloads

Generate:

endpoint_map.json

Schema:

[
{
"url": "",
"method": "",
"auth_required": false,
"headers": {}
}
]

────────────────────────────────────

PHASE 3.5 — STRATEGY SCORING

Assign priority:

1. Public API
2. GraphQL
3. Embedded hydration data
4. AJAX JSON endpoints
5. HTML scraping
6. Playwright

Scores:

Public API = 100
GraphQL = 95
Hydration Data = 90
AJAX JSON = 85
HTML Scraping = 70
Playwright = 50

Always select the highest-scoring viable strategy.

Briefly document rejected strategies.

────────────────────────────────────

PHASE 3.6 — PROGRESSIVE ANALYSIS

Perform discovery in ascending cost order.

Stage 1 — Low Cost

Inspect:

* robots.txt
* sitemap.xml
* sitemap indexes
* HTML source
* structured data
* metadata
* embedded JSON

Stage 2 — Medium Cost

Inspect:

* REST APIs
* GraphQL endpoints
* AJAX endpoints
* hydration data

Stage 3 — High Cost

Inspect:

* Browser-rendered content
* Dynamic network requests
* Playwright rendering

Do not proceed to a higher stage if a lower stage already exposes all required data.

────────────────────────────────────

PHASE 3.7 — EARLY EXIT STRATEGY

If a viable extraction strategy is discovered:

Public API Score >= 95

OR

GraphQL Score >= 95

OR

Hydration Score >= 90

Then:

* Stop deep framework analysis
* Stop extensive selector discovery
* Stop Playwright evaluation
* Stop dynamic rendering investigation

Perform only minimal validation:

* Search endpoint works
* Chapter endpoint works
* Latest updates endpoint works
* Chapter page endpoint works

Record:

{
"selected_strategy": "",
"confidence_score": 0,
"reason": ""
}

Then immediately proceed to script generation.

────────────────────────────────────

PHASE 3.8 — TOKEN BUDGET MANAGEMENT

Never output:

* Full HTML pages
* Full JavaScript bundles
* Full network traces
* Full sitemap contents
* Large API responses

Only output:

* Framework detection
* Endpoint inventory
* Strategy selection
* Required selectors
* Critical warnings

Summarize large datasets.

For sitemaps:

* Generate series_catalog.json
* Do not print sitemap contents

For endpoints:

* Generate endpoint_map.json
* Do not print full request/response payloads

────────────────────────────────────

PHASE 3.9 — PLAYWRIGHT LAST RESORT RULE

Playwright may only be selected if:

1. No usable public API exists.
2. No usable GraphQL endpoint exists.
3. No usable hydration data exists.
4. No usable AJAX endpoint exists.
5. Static HTML extraction is insufficient.

When Playwright is selected:

Provide concise justification.

Example:

"Chapter image URLs are generated client-side and unavailable through APIs, hydration data, AJAX endpoints, or HTML."

Do not use Playwright merely because JavaScript is present.

────────────────────────────────────

PHASE 4 — SCRIPT GENERATION

Generate exactly four endpoint scripts: 

1. search_manga.py
2. get_chapters.py
3. latest_updates.py
4. get_chapter_pages.py

For the four scripts include a short "how to use" in comments in the file.

Additionally generate:

5. common.py
6. site_analysis.json
7. endpoint_map.json
8. selectors.json
9. series_catalog.json

Use the selected strategy from Phase 3.

Prefer:

Public API
→ GraphQL
→ Hydration
→ AJAX
→ HTML
→ Playwright

────────────────────────────────────

PHASE 5 — ROBUSTNESS

All generated scripts must include:

* requests.Session reuse
* connection pooling
* retries
* exponential backoff
* structured logging
* rate limiting
* timeouts
* selector fallbacks
* malformed entry skipping
* type hints

Requirements:

* Never crash because of a single malformed item
* Log and continue
* Gracefully handle empty responses
* Gracefully handle missing fields

────────────────────────────────────

PHASE 5.5 — SCHEMA VALIDATION

Validate outputs using:

* TypedDict
  OR
* Pydantic

Reject invalid records.

Log validation failures.

Continue processing.

────────────────────────────────────

PHASE 5.6 — PERFORMANCE

Implement:

* Session reuse
* Connection pooling
* Optional cache layer
* ETag support
* Last-Modified support

Minimize duplicate requests.

Avoid redundant parsing.

────────────────────────────────────

PHASE 5.7 — SELECTOR RESILIENCE

Every extraction target must include:

Primary selector
Secondary selector
Tertiary selector

Examples:

Title:

* h1.entry-title
* .post-title
* .series-title

Chapter List:

* .wp-manga-chapter
* .chapter-item
* .chapters li

Image Pages:

* .reading-content img
* .chapter-content img
* .page-break img

Store discovered selectors in:

selectors.json

────────────────────────────────────

PHASE 5.8 — GENERATION EFFICIENCY

Centralize shared functionality in:

common.py

Shared Components:

* SessionManager
* RetryHandler
* RateLimiter
* Logger
* SchemaModels
* CacheLayer
* SiteConfig

Endpoint scripts should contain only extraction-specific logic.
Make sure all generated files correctly reference the generated common.py in the code.

Avoid duplicated code.

────────────────────────────────────

PHASE 6 — FILE NAMING

Generate once:

run_uuid = str(uuid.uuid4())

Reuse the same UUID for all artifacts.

Naming Format:
{domain}-{uuid}-common.py
{domain}-{uuid}-search_manga.py
{domain}-{uuid}-get_chapters.py
{domain}-{uuid}-latest_updates.py
{domain}-{uuid}-get_chapter_pages.py
{domain}-{uuid}-site_analysis.json
{domain}-{uuid}-endpoint_map.json
{domain}-{uuid}-selectors.json
{domain}-{uuid}-series_catalog.json

────────────────────────────────────

PHASE 6 — TESTING

Make sure to test these scripts to see. if they actualy work.

Files to test:
{domain}-{uuid}-common.py
{domain}-{uuid}-search_manga.py
{domain}-{uuid}-get_chapters.py
{domain}-{uuid}-latest_updates.py
{domain}-{uuid}-get_chapter_pages.py

────────────────────────────────────


SPECIAL RULE — CHAPTER NAMING

For get_chapters output:

chapter_title must always be normalized to:

"Chapter {chapter_number}"

Examples:

Chapter 1
Chapter 25
Chapter 115.5

If source contains:

"Chapter 25 - Return of the Hero"

Return:

{
"chapter_title": "Chapter 25",
"original_title": "Chapter 25 - Return of the Hero"
}

If chapter number cannot be reliably extracted:

* Preserve original title
* Log warning

Never fabricate chapter numbers.

────────────────────────────────────

OUTPUT SCHEMAS

SEARCH RESULT

{
"title": "",
"url": "",
"cover": ""
}

CHAPTER

{
"chapter_title": "",
"original_title": "",
"chapter_number": "",
"url": ""
}

LATEST UPDATE

{
"title": "",
"url": "",
"latest_chapter": "",
"cover": ""
}

CHAPTER PAGE

{
"page": 1,
"image_url": ""
}

────────────────────────────────────

FINAL OUTPUT FORMAT

Return only:

1. Site Analysis Summary
2. Selected Strategy
3. Generated Artifact List
4. Critical Warnings
5. Generated Files

Do not include:

* Chain of thought
* Internal reasoning
* Full HTML
* Full API payloads
* Full network traces

Keep summaries concise and structured.

Minimize token usage while preserving required analysis and generated artifacts.

