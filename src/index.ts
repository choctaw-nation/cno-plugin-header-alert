interface Window {
	headerBarData: {
		textContent: string;
		isDismissable: 0 | 1;
		cta: {
			button_text: string;
			button_link: string;
			allow_custom_colors: boolean;
			custom_colors: {
				button_color: {
					red: number;
					green: number;
					blue: number;
					alpha: number;
				};
				button_background: {
					red: number;
					green: number;
					blue: number;
					alpha: number;
				};
			};
		};
	};
}

class HeaderBar {
	private header: HTMLElement;
	private isVisible: boolean;
	private scrollUp: string;
	private scrollDown: string;
	private lastScroll: number;
	private body: HTMLElement;
	private masthead: HTMLElement;

	constructor() {
		if ( document.cookie.includes( 'headerIsDismissed=true' ) ) {
			return;
		}
		this.masthead = document.getElementById( 'masthead' )!;
		this.body = document.body;
		this.header = document.getElementById( 'cno-alert-header-bar' )!;
		this.isVisible =
			this.header.getAttribute( 'data-is-visible' ) === 'true';
		this.scrollUp = 'scroll-up';
		this.scrollDown = 'scroll-down';
		this.lastScroll = 0;
		if ( window.scrollY <= 0 && this.isVisible ) {
			this.addOffset();
		}

		this.handleEvents();
	}

	private styleElement( el: HTMLElement, styles: Record< string, string > ) {
		Object.keys( styles ).forEach( ( key ) => {
			el.style[ key ] = styles[ key ];
		} );
	}

	private handleEvents() {
		const dismissButton = this.header.querySelector( 'button' );
		if ( dismissButton ) {
			dismissButton.addEventListener(
				'click',
				this.dismissHeader.bind( this ),
				{ once: true }
			);
		}

		window.addEventListener( 'resize', this.addOffset.bind( this ) );
		window.addEventListener( 'scroll', this.handleScroll.bind( this ) );
	}

	/**
	 * Dismiss the header bar
	 */
	private dismissHeader( ev ) {
		if ( 'click' === ev.type ) {
			document.cookie = 'headerIsDismissed=true';
			this.header.addEventListener(
				'transitionend',
				() => {
					this.removeOffset();
					this.header.remove();
				},
				{
					once: true,
				}
			);
		}
	}

	private handleScroll() {
		const currentScroll = window.scrollY;

		if ( currentScroll <= 0 ) {
			document.body.classList.remove( this.scrollUp );
			return;
		}

		if (
			currentScroll > this.lastScroll &&
			! document.body.classList.contains( this.scrollDown )
		) {
			this.removeOffset();
		} else if (
			currentScroll < this.lastScroll &&
			document.body.classList.contains( this.scrollDown )
		) {
			this.addOffset();
		}

		this.lastScroll = currentScroll;
	}

	private addOffset() {
		document.body.classList.remove( this.scrollDown );
		document.body.classList.add( this.scrollUp );

		this.styleElement( this.masthead, {
			transform: `translateY(${ this.header.offsetHeight }px)`,
		} );
	}

	private removeOffset() {
		document.body.classList.remove( this.scrollUp );
		document.body.classList.add( this.scrollDown );
		this.styleElement( this.body, {
			transform: '',
			paddingTop: ``,
		} );
		this.styleElement( this.masthead, {
			paddingTop: '',
			transform: '',
		} );
	}
}

new HeaderBar();
