<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * German strings for WebDAV Check.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['completionwebdav'] = 'WebDAV-Datei vorhanden';
$string['curlerror'] = 'cURL-Fehler: {$a}';
$string['debugresponse'] = 'Debug: Serverantwort';
$string['error_curl'] = 'Verbindungsfehler: {$a}';
$string['error_http'] = 'Der WebDAV-Server hat einen HTTP-Fehler zurückgegeben: {$a}';
$string['error_noconfig'] = 'WebDAV ist nicht konfiguriert. Bitte kontaktieren Sie den Administrator.';
$string['error_notfound'] = 'Der WebDAV-Ordner wurde nicht gefunden.';
$string['error_unauthorized'] = 'WebDAV-Authentifizierung fehlgeschlagen. Bitte überprüfen Sie die Zugangsdaten in den Admin-Einstellungen.';
$string['error_xml'] = 'Ungültige Antwort vom WebDAV-Server.';
$string['failuretext'] = 'Fehlermeldung';
$string['filepattern'] = 'Datei-Muster';
$string['filepattern_help'] = 'Dateimuster mit Wildcards. Beispiel: *.docx';
$string['foundfiles'] = 'Gefundene Dateien:';
$string['fullpath'] = 'Vollständiger Pfad';
$string['generalsettings'] = 'Allgemeine Einstellungen';
$string['httpcode'] = 'HTTP-Code: {$a}';
$string['messagetexts'] = 'Meldungstexte';
$string['modulename'] = 'WebDAV-Prüfung';
$string['modulename_help'] = 'Die WebDAV-Prüfung verbindet sich mit einem WebDAV-Server und prüft, ob eine bestimmte Datei vorhanden ist. Falls ja, wird die Aktivität als abgeschlossen markiert.';
$string['modulenameplural'] = 'WebDAV-Prüfungen';
$string['nofilesfound'] = 'Keine Dateien gefunden (oder Fehler bei der Abfrage).';
$string['nowebdavchecks'] = 'In diesem Kurs wurden keine WebDAV-Prüfungen gefunden.';
$string['pathtemplate'] = 'Pfad-Template';
$string['pathtemplate_help'] = 'Relativer Pfad zum WebDAV-Ordner. Verwenden Sie {$user} als Platzhalter für den Benutzernamen. Beispiel: Shared/{$user}/abgaben/';
$string['pluginadministration'] = 'WebDAV-Prüfung Administration';
$string['pluginname'] = 'WebDAV-Prüfung';
$string['privacy:metadata'] = 'Die WebDAV-Prüfung speichert keine personenbezogenen Daten. Sie verbindet sich im Namen der aktuellen Person mit dem konfigurierten WebDAV-Server, um das Vorhandensein einer Datei zu prüfen.';
$string['setting'] = 'Einstellung';
$string['successtext'] = 'Erfolgsmeldung';
$string['test_info'] = 'Klicken Sie auf den Button, um die WebDAV-Verbindung mit den konfigurierten Einstellungen zu testen.';
$string['test_success'] = 'Verbindung erfolgreich! {$a} Elemente auf dem WebDAV-Server gefunden.';
$string['testbutton'] = 'Verbindung testen';
$string['testconnection'] = 'Verbindung testen';
$string['testresult'] = 'Test-Ergebnis';
$string['testresult_error'] = 'Fehler bei der Prüfung: {$a}';
$string['testresult_found'] = 'Bedingung erfüllt! Die Datei wurde für diesen Benutzer gefunden.';
$string['testresult_notfound'] = 'Bedingung nicht erfüllt! Die Datei wurde für diesen Benutzer nicht gefunden.';
$string['testwithuser'] = 'Verbindungs-Check';
$string['testwithuser_desc'] = 'Geben Sie einen Benutzernamen ein, um zu prüfen, ob der WebDAV-Pfad und das Datei-Muster für diesen Benutzer zutreffen.';
$string['value'] = 'Wert';
$string['webdavcheck:addinstance'] = 'Neue WebDAV-Prüfung hinzufügen';
$string['webdavcheck:view'] = 'WebDAV-Prüfung ansehen';
$string['webdavcheckname'] = 'Aktivitätsname';
$string['webdavpass'] = 'WebDAV-Passwort';
$string['webdavpass_desc'] = 'Passwort für die WebDAV-Authentifizierung';
$string['webdavsettings'] = 'WebDAV-Einstellungen';
$string['webdavurl'] = 'WebDAV-URL';
$string['webdavurl_desc'] = 'Basis-URL des WebDAV-Servers. Beispiel: https://alfresco.example.com/alfresco/webdav/';
$string['webdavuser'] = 'WebDAV-Benutzername';
$string['webdavuser_desc'] = 'Benutzername für die WebDAV-Authentifizierung';
