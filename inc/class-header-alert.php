<?php
/**
 * The View Layer
 *
 * @package ChoctawNation
 * @subpackage HeaderAlert
 */

namespace ChoctawNation\HeaderAlert;

/**
 * Builds the Header Alert
 */
class Header_Alert {
	/**
	 * The text content of the alert
	 *
	 * @var ?string $text_content
	 */
	private ?string $text_content;

	/**
	 * Whether the alert is dismissable
	 *
	 * @var bool $is_dismissable
	 */
	private bool $is_dismissable;

	/**
	 * The CTA text
	 *
	 * @var ?string $cta_text
	 */
	private ?string $cta_text;

	/**
	 * The CTA link
	 *
	 * @var ?string $cta_link
	 */
	private ?string $cta_link;

	/**
	 * Custom colors for the CTA
	 *
	 * @var ?array $custom_colors
	 */
	private ?array $custom_colors;

	/**
	 * Whether the alert is active
	 *
	 * @var bool $is_active
	 */
	private bool $is_active;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->is_active = get_field( 'is_active', 'options' ) ?? false;
		if ( ! $this->is_active ) {
			return;
		}
		if ( isset( $_COOKIE['headerIsDismissed'] ) && 'true' === $_COOKIE['headerIsDismissed'] ) {
			return;
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_body_open', array( $this, 'header_alert' ) );
	}

	/**
	 * Initialize Properties
	 */
	private function init_props() {

		$this->text_content   = empty( get_field( 'text_content', 'options' ) ) ? null : acf_esc_html( get_field( 'text_content', 'options' ) );
		$this->is_dismissable = get_field( 'dismissable', 'options' );

		$cta = get_field( 'cta', 'options' );
		if ( ! empty( $cta ) ) {
			$allow_custom_colors = $cta['allow_custom_colors'];
			$this->cta_text      = empty( $cta['button_text'] ) ? null : esc_textarea( $cta['button_text'] );
			$this->cta_link      = empty( $cta['button_link'] ) ? null : esc_textarea( $cta['button_link'] );
			$this->custom_colors = ( $allow_custom_colors ) ? $cta['custom_colors'] : null;
		}
	}

	/**
	 * Enqueue Scripts
	 */
	public function enqueue_scripts() {
		$path              = plugin_dir_path( __DIR__ ) . 'build/index.asset.php';
		$header_bar_assets = require $path;
		$deps              = $header_bar_assets['dependencies'];
		$version           = $header_bar_assets['version'];
		wp_enqueue_script(
			'headerBar',
			plugin_dir_url( __DIR__ ) . '/build/index.js',
			$header_bar_assets['dependencies'],
			$header_bar_assets['version'],
			array( 'strategy' => 'defer' )
		);
	}

	/**
	 * Callback. Echoes the Header Alert markup
	 */
	public function header_alert() {
		$this->init_props();
		$markup  = $this->alert_styles();
		$markup .= $this->alert_markup();
		echo $markup;
	}

	/**
	 * Simple Alert Styles to remove padding on `p` tags
	 *
	 * @return string
	 */
	private function alert_styles(): string {
		return '<style>#cno-alert-header-bar {background-color: var(--bs-primary);transition: all .25s ease-in-out;z-index:1031!important;transform:translateY(0%)}.scroll-down #cno-alert-header-bar {transform: translateY(-100%);}#masthead {transition:all .25s ease-in-out;}</style>';
	}

	/**
	 * Alert Markup
	 *
	 * @return string
	 */
	private function alert_markup(): string {
		$markup            = '';
		$container_classes = array(
			'p-3',
			'text-bg-secondary',
			'd-flex',
			'justify-content-evenly',
			'align-items-center',
			'text-center',
			'w-100',
			'fixed-top',
		);
		$container_classes = implode( ' ', $container_classes );

		$markup  = "<aside class='{$container_classes}' id='cno-alert-header-bar' data-is-visible='true'><div class='fs-6'>{$this->text_content}</div>";
		$markup .= $this->cta_text ? $this->alert_cta() : '';
		$markup .= $this->is_dismissable ? "<button class='btn btn-close position-absolute' style='right:5%;top:5%;' aria-label='Close'></button>" : '';
		$markup .= '</aside>';
		return $markup;
	}

	/**
	 * Alert CTA
	 *
	 * @return string
	 */
	private function alert_cta(): string {
		$cta_styles = $this->custom_colors ? $this->get_the_custom_style() : '';
		$markup     = "<a href='{$this->cta_link}' class='btn btn-primary' {$cta_styles}target='_blank'>{$this->cta_text}</a>";
		return $markup;
	}

	/**
	 * Get the custom style for the CTA
	 *
	 * @return string
	 */
	private function get_the_custom_style(): string {
		$button_color            = $this->custom_colors['button_color'];
		$button_background       = $this->custom_colors['button_background'];
		$button_style            = "color:rgba({$button_color['red']},{$button_color['green']},{$button_color['blue']},{$button_color['alpha']});";
		$button_background_style = "background-color:rgba({$button_background['red']},{$button_background['green']},{$button_background['blue']},{$button_background['alpha']});";

		return "style='{$button_style}{$button_background_style}'";
	}
}
new Header_Alert();