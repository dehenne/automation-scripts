Steemit auto vote
======

This Script voted all Posts from wanted accounts

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

// which users should be voted
let USERS = ['username', 'username', 'username'];

// Weighting of votes
const CONFIG_WEIGHT = 10000;

// User name of the voter
const USERNAME = 'YOUR-USERNAME';

// Password of the voter
const PASSWORD = 'YOUR-PASSWORD';

```

Hint
-----

This script is not intended for online use. Passwords are stored in the config. 
Therefore this script should not be used on a public server.