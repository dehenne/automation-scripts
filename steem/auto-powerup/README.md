Steemit auto redeem
======

This script powered up automatically.

- It can be determined how much steem should stay on the account.

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

// in steem
const MIN_ACCOUNT_BALANCE = 100;

```

Hint
-----

This script is not intended for online use. Passwords are stored in the config. 
Therefore this script should not be used on a public server.