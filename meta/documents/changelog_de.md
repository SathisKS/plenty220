# Informationen zum Novalnet Release


## v2.2.0 (2021-09-28)

### Neu

- Funktionen "Zahlungsmethode ändern" und "Zahlung vornehmen" für fehlgeschlagene und abgelehnte Transaktionen

## v2.1.1 (2021-09-08)

### Behoben

- Fehlermeldungsanzeige für abgelehnte Transaktionen

## v2.1.0 (2021-08-20)

### Neu

- Einführung von 3D Secure Payment für Kreditkarten in Ländern außerhalb der EU
- Zahlungsziel für Vorkasse implementiert

### Verbessert

- Der Bestellstatus wurde gemäß der standardmäßigen Struktur des Shops optimiert
- Beschreibung der Zahlungsart Kredit-/Debitkarte
- Semantische Versionierungsstandards in der plugin.json optimiert
- Name und Logo der Zahlungsmethode Barzahlen

### Behoben

- Der Prozentsatz des Zahlungsstatus wird während der Events "Erstattung durch Gutschrift" und "Statusänderung" nicht reduziert
- Während des ursprünglichen Bestellstatus werden Novalnet-Transaktionsdetails im Rechnungs-PDF angezeigt
- Doppelbuchungen sind bei Zahlungsarten mit Weiterleitung ausgeschlossen

### Entfernt

- Konfiguration des Proxyservers
- Konfiguration der Gateway-Zeitüberschreitung
- Konfiguration der Partner-ID
- BCC-Feld für Webhook-E-Mail-Benachrichtigung

## v2.0.14 (2021-06-21)

### Behoben

- IP-Adresse aktualisiert, um die tatsächliche IP des Novalnet-Servers zu erhalten
- Callbacks vom Novalnet-Server an den Shop zu Folge-Transaktionen und Kommunikationsfehlern

## v2.0.13 (2020-06-03)

### Erweitert

- Standardmäßige Bestellgenerierung vor der Ausführung von Zahlungsaufrufen für karten- und kontenbasierte Zahlungen. Damit soll vermieden werden, dass Bestellungen während der Bezahlung verloren gehen, wenn der Browser des Endkunden geschlossen wird oder wenn es während des Bezahlvorgangs zu Sitzungs-Timeouts o.ä. kommt

## v2.0.12 (2020-04-29)

### Erweitert

- Grund für Gutschriften per API übertragen (für Kreditkarte, SEPA-Lastschrift, SEPA-Lastschrift mit Zahlungsgarantie, Rechnung, Rechnung mit Zahlungsgarantie, Sofortüberweisung, iDEAL, PayPal, eps, giropay und Przelewy24)

## v2.0.11 (2020-04-09)

### Behoben

- Überprüfung der Felder Vorname und Nachname auf der Checkout-Seite angepasst
- Fehler bei der Anzeige der Transaktionsdetails in PDF-Rechnung und Bestellhistorie für Rechnung, Rechnung mit Zahlungsgarantie und Vorkasse
- Fehler bei der Anzeige des Transaktionsbetrags bei On-hold-Bestellungen per Rechnung mit Zahlungsgarantie
- Fehler bei der Benachrichtigung zur Aktualisierung des Fälligkeitsdatums im Shop bei On-hold-Bestellungen per Rechnung, Rechnung mit Zahlungsgarantie und Vorkasse
- Fehler bei der Anzeige des Brutto-Warenkorbwerts

## v2.0.10 (2019-10-31)

### Behoben

- Zahlungs-Plugin angepasst, um die Erstellung doppelter Einträge in der Bestellhistorie für dieselbe TID zu vermeiden

### Neu

- Das Geburtsdatumsfeld auf der Checkout-Seite wurde angepasst

## v2.0.9 (2019-09-13)

### Behoben

- Fehler bei der Anzeige der Novalnet-Überweisungsdetails im Rechnungs-PDF mithilfe der Funktion “OrderPdfGeneration”
- Fehler beim Bestätigen von Transaktionen durch den Händler bei Rechnung, Rechnung mit Zahlungsgarantie und Vorkasse

## v2.0.8 (2019-08-30)

### Neu

- Anzeige der Novalnet-Überweisungsdetails im Rechnungs-PDF mithilfe der Funktion “OrderPdfGeneration”

### Entfernt

- Unbenutzte Altdateien früherer Versionen

## v2.0.7 (2019-06-24)

### Behoben

- Verhinderung von Doppelbuchungen durch den Endkunden

## v2.0.6 (2019-05-24)

### Behoben

- Hinzugefügt IO in plugin.json

## v2.0.5 (2019-05-14)

### Verbessert

- Bei Rechnung, Rechnung mit Zahlungsgarantie und Vorkasse wird für On-hold-Transaktionen die Bankverbindung von Novalnet auf der Rechnung angezeigt

## v2.0.4 (2019-04-24)

### Behoben

- Anzeige der Zahlungsarten nur für vordefinierte Länder

### Neu

- Die Zahlungsart wird dem Endkunden abhängig von Mindest- und Höchstbestellwert angezeigt

### Verbessert

- Das Novalnet-Zahlungsmodul wurde ausgiebig  getestet und entsprechend optimiert

## v2.0.3 (2019-04-02)

### Verbessert

- Das Novalnet-Zahlungsmodul wurde ausgiebig  getestet und entsprechend optimiert

## v2.0.2 (2019-03-19)

### Neu

- Auslösen der Autorisierung und des Einzugs für On-hold-Zahlungen (Kreditkarte, SEPA-Lastschrift, SEPA-Lastschrift mit Zahlungsgarantie, Kauf auf Rechnung, Rechnung mit Zahlungsgarantie und PayPal)
- Auslösen einer Rückerstattung für Zahlungen (Kreditkarte, SEPA-Lastschrift, SEPA-Lastschrift mit Zahlungsgarantie, Rechnung mit Zahlungsgarantie, Sofortüberweisung, iDeal, PayPal, eps, giropay und Przelewy24)
- Zahlungen für konfigurierte Länder empfangen
- Das Zahlungslogo wurde angepasst

### Verbessert

- Das Novalnet-Zahlungsmodul wurde ausgiebig  getestet und entsprechend optimiert

### Behoben

- Fehlermeldungsanzeige für abgelehnte Transaktionen
- Problem mit dem Betragsformat in der Callback-Benachrichtigungs-E-Mail

## v2.0.1 (2019-01-23)

### Behoben

- Problem beim Update des Zahlungsplugins über plentyMarketplace

## v2.0.0 (2018-12-24)

### Neu

- Der Status Garantierte Zahlung ausstehend wurde implementiert
- Mindestbetrag für Zahlungen mit Zahlungsgarantie auf 9,99 EUR herabgesetzt
- 3D-Secure Verfahren für Kreditkartenzahlungen basierend auf den Einstellungen im Novalnet Administrationsportal
- Anzeige der Payment Slip für Barzahlen-Zahlungen auf der Erfolgreich-Seite

### Verbessert

- On-hold-Option ist nun für bestimmte Zahlungsarten konfigurierbar Kreditkarte, SEPA-Lastschrift (mit Zahlungsgarantie), Kauf auf Rechnung (mit Zahlungsgarantie), PayPal
- Anlegen einer Bestellung vor Zahlungsaufruf für alle umgeleitete Zahlungsarten (SOFORT-Überweisung, Kreditkarte mit 3D-Secure, PayPal, etc.), um bei Kommunikationsabbrüchen aufgrund eines Timouts, Browserschließung, etc. eine fehlende Bestellung zu vermeiden

### Behoben

- Abgleich von Transaktionsinformationen in der Rechnung

## v1.0.3 (2018-08-22)

### Neu

- Funktion zum Austausch des Novalnet-Logos im Checkout durch eigenes Logo eingebaut

## v1.0.2 (2018-06-01)

### Verbessert

- Angepasstes Zahlungs-Plugin für die neue Konfigurationsstruktur und Unterstützung für mehrere Sprachen.

## v1.0.1 (2018-01-17)

### Verbessert

- Die Fehlermeldung wird ohne Fehlercode angezeigt.

## v1.0.0 (2017-12-08)

- Neuer Release
