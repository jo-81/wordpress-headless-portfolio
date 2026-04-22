<?php

declare(strict_types=1);

namespace PortfolioHeadless;

/**
 * Registre centralisé de tous les hooks WordPress du plugin.
 *
 * Collecte les hooks pendant l'instanciation des composants,
 * puis les enregistre tous auprès de WordPress en une seule passe
 * via la méthode run().
 *
 * Cela permet :
 * - de tester les composants sans que les hooks soient réellement enregistrés
 * - d'avoir une vue d'ensemble de tous les hooks du plugin en un seul endroit
 * - de découpler l'enregistrement des hooks de la logique métier
 *
 * @package Portfolio_Headless
 */
final class Loader {

	/**
	 * Liste des hooks enregistrés.
	 *
	 * @var array<int, array{
	 *     hook: string,
	 *     component: object,
	 *     callback: string,
	 *     priority: int,
	 *     args: int
	 * }>
	 */
	private array $actions = array();

	/**
	 * Liste des filtres enregistrés.
	 *
	 * @var array<int, array{
	 *     hook: string,
	 *     component: object,
	 *     callback: string,
	 *     priority: int,
	 *     args: int
	 * }>
	 */
	private array $filters = array();

	/**
	 * Ajoute un hook de type action à la file d'attente.
	 *
	 * @param string $hook          Le nom du hook WordPress (ex: 'init', 'rest_api_init').
	 * @param object $component     L'instance de la classe qui contient le callback.
	 * @param string $callback      Le nom de la méthode à appeler.
	 * @param int    $priority      La priorité d'exécution (défaut : 10).
	 * @param int    $accepted_args Le nombre d'arguments acceptés par le callback.
	 */
	public function add_action(
		string $hook,
		object $component,
		string $callback,
		int $priority = 10,
		int $accepted_args = 1
	): void {
		$this->actions[] = array(
			'hook'      => $hook,
			'component' => $component,
			'callback'  => $callback,
			'priority'  => $priority,
			'args'      => $accepted_args,
		);
	}

	/**
	 * Ajoute un hook de type filtre à la file d'attente.
	 *
	 * @param string $hook              Le nom du filtre WordPress.
	 * @param object $component         L'instance de la classe qui contient le callback.
	 * @param string $callback          Le nom de la méthode à appeler.
	 * @param int    $priority          La priorité d'exécution (défaut : 10).
	 * @param int    $accepted_args     Le nombre d'arguments acceptés par le callback.
	 */
	public function add_filter(
		string $hook,
		object $component,
		string $callback,
		int $priority = 10,
		int $accepted_args = 1
	): void {
		$this->filters[] = array(
			'hook'      => $hook,
			'component' => $component,
			'callback'  => $callback,
			'priority'  => $priority,
			'args'      => $accepted_args,
		);
	}

	/**
	 * Enregistre tous les hooks collectés auprès de WordPress.
	 * Appelé une seule fois par Plugin::run().
	 */
	public function run(): void {
		foreach ( $this->filters as $hook ) {
			add_filter(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ), // @phpstan-ignore-line
				$hook['priority'],
				$hook['args']
			);
		}

		foreach ( $this->actions as $hook ) {
			add_action(
				$hook['hook'],
				array( $hook['component'], $hook['callback'] ), // @phpstan-ignore-line
				$hook['priority'],
				$hook['args']
			);
		}
	}
}
