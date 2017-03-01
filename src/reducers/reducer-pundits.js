import { FETCH_PUNDITS } from '../actions/actions-pundits';

const INITIAL_STATE = [];

export default ( state = INITIAL_STATE, action ) => {

	switch( action.type ) {
		case FETCH_PUNDITS:
			return action.payload.data;

		default:
			return state;
	}
}