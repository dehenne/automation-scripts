Makerlog Socialnetwork Handles
======

this repo shows how you can read all users from makerlog. 
so that you can see how to read the single handles (social network entry), i created a separate file for each handle.

Usage
------

List all makerlog users:

```
php makerlog-usernames.php
```


List all makerlog users with a github user entry:

```
php github-usernames.php
```


List all instagram users with a github user entry:

```
php instagram-usernames.php
```


List all makerlog users with a github user entry:

```
php producthunt-usernames.php

```

What can you do with it?
------

These scripts are the basis for some more automatisms. 
For example you can inform yourself when there are new users in Makerlog.

You can get informed when a new Makerlog user with a Twitter handle registered and add it to a Twitter list.


Basic
------

The makerlog API has no get all users. 
Therefore you have to get the individual users via batches. 
How to do this can be found at [utils/getUsers.php](utils/getUsers.php)