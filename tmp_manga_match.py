import csv, re, unicodedata
from difflib import SequenceMatcher

def normalize(s):
    s = s.strip()
    s = unicodedata.normalize('NFKD', s)
    s = s.casefold()
    s = re.sub(r"[^0-9a-z]+", ' ', s)
    s = re.sub(r'\s+', ' ', s).strip()
    return s

with open('manga_data/data.csv', newline='', encoding='utf-8') as f:
    data_rows = list(csv.DictReader(f))
with open('manga_data/MAL-manga.csv', newline='', encoding='utf-8') as f:
    mal_rows = list(csv.DictReader(f))

norm_data = {normalize(r['title']): r for r in data_rows}
norm_mal = {normalize(r['Title']): r for r in mal_rows}

exact = set(norm_data) & set(norm_mal)
print('data rows', len(data_rows), 'MAL rows', len(mal_rows), 'exact matches', len(exact))
print('exact sample', list(exact)[:20])

unmatched = [r['title'] for r in data_rows if normalize(r['title']) not in exact]
for title in unmatched[:20]:
    norm = normalize(title)
    best = max(
        ((SequenceMatcher(None, norm, nm).ratio(), title, orig)
         for nm, orig in [(nm, r['Title']) for nm, r in norm_mal.items()]),
        key=lambda x: x[0]
    )
    print(f'{best[0]:.3f}: {title} -> {best[2]}')
