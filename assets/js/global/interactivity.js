/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

const { state, actions, callbacks } = store( 'ttft/data-tables', {
	state: {
		tableType: '',
		thinkTank: '',
		donor: '',
		donationYear: '',
		donorType: '',
		get isSelected() {
			const { ref } = getElement();
			return state[ref.name] == ref.value;
		}
	},
	actions: {
		updateYear: () => {
			const context = getContext();
			const { ref } = getElement();
			state.donationYear = ref.value;
		},
		updateType: () => {
			const context = getContext();
			const { ref } = getElement();
			state.donorType = ref.value;
		},
		stringifyState: () => {
			state.jsonState = JSON.stringify( state.tableData, null, 2 );
		}
	},
	callbacks: {
		log: () => {
			const { tableType, thinkTank, donor, donationYear, donorType } = state;
			console.log( `log: `, tableType, thinkTank, donor, donationYear, donorType );
			// const context = getContext();
            // console.log( 'Context:', JSON.stringify( context, undefined, 2 ) );
			// actions.stringifyState();
		}
	},
} );
