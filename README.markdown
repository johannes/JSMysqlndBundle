JSMysqlndBundle
===============

The JSMysqlndBundle is an extension to th Symfony2 profiling toolbar. It
extends the data collection with information gathered from PHP's mysqlnd
database driver, giving more insight on the performance.

![Screenshot](https://f.cloud.github.com/assets/44364/296136/37bad942-94dd-11e2-9eb6-bfc538b071f9.png)

Requirements
-----------

For making use of this bundle you need Symfony2 running on a PHP setup
where the mysqli extension is activated and mysqlnd is being used. The mysqli
extension is only used to retrieve data. It is no requirement for your
application to use to use mysqli. Applications using  Doctrine and PDO are
fully supported.

Installation
------------

Installation is a quick process:

1. Download JSMysqlndBundle or install it via Composer
2. Configure the Autoloader
3. Enable the Bundle

### Step 1: Download JSMysqlndBundle

Ultimately, the JSMysqlndBundle files should be downloaded to the
`vendor/bundles/JS/MysqlndBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard method for Symfony 2.1+.

**Using Composer**

``` bash
$ php composer.phar require "js/mysqlnd-bundle=dev-master"
```

Take a look at [the page on Packagist web site](https://packagist.org/packages/js/mysqlnd-bundle) for more details and up-to-date version numbers.

**Using the vendors script**

This method is the standard method for Symfony 2.0
Add the following lines in your `deps` file:

```
[JSMysqlndBundle]
    git=git://github.com/johannes/JSMysqlndBundle.git
    target=bundles/JS/MysqlndBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/johannes/JSMysqlndBundle.git vendor/bundles/JS/MysqlndBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

This step should be omitted if you used Composer to install this Bundle.

Add the `JS` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'JS' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel. Note: You probably want to do this
for development and test systems only.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
    );

    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        // ...
        $bundles[] = new \JS\MysqlndBundle\JSMysqlndBundle();
    }
}
```
