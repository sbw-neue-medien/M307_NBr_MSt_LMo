# M307 Praxisarbeit – Registrierungsplattform

**Modul 307 – Interaktive Website mit Formular entwickeln**  
Team: Leandra (leandra-67), Mara (mstudach), Noemi (noemibrunner)

---

## Projektbeschreibung

M307 Praxisarbeit ist eine Webapplikation, über die sich Kundinnen und Kunden registrieren, ihre Daten bearbeiten und verwalten können. Die Applikation besteht aus einem PHP-Backend mit MySQL-Datenbank und einem HTML/CSS/JS-Frontend.

---

## Ordnerstruktur

```
m307-praxisarbeit/
├── index.php                  # Startseite (Home)
├── includes/
│   ├── db.php                 # Datenbankverbindung (einmalig konfiguriert)
│   ├── header.php             # Gemeinsamer Header
│   └── footer.php             # Gemeinsamer Footer
├── views/
│   ├── start.php              # Einstiegsseite mit Auswahl
│   ├── register.php           # Registrierungsformular
│   ├── edit.php               # Daten bearbeiten
│   ├── list.php               # Auflistung aller Registrierungen
│   ├── delete.php             # Datensatz löschen (serverseitig)
│   └── success.php            # Bestätigungsseite
├── public/
│   ├── css/
│   │   └── style.css          # Einziges Stylesheet (alle Styles zentral)
│   └── js/
│       └── validation.js      # Client-seitige Validierung + Zwischenspeicherung
└── sql/
    └── schema.sql             # Datenbankschema, Views, Testdaten
```

---

## Installation (Docker)

### Voraussetzungen

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

### Starten

```bash
# Im Projektordner M307_Praxisarbeit/
docker compose up --build
```

Die Applikation ist danach unter **http://localhost:8080** erreichbar.
Die Datenbank wird beim ersten Start automatisch mit `sql/schema.sql` befüllt.

### Stoppen

```bash
docker compose down
```

Daten bleiben im Volume `db_data` erhalten. Zum vollständigen Zurücksetzen:

```bash
docker compose down -v
```

### Umgebungsvariablen (docker-compose.yml)

| Variable | Wert |
|---|---|
| DB_HOST | db |
| DB_USER | m307user |
| DB_PASS | m307pass |
| DB_NAME | project_admin_tool |

### Lokale Entwicklung ohne Docker

- PHP 8.0+, MySQL 8.0+, Apache
- `sql/schema.sql` importieren
- In `includes/db.php` werden Umgebungsvariablen gelesen; ohne Docker greifen die Fallback-Werte

---

## Funktionen

| Funktion | Datei | Verantwortlich |
|---|---|---|
| Startseite | index.php | Mara |
| Einstiegsseite | views/start.php | Mara |
| Registrierungsformular (FE) | views/register.php | Mara |
| Formularentgegennahme & Speicherung (BE) | views/register.php | Leandra |
| Daten bearbeiten (FE + BE) | views/edit.php | Leandra |
| Auflistung mit Filter & Sortierung | views/list.php | Leandra |
| Datensatz löschen | views/delete.php | Leandra |
| Bestätigungsseite | views/success.php | Leandra |
| DB-Schema & Views | sql/schema.sql | Noemi |
| Testdaten | sql/schema.sql | Noemi |
| JS-Validierung & Zwischenspeicherung | public/js/validation.js | Mara |
| Stylesheet | public/css/style.css | Mara |
| Datenbankverbindung | includes/db.php | Leandra |

---

## Anforderungserfüllung (Checkliste)

| Kriterium | Beschreibung | Erfüllt |
|---|---|---|
| I.4 | Mindestens zwei Benutzer-Webseiten + serverseitige Datei | ✓ |
| I.5 | HTML-Formular mit fieldset, legend, label | ✓ |
| I.6 | input type text, date, email, tel | ✓ |
| I.7 | radio, checkbox, select aus DB-Tabelle | ✓ |
| I.8 | Formulardaten bei Fehler wieder anzeigen (keine Neueingabe nötig) | ✓ |
| I.9 | Formularinhalt in DB-Tabelle gespeichert | ✓ |
| I.10 | Bestätigung + PRG-Prinzip gegen Doppelabsendung | ✓ |
| S.1 | Englische Namen, camelCase/snake_case | ✓ |
| S.2 | Selbsterklärende Namen, Kommentare nur bei kompliziertem Code | ✓ |
| S.3 | SQL Queries, Views, Standards eingehalten | ✓ |
| F.1 | Ordnerstruktur trennt HTML/PHP, CSS, JS | ✓ |
| F.5 | Alle CSS-Styles in einer Datei | ✓ |
| F.6 | Eingebundene PHP-Dateien in separatem Ordner (includes/) | ✓ |
| F.7 | DB-Verbindung in einer einzigen Include-Datei | ✓ |

---

## Testprotokoll

### Test-Case 1: Registrierung mit gültigen Daten

**Vorbedingung:** Datenbank läuft, Testdaten importiert.  
**Schritte:**
1. `/views/register.php` öffnen
2. Vorname: „Test", Nachname: „Person", E-Mail: `test@example.ch`, Geburtsdatum: `01.01.1990`
3. Auf „Speichern" klicken

**Erwartetes Ergebnis:** Weiterleitung auf `/views/success.php`, Eintrag in Tabelle `registrations` vorhanden.  
**Tatsächliches Ergebnis:** ✓ Wie erwartet.

---

### Test-Case 2: Registrierung mit fehlenden Pflichtfeldern

**Vorbedingung:** Formular leer lassen.  
**Schritte:**
1. `/views/register.php` öffnen
2. Ohne Eingabe auf „Speichern" klicken

**Erwartetes Ergebnis:** Fehlermeldungen bei Vorname und Nachname, Formular bleibt ausgefüllt.  
**Tatsächliches Ergebnis:** ✓ Wie erwartet.

---

### Test-Case 3: Daten bearbeiten

**Vorbedingung:** Mindestens ein Eintrag in `registrations`.  
**Schritte:**
1. `/views/list.php` öffnen
2. Bei einem Eintrag auf „Bearbeiten" klicken
3. E-Mail-Adresse ändern
4. Auf „Speichern" klicken

**Erwartetes Ergebnis:** Weiterleitung auf `/views/success.php?action=edit`, Änderung in DB sichtbar.  
**Tatsächliches Ergebnis:** ✓ Wie erwartet.

---

### Test-Case 4: Datensatz löschen

**Vorbedingung:** Mindestens ein Eintrag vorhanden.  
**Schritte:**
1. `/views/list.php` öffnen
2. Bei einem Eintrag auf „Löschen" klicken, Bestätigung annehmen

**Erwartetes Ergebnis:** Eintrag aus Tabelle entfernt, Weiterleitung zurück zur Liste.  
**Tatsächliches Ergebnis:** ✓ Wie erwartet.

---

### Test-Case 5: Filter und Sortierung

**Vorbedingung:** Mehrere Testdaten vorhanden.  
**Schritte:**
1. `/views/list.php` öffnen
2. Namen-Filter: „Anna" eingeben, auf „Filtern" klicken
3. Auf Spaltenüberschrift „Name" klicken

**Erwartetes Ergebnis:** Nur Einträge mit „Anna" im Namen, Sortierung wechselt zwischen A–Z und Z–A.  
**Tatsächliches Ergebnis:** ✓ Wie erwartet.

---

## User Stories

1. Als Kundin möchte ich mich registrieren können, damit ich den Onlineshop nutzen kann.
2. Als Kundin möchte ich meine Daten bearbeiten können, damit sie aktuell bleiben.
3. Als Kundin möchte ich eine Bestätigung erhalten, wenn meine Daten gespeichert wurden.
4. Als Administrator möchte ich alle Registrierungen filtern und sortieren können.
5. Als Administrator möchte ich Einträge löschen können.
