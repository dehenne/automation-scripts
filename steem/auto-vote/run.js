/*
  _____ _______ ______ ______ __  __ _____ _______
 / ____|__   __|  ____|  ____|  \/  |_   _|__   __|
| (___    | |  | |__  | |__  | \  / | | |    | |
 \___ \   | |  |  __| |  __| | |\/| | | |    | |
 ____) |  | |  | |____| |____| |  | |_| |_   | |
|_____/   |_|  |______|______|_|  |_|_____|  |_|

 Steemit Autovote by @de_henne

 */

const DSteem = require('dsteem');
const Client = DSteem.Client;
const Steem  = new Client('https://api.steemit.com');

const conf = require('./config.js');

// config
const USERS         = conf.users;
const CONFIG_WEIGHT = conf.weight;
const USERNAME      = conf.username;
const PASSWORD      = conf.password;
const PRIVATE_KEY   = DSteem.PrivateKey.fromLogin(USERNAME, PASSWORD, 'posting');

const DEBUG = false;

/**
 * Return the 5 newest posts from an user
 *
 * @param username
 */
function getUserPosts(username) {
    process.stdout.write('Start fetching from ' + username + "\n");

    return new Promise(function (resolve) {
        Steem.database.getDiscussions('blog', {
            tag  : username,
            limit: 5,
        }).then(function (result) {
            if (!result) {
                console.log('no posts found');
                resolve([]);
                return;
            }

            if (DEBUG) {
                console.log('');
                console.log('Fetched from ' + username + ':');
            }

            let posts = [];

            for (let i = 0, len = result.length; i < len; i++) {
                let post = result[i];

                if (DEBUG) console.log('- ' + post.permlink);

                // only posts which are older than 15min
                let Created  = new Date(post.created);
                let fiftyMin = 15 * 60 * 1000;
                let fiveDays = 60 * 60 * 1000 * 24 * 5;

                // younger than 15minutes, don't vote
                if (((new Date) - Created) < fiftyMin) {
                    continue;
                }

                if (DEBUG) console.log('-> older than 15 min');

                // younger than 5 days, don't vote
                if ((new Date() - Created) > fiveDays) {
                    continue;
                }

                if (DEBUG) console.warn('-> younger than 5 days');

                // only posts which are not voted
                if (isAlreadyVoted(post.active_votes)) {
                    continue;
                }

                if (DEBUG) console.log('-> not voted');

                posts.push({
                    title   : post.title,
                    permlink: post.permlink,
                    author  : post.author,
                    image   : post.image,
                    created : Created.toDateString(),
                    meta    : JSON.parse(post.json_metadata)
                });
            }

            resolve(posts);
        }).catch(function (err) {
            console.log(err);
            resolve([]);
        });
    });
}

/**
 * Vote on posts
 *
 * @param author
 * @param permlink
 */
function voteOnPost(author, permlink) {
    process.stdout.write('Execute Vote at @' + author + ' - ' + permlink);

    return Steem.broadcast.vote({
        voter   : USERNAME,
        author  : author,
        permlink: permlink,
        weight  : CONFIG_WEIGHT
    }, PRIVATE_KEY).then(function () {
        process.stdout.write(' ✔️');
        process.stdout.write("\n");
    }, function (error) {
        process.stdout.write(' ❌️');
        process.stdout.write("\n");
        //if (error.code !== 10) {
        //console.log('error:', error);
        //}
    });
}

function isAlreadyVoted(votes) {
    for (let i = 0, len = votes.length; i < len; i++) {
        if (votes[i].voter !== USERNAME) {
            continue;
        }

        if (parseInt(votes[i].percent) === parseInt(CONFIG_WEIGHT)) {
            return true;
        }
    }

    return false;
}

/**
 * Process posts
 *
 * @param posts
 */
function processPosts(posts) {
    if (!posts.length) {
        return;
    }

    let post = posts.shift();

    voteOnPost(post.author, post.permlink).then(function () {
        if (posts.length) {
            processPosts(posts);
        }
    });
}


// run
let promises = [];

for (let i = 0, len = USERS.length; i < len; i++) {
    promises.push(getUserPosts(USERS[i]));
}

Promise.all(promises).then(function (posts) {
    processPosts(posts.flat());
});
