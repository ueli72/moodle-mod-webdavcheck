# WebDAV Check

## Description

The **WebDAV Check** activity module connects to a WebDAV server and checks whether a
specific file exists for the current user. If the file is found, the activity is marked
as completed (optionally via the custom completion rule "WebDAV file present").

Typical use case: a teacher prepares a folder on a WebDAV server (e.g. Alfresco) that is
populated per user (e.g. `Shared/{$user}/submissions/`). The WebDAV Check activity shows
a success message once the expected file (e.g. `*.docx`) is present, and can drive
automatic course completion.

## Features

- Per-activity path template with `{$user}` placeholder for the username
- File pattern matching with wildcards (e.g. `*.docx`)
- Customisable success/failure messages with full editor support (incl. images)
- Custom completion rule: mark the activity complete when the file is present
- Connection test page for administrators (Site administration → Plugins → Activities → WebDAV Check)
- Per-instance connection test for teachers (from the activity settings form)
- Fallback: if the server does not support `PROPFIND`, an HTML directory listing is parsed
- Backup and restore support
- Privacy API: the plugin stores no personal data (null provider)
- Language support: English, German

## Requirements

- Moodle 5.2 or later
- A reachable WebDAV server with HTTP basic authentication
- PHP with the cURL extension and a working TLS certificate verification
  (self-signed server certificates require proper CA configuration on the server,
  see [SSL certificate troubleshooting](https://docs.moodle.org/en/HTTPS_certificates))

## Installation

1. Copy the `webdavcheck` folder into the `mod` directory of your Moodle installation,
   or install the zip via *Site administration → Plugins → Install plugins*.
2. Visit *Site administration → Notifications* to complete the installation.
3. Configure the WebDAV server credentials under
   *Site administration → Plugins → Activities → WebDAV Check*.
4. Use the *Test Connection* link on that page to verify the setup.

## Usage

1. In a course, add the activity **WebDAV Check**.
2. Enter a **path template**, e.g. `Shared/{$user}/submissions/`.
3. Enter a **file pattern**, e.g. `*.docx`.
4. Optionally enable the completion rule *WebDAV file present* (Activity completion).
5. The activity view shows the success or failure message per user and updates
   the completion state when the file appears.

## Security notes

- WebDAV credentials are configured globally by the administrator and stored in the
  Moodle configuration (password field is masked in the UI).
- All requests to the WebDAV server enforce TLS certificate verification.
- The username is inserted into the path template URL-encoded.

## Privacy

This plugin does not store any personal data. It queries the configured WebDAV server
on behalf of the current user (server-to-server, using the globally configured
credentials) and only checks for the presence of a file.

## License

GNU General Public License v3 or later – see [COPYING.txt](http://www.gnu.org/licenses/gpl-3.0.html).
