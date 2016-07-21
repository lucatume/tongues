<?php
use Tongues\ServiceProviders\ApiEndpoints;
use Tongues\ServiceProviders\NetworkAdminPage;

$container = new tad_DI52_Container();

$container->register(ApiEndpoints::class);
$container->register(NetworkAdminPage::class);
