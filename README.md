<h1 align="center">
  <br>
  <a href="https://weglot.com/"><img src="https://staging.weglot.com/public/images/wglogo-full.png" alt="Weglot" width="200"></a>
  <br>
  Core Talent Assessment
  
  <br>
</h1>

Hello and welcome on Weglot Talent Assessment!

This PHP test will ask you to implement a simple encoding algorithm and a translator, then use Phpunit to test your code.

Requirements:
* Git (https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
* PHP >= 5.3 (https://www.php.net/manual/en/install.php)
* PHP Zip (https://www.php.net/manual/zip.installation.php)

1. We will test your code with PHP 7.3 version.
2. You should not add and commit code, it's managed by the ``talent-assessment`` command
3. Really YOU SHOULD NOT change anything outside the app directory.


First, you need to fork this repo and clone it on your computer.

Then, when you are ready to start the test you need to run the following command:
```
php talent-assessment start
```

This will create an ```app/``` directory where you will find class to implement. You can only make changes in this directory, any changes outside ```app/``` will not be taken in account. 

To run unit tests in order to check your code:
```
php vendor/bin/phpunit
```

When you've completed the talent assessment, run the following command :
```
php talent-assessment finish
```

Finally, open a pull-request between our repo and your fork [here](https://github.com/weglot/core-talent-assessment/compare).

Good luck !