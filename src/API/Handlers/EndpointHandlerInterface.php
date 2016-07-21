<?php

namespace Tongues\API\Handlers;


interface EndpointHandlerInterface
{

    public function handle(\WP_REST_Request $request);
}