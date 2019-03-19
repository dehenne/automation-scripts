Steemit auto redeem
======

This Script redeem unclaimed rewards of an account

- first looks to see if there are unclaimed rewards
- second if so then it claimed these

What you need
------

- NodeJS
- NPM

Installation
------

- `npm install`
- Fill in the `config.js`
- Run the script `nodejs run.js`

Configuration
------

Please fill in all settings in the config.js file.

```

// User name of the voter
const USERNAME = 'YOUR-USERNAME';

// Password of the voter
const PASSWORD = 'YOUR-PASSWORD';

```

Hint
-----

This script is not intended for online use. Passwords are stored in the config. 
Therefore this script should not be used on a public server.