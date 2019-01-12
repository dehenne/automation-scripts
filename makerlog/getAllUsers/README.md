Makerlog Socialnetwork Handles
======

This repo shows how you can read all users from makerlog, 
it is now possible for you to read individual information about each user.

What can you do with it?
------

I created a separate files for each social handle., these scripts can be the basis for some more automatisms. 
For example you can inform yourself when there are new users in Makerlog.

> Example:
> You can get informed when a new Makerlog user with a Twitter handle registered and add it to a Twitter list.


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

Basic
------

The makerlog API has no get all users. 
Therefore you have to get the individual users via batches. 
How to do this can be found at [utils/getUsers.php](utils/getUsers.php)
