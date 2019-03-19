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
const PRIVATE_KEY = DSteem.PrivateKey.fromLogin(USERNAME, PASSWORD, 'posting');


// search account
Steem.database.call('get_accounts', [[USERNAME]]).then(function (result) {
    const reward_steem = result[0].reward_steem_balance.split(' ')[0];
    const reward_sbd   = result[0].reward_sbd_balance.split(' ')[0];
    const reward_sp    = result[0].reward_vesting_steem.split(' ')[0];
    const reward_vests = result[0].reward_vesting_balance.split(' ')[0];

    if (!reward_steem && !reward_sbd && !reward_sp && !reward_vests) {
        return;
    }

    console.log(
        `Unclaimed balance for ${USERNAME}: ${reward_steem} STEEM, ${reward_sbd} SBD, ${reward_sp} SP = ${reward_vests} VESTS`
    );

    // claim rewards
    let op = ['claim_reward_balance', {
        account     : USERNAME,
        reward_steem: reward_steem + ' STEEM',
        reward_sbd  : reward_sbd + ' SBD',
        reward_vests: reward_vests + ' VESTS',
    }];

    Steem.broadcast.sendOperations([op], PRIVATE_KEY).then(
        function () {
            console.log('Rewards claimed ✔️');
        },
        function (error) {
            console.error(error);
        }
    );
}).catch(function (err) {
    console.error(err);
});
