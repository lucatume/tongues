<?php

namespace Tongues\ServiceProviders;


class NetworkAdminPage extends \tad_DI52_ServiceProvider
{

	/**
	 * Binds and sets up implementations.
	 */
	public function register()
	{
        $this->container->singleton('Tongues\\UI\\Admin\\NetworkOptionsInterface', 'Tongues\\UI\\Admin\\NetworkOptions');

		$container = $this->container;

		add_action('network_admin_menu', function () use ($container) {
			$title = __('Tongues', 'tongues');
			add_submenu_page('settings.php', $title, $title, 'manage_network', 'tongues-network-options', [$container->make('Tongues\\UI\\Admin\\NetworkOptions'), 'render']);
		});
	}

	/**
	 * Binds and sets up implementations at boot time.
	 */
	public function boot()
	{
	}
}