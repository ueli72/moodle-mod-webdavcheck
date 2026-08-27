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
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['modulename'] = 'WebDAV-Prüfung';
$string['modulenameplural'] = 'WebDAV-Prüfungen';
$string['modulename_help'] = 'Die WebDAV-Prüfung verbindet sich mit einem WebDAV-Server und prüft, ob eine bestimmte Datei vorhanden ist. Falls ja, wird die Aktivität als abgeschlossen markiert.';
$string['webdavcheckname'] = 'Aktivitätsname';
$string['webdavsettings'] = 'WebDAV-Einstellungen';
$string['pathtemplate'] = 'Pfad-Template';
$string['pathtemplate_help'] = 'Relativer Pfad zum WebDAV-Ordner. Verwenden Sie {$user} als Platzhalter für den Benutzernamen. Beispiel: Shared/{$user}/abgaben/';
$string['filepattern'] = 'Datei-Muster';
$string['filepattern_help'] = 'Dateimuster mit Wildcards. Beispiel: *.docx';
$string['messagetexts'] = 'Meldungstexte';
$string['successtext'] = 'Erfolgsmeldung';
$string['failuretext'] = 'Fehlermeldung';
$string['generalsettings'] = 'Allgemeine Einstellungen';
$string['webdavurl'] = 'WebDAV-URL';
$string['webdavurl_desc'] = 'Basis-URL des WebDAV-Servers. Beispiel: https://alfresco.example.com/alfresco/webdav/';
$string['webdavuser'] = 'WebDAV-Benutzername';
$string['webdavuser_desc'] = 'Benutzername für die WebDAV-Authentifizierung';
$string['webdavpass'] = 'WebDAV-Passwort';
$string['webdavpass_desc'] = 'Passwort für die WebDAV-Authentifizierung';
$string['error_noconfig'] = 'WebDAV ist nicht konfiguriert. Bitte kontaktieren Sie den Administrator.';
$string['error_curl'] = 'Verbindungsfehler: {$a}';
$string['error_unauthorized'] = 'WebDAV-Authentifizierung fehlgeschlagen. Bitte überprüfen Sie die Zugangsdaten in den Admin-Einstellungen.';
$string['error_notfound'] = 'Der WebDAV-Ordner wurde nicht gefunden.';
$string['error_http'] = 'Der WebDAV-Server hat einen HTTP-Fehler zurückgegeben: {$a}';
$string['error_xml'] = 'Ungültige Antwort vom WebDAV-Server.';
$string['nowebdavchecks'] = 'In diesem Kurs wurden keine WebDAV-Prüfungen gefunden.';
$string['testconnection'] = 'Verbindung testen';
$string['testbutton'] = 'Verbindung testen';
$string['test_info'] = 'Klicken Sie auf den Button, um die WebDAV-Verbindung mit den konfigurierten Einstellungen zu testen.';
$string['test_success'] = 'Verbindung erfolgreich! {$a} Elemente auf dem WebDAV-Server gefunden.';
$string['setting'] = 'Einstellung';
$string['value'] = 'Wert';
$string['testwithuser'] = 'Verbindungs-Check';
$string['testwithuser_desc'] = 'Geben Sie einen Benutzernamen ein, um zu prüfen, ob der WebDAV-Pfad und das Datei-Muster für diesen Benutzer zutreffen.';
$string['testresult'] = 'Test-Ergebnis';
$string['testresult_found'] = 'Bedingung erfüllt! Die Datei wurde für diesen Benutzer gefunden.';
$string['testresult_notfound'] = 'Bedingung nicht erfüllt! Die Datei wurde für diesen Benutzer nicht gefunden.';
$string['testresult_error'] = 'Fehler bei der Prüfung: {$a}';
$string['fullpath'] = 'Vollständiger Pfad';
$string['completionwebdav'] = 'WebDAV-Datei vorhanden';
$string['pluginname'] = 'WebDAV-Prüfung';
$string['pluginadministration'] = 'WebDAV-Prüfung Administration';
