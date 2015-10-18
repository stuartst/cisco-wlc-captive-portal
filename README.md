# cisco-wlc-captive-portal

Configuring a Cisco Wireless LAN Controller (WLC) to support external web authentication (captive portal) is notoriously difficult. Unfortunately there is a lack of detailed -- or sometimes relevant -- information surrounding how this process works and how to communicate with the WLC to authenticate users.

This simple PHP script is designed for people who wish to use an external web site for authentication (typically for guest wifi services), but have been stumped with some of the undocumented variables and quirks required for this to function correctly.

## External WebAuth Process

1. User attempts to browse to a website and is redirected to the WLC configured **External Webauth URL** setting
2. User enters username/email and password then submits form
3. User details are sent back to the WLC using the URL specified in the `switch_url` variable
  * The input variables `username` and `password` are used by the WLC
  * **IMPORTANT:** an input variable `buttonClicked = 4` **MUST** also be POSTed back to the WLC to proceed. If this variable is not set the WLC will redirect back to the **External Webauth URL**
4. The WLC authenticates the user details against a preconfigured authentication method (typically Radius)
  * If an error occurs with authentication the WLC returns a `statusCode` variable with a value between 1-5 (see below for value definitions)
  * If authentication succeeds the user is redirected to the WLC configured **Redirect URL after login** setting

## $_GET Variables

* `switch_url`

The URL of the controller to which the user credentials should be posted. This is provided by the WLC as a *$_GET* variable upon loading of the **External Webauth URL**.

Example:
```
switch_url=http://1.1.1.1/login.html
```

* `ap_mac`

The MAC address of the access point to which the wireless user is associated. This is provided by the WLC as a *$_GET* variable upon loading of the **External Webauth URL**.

Example:
```
ap_mac=b8:be:bf:14:41:90
```

* `client_mac`

The MAC address of the wireless user. This is provided by the WLC as a *$_GET* variable upon loading of the **External Webauth URL**.

Example:
```
client_mac=28:cf:e9:13:47:cb
```

* `wlan`

The WLAN SSID to which the wireless user is associated. This is provided by the WLC as a *$_GET* variable upon loading of the **External Webauth URL**.

Example:
```
wlan=Free-WiFi
```

* `redirect`

The URL to which the user is redirected after authentication is successful. This is provided by the WLC as a *$_GET* variable upon loading of the **External Webauth URL**.

Example:
```
redirect=bbc.co.uk/
```

* `statusCode`

The status code returned from the controller's web authentication server. This is provided by the WLC as a *$_GET* variable upon an authentication error.

## $_POST Variables

* `username`

The username or email address of the wireless user. This is provided to the WLC as a *$_POST* variable upon form submission.

* `password`

The password of the wireless user. This is provided to the WLC as a *$_POST* variable upon form submission.

* `buttonClicked`

This is an arbitrary variable that must be set to a value of `4` to proceed. This is provided to the WLC as a *$_POST* variable upon form submission, and if not set will redirect the user back to the **External Webauth URL**.

## Status Codes (statusCode variable)

Only `statusCode` numbers are sent by the WLC. The text description next to each `statusCode` below is purely for informational purposes only and is not sent by the WLC.

1. You are already logged in. No further action is required on your part.
2. You are not configured to authenticate against web portal. No further action is required on your part.
3. The username specified cannot be used at this time. Perhaps the username is already logged into the system?
4. You have been excluded.
5. The User Name and Password combination you have entered is invalid. Please try again.

## Example External Webauth URL
```
https://mysplashpage.com?switch_url=http://1.1.1.1/login.html&ap_mac=b8:be:bf:14:41:90&client_mac=28:cf:e9:13:47:cb&wlan=Free-WiFiA&redirect=bbc.co.uk/
```
