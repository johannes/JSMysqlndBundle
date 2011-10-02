JSMysqlndBundle
===============

The JSMysqlndBundle is an extension to th Symfony 2 profiling toolbar. It
extends the data collection with information gathered from PHP's mysqlnd
database driver, giving more insight on the performance.

Requirements
-----------

For making use of this bundle you need Symfony2 running on a PHP setup
where the mysqli extension is activated and mysqlnd is being used. The mysqli 
extension is only used to retreive data. It is no requirement for your 
application to use to use mysqli. Applications using  Doctrind and PDO are 
fully supported.

Installation
------------

Installation is a quick process:

1. Download JSMysqlndBundle
2. Configure the Autoloader
3. Enable the Bundle

### Step 1: Download JSMysqlndBundle

Ultimately, the JSMysqlndBundle files should be downloaded to the
`vendor/bundles/JS/MysqlndBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

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
$ git submodule add git://github.com/ohannes/JSMysqlndBundle.git vendor/bundles/JS/MysqlndBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

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
for debug only.

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
        $bundles[] = new JS/MysqlndBundle();
    }
}
```
