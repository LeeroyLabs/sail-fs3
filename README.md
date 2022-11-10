# S3 Filesystem Adapter for SailCMS

This is the official S3 Filesystem adapter for SailCMS. This adapter is module that you will be able to load and it will
make the 's3://' protocol available to you.

## Installing

```bash
php sail install:official leeroy/sail-fs3
```

This will install the package using composer and then update your composer file to autoload the package.

If you wish to install it manually, you and perform the following

```bash
composer require leeroy/sail-fs3
```

After that, you can add `Leeroy\\FS3` to the modules section of the sailcms property of your composer.json file. It should look something like this:

```json
"sailcms": {
  "containers": ["Spec"],
  "modules": [
    "Leeroy\\FS3"
  ],
  "search": {}
}
```

## Configuration

When installed, you need to add the following to your `.env` file.

```
FS3_API_KEY=aws_key
FS3_API_SECRET=aws_secret
FS3_REGION=aws_region
FS3_BUCKET=bucket_name
FS3_ACL=public
```


## Using

When you want to upload something, you can do something like this:

```php
$fs = Filesytem::manager();
$fs->write('s3://file/path.jpg', $data, ['visibility' => 'public']);
```

If you want your file to be accessible by unsigned urls, you need to pass the `visibility` option and set it to `public`.

For the assets in SailCMS, set the adapter to `s3` in your `config/general.php` in the `assets` section. SailCMS
automatically sets the file to public visibility.

You can now enjoy the S3 on your site.