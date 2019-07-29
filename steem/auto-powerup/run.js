/*
  _____ _______ ______ ______ __  __ _____ _______
 / ____|__   __|  ____|  ____|  \/  |_   _|__   __|
| (___    | |  | |__  | |__  | \  / | | |    | |
 \___ \   | |  |  __| |  __| | |\/| | | |    | |
 ____) |  | |  | |____| |____| |  | |_| |_   | |
|_____/   |_|  |______|______|_|  |_|_____|  |_|

 Steemit auto redeem by @de_henne

 */

'use strict';

const DSteem = require('dsteem');
const Client = DSteem.Client;
const Steem  = new Client('https://api.steemit.com');

const conf = require('./config.js');

// config
const USERNAME    = conf.username;
const PASSWORD    = conf.password;
const MIN_BALANCE = conf.minAccountBalance;

const PRIVATE_KEY = DSteem.PrivateKey.fromLogin(USERNAME, PASSWORD, 'active');


// search account
Steem.database.call('get_accounts', [[USERNAME]]).then(function (result) {
    const balance = parseFloat(result[0].balance);

    if (balance <= MIN_BALANCE) {
        return;
    }

    let powerUp = balance - MIN_BALANCE;

    const op = ['transfer_to_vesting', {
        from  : USERNAME,
        to    : USERNAME,
        amount: powerUp.toFixed(3) + ' STEEM'
    }];

    Steem.broadcast.sendOperations([op], PRIVATE_KEY).then(
        function (result) {
            console.log(powerUp + ' powered up ✔️');
        },
        function (error) {
            console.error(error);
        }
    );
}).catch(function (err) {
    console.error(err);
});
