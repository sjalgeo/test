import { FETCH_PUNDITS, SELECT_PUNDIT } from '../actions/actions-pundits';

const INITIAL_STATE = {
    all: [],
    selected: null
};

export default ( state = INITIAL_STATE, action ) => {

	switch( action.type ) {
        case FETCH_PUNDITS:
            const response = action.payload.data;
            // check data here TODO

            if ( 'success' === response.status ) {
                return { ...state, all: response.data };
            } else {
                return state;
            }

		case SELECT_PUNDIT:

			const matchId = pundit => { return pundit.id === action.payload };

			return { ...state, selected: state.all.find( matchId ) };

		default:
			return state;
	}
}