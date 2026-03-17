# Customer Management System

## Projektbeschreibung

Dieses Projekt ist eine einfache Web-Applikation für ein Projektadmin-Tool mit Fokus auf Kunden und Adressen. Benutzer können neue Kunden erfassen, mehrere Adressen hinzufügen und Kundendaten für Projekte verfügbar machen.

## Anforderungen

- HTML5, CSS, JavaScript (clientseitig), PHP (serverseitig), MySQL
- Saubere Ordnerstruktur
- Formular für Kundeneingabe
- Validierung client- und serverseitig
- Datenbankspeicherung
- Resultatseite mit Kundentabelle

## Datenbankstruktur

### customers
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- customer_name (VARCHAR(255))
- contact_person (VARCHAR(255))
- email (VARCHAR(255))
- phone (VARCHAR(50))
- customer_class (INT, FOREIGN KEY)
- created_at (TIMESTAMP)

### addresses
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- customer_id (INT, FOREIGN KEY)
- street (VARCHAR(255))
- postal_code (VARCHAR(20))
- city (VARCHAR(255))

### customer_classes
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- class_name (VARCHAR(100))

## Installation

1. MySQL-Datenbank erstellen: `customer_db`
2. Tabellen mit folgendem SQL erstellen:

```sql
CREATE TABLE customer_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL
);

INSERT INTO customer_classes (class_name) VALUES ('Standard'), ('Premium'), ('VIP');

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    customer_class INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_class) REFERENCES customer_classes(id)
);

CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    street VARCHAR(255) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    city VARCHAR(255) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);
```

3. DB-Konfiguration in `php/db.php` anpassen.
4. Server starten (z.B. mit XAMPP oder Docker).
5. Zu `pages/form.php` navigieren.

## Testfälle

1. **Neuer Kunde mit gültigen Daten**
   - Eingabe: Alle Pflichtfelder ausfüllen, gültige E-Mail und Telefon.
   - Erwartung: Kunde wird gespeichert, Redirect zu customers.php mit Erfolgsmeldung.

2. **Formular ohne Pflichtfelder**
   - Eingabe: Formular leer absenden.
   - Erwartung: Fehlermeldungen, Formular zeigt eingegebene Werte.

3. **Ungültige E-Mail**
   - Eingabe: E-Mail ohne @.
   - Erwartung: Validierungsfehler.

## Screenshots

- **Formularseite**: Zeigt das HTML-Formular mit allen Feldern in einem fieldset.
- **Kundentabelle**: Tabelle mit ID, Name, Kontakt, E-Mail, Telefon, Klasse.