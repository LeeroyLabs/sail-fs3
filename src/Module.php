<?php

namespace Leeroy\FS3;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter;
use League\Flysystem\Visibility;
use SailCMS\Collection;
use SailCMS\Contracts\AppModule;
use SailCMS\Filesystem;
use SailCMS\Types\ModuleInformation;

class Module implements AppModule
{
    public function __construct()
    {
        // Setup S3 Filesystem protocol
        $client = new S3Client([
            'credentials' => [
                'key' => $_ENV['FS3_API_KEY'],
                'secret' => $_ENV['FS3_API_SECRET']
            ],
            'region' => $_ENV['FS3_REGION'],
            'version' => 'latest'
        ]);

        if ($_ENV['FS3_ACL'] === 'public') {
            $visibility = new PortableVisibilityConverter(Visibility::PUBLIC);
        } else {
            $visibility = new PortableVisibilityConverter(Visibility::PRIVATE);
        }

        $s3Adapter = new AwsS3V3Adapter($client, $_ENV['FS3_BUCKET'], '', $visibility);

        Filesystem::mount('s3', $s3Adapter);
        Filesystem::init();
    }

    public function info(): ModuleInformation
    {
        return new ModuleInformation('FS3', 'filesystem Adapter for AWS S3', 1.0, '1.0.0');
    }

    public function cli(): Collection
    {
        return Collection::init();
    }

    public function middleware(): void
    {
    }

    public function events(): void
    {

    }
}