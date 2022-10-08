# loremflickr
Service provider for generating fake images that can replace the standard provider. Based on https://loremflickr.com/

### Installation

```
composer require tmoiseenko/loremflickr
```

### Usage
add to your AppServiceProvider.php
```php
public function register()
{
        $this->app->singleton(Generator::class, function () {
            $faker = \Faker\Factory::create();
            $faker->addProvider(new LoremflickrFakerImageProvider($faker));
            return $faker;
        });
    }
```
### Parameters
The `loremflickrImage($dir = null, $width = 640, $height = 480, $category = null, $fullPath = false)` method has many arguments. Here are the default values:

Description:

- $dir: (string) Path of the generated picture file. Must be writable. If omited, will default to the system temp directory (usualy /tmp on Linux systems).
- $width: (integer) width in pixels of the picture, default to 640.
- $height: (integer) height in pixels of the picture, default to 480.
- $category: (string|array|null) you can pass one or more words for which the image will be generated.
- $fullPath: (bool) if true it will return the full path otherwise only the title/