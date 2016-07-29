<?php
use Tongues\ServiceProviders\Adapters;
use Tongues\ServiceProviders\ApiEndpoints;
use Tongues\ServiceProviders\Cache;
use Tongues\ServiceProviders\NetworkAdminPage;

$container = new tad_DI52_Container();

$container->register(Cache::class);
$container->register(Adapters::class);
$container->register(ApiEndpoints::class);
$container->register(NetworkAdminPage::class);
