/**
 * WordPress dependencies
 */
import { store } from '@wordpress/interactivity';

const { state } = store( 'back-to-top', {
	state: {
        isIntersecting: false,
    },
    actions: {
        setIntersecting( state, isIntersecting ) {
            state.isIntersecting = isIntersecting;
        },
    },
    callbacks: {
        observe( element ) {
            const observerOptions = {
                root: null, // Use the viewport as the root
                rootMargin: '0px',
                threshold: 0.1, // Trigger when 10% of the target is visible
            };

            const observerCallback = ( entries ) => {
                entries.forEach( entry => {
                    this.actions.setIntersecting( entry.isIntersecting );
                });
            };

            const observer = new IntersectionObserver( observerCallback.bind( this ), observerOptions );
            observer.observe( element );
        },
    },
	log: () => {
		console.log( `state:`, state );
	}
} );
