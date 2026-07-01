import csv, re, unicodedata
from pathlib import Path

root = Path('/Users/adriaangiel/code/mymangashelf')
source_a = root / 'manga_data' / 'data.csv'
source_b = root / 'manga_data' / 'MAL-manga.csv'
merged_path = root / 'manga_data' / 'merged.csv'


def normalize(s):
    s = (s or '').strip()
    s = unicodedata.normalize('NFKD', s)
    s = s.casefold()
    s = re.sub(r'[^0-9a-z]+', ' ', s)
    s = re.sub(r'\s+', ' ', s).strip()
    return s

with source_a.open(newline='', encoding='utf-8') as f:
    data_rows = list(csv.DictReader(f))
with source_b.open(newline='', encoding='utf-8') as f:
    mal_rows = list(csv.DictReader(f))

mal_index = {}
for r in mal_rows:
    key = normalize(r.get('Title', ''))
    if not key:
        continue
    if key not in mal_index:
        mal_index[key] = r

fieldnames = ['title', 'description', 'rating', 'year', 'tags', 'cover', 'mal_Title', 'Rank', 'Type', 'Volumes', 'Published', 'Members', 'page_url', 'image_url', 'Score']
merged_rows = []
for r in data_rows:
    key = normalize(r.get('title', ''))
    if not key:
        continue
    mal = mal_index.get(key)
    if mal is None:
        continue
    merged_rows.append({
        'title': r.get('title', ''),
        'description': r.get('description', ''),
        'rating': r.get('rating', ''),
        'year': r.get('year', ''),
        'tags': r.get('tags', ''),
        'cover': r.get('cover', ''),
        'mal_Title': mal.get('Title', ''),
        'Rank': mal.get('Rank', ''),
        'Type': mal.get('Type', ''),
        'Volumes': mal.get('Volumes', ''),
        'Published': mal.get('Published', ''),
        'Members': mal.get('Members', ''),
        'page_url': mal.get('page_url', ''),
        'image_url': mal.get('image_url', ''),
        'Score': mal.get('Score', ''),
    })

with merged_path.open('w', newline='', encoding='utf-8') as f:
    writer = csv.DictWriter(f, fieldnames=fieldnames)
    writer.writeheader()
    writer.writerows(merged_rows)

print('merged rows', len(merged_rows))
print('merged file', merged_path)
