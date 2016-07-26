<?php

namespace Tongues\Interfaces\API\Handlers;


interface EndpointHandler
{

    public function handle(\WP_REST_Request $request);
}