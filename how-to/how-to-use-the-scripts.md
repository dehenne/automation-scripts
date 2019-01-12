How to use the scripts
======

Best I can recommend, use a Unix system. This already comes to you with the program `cron`.

> Cron is a system daemon used to execute desired tasks (in the background) at designated times. 

A good explanation how to use `cron` can be found here:

- https://help.ubuntu.com/community/CronHowto


Recommendation
------

That you don't have to run your desktop computer 24 hours a day, I recommend that you buy a small single-board computer. 
These are already available for less than $20.

**Very clear recommendation, a Raspberry PI.**

- https://www.raspberrypi.org/

Due to the low consumption of 2 to 5 watts this little guy is perfect for automatisms.


Script usage
------

All scripts should have a small manual. 
If not, the general rule in this repo is: all php scripts in the main folders are directly executable.
 
If you want to automate the whole thing you just have to execute the scripts regularly with cron.

**Example of a crontab:**

```
*/10    *       *       *       *       cd /home/automation-scripts/twitter/auto-vote; php run.php

```

In principle, it was that. no more, no less.

If you have any questions, just create an issue and I will try to answer them ;-)