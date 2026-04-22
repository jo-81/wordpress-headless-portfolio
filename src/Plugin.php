<?php

declare(strict_types=1);

namespace PortfolioHeadless;

use PortfolioHeadless\Loader;

/**
 * Classe principale du plugin — Singleton.
 *
 * Responsabilités :
 * - Instancier tous les composants du plugin
 * - Les enregistrer auprès du Loader
 * - Déclencher l'enregistrement des hooks WordPress
 *
 * @package Portfolio_Headless
 */
final class Plugin {

	/**
	 * Instance unique du plugin.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Gestionnaire des hooks.
	 *
	 * @var Loader
	 */
	private Loader $loader;

	/**
	 * Initialise le plugin.
	 */
	private function __construct() {
		$this->loader = new Loader();
	}

	/**
	 * Retourne l'instance unique du plugin.
	 *
	 * @return Plugin
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Lance l'enregistrement des hooks WordPress.
	 *
	 * @return void
	 */
	public function run(): void {
		// Déclenche l'enregistrement de tous les hooks collectés.
		$this->loader->run();
	}
}
