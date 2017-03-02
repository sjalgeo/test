import { FETCH_PUNDITS } from '../actions/actions-pundits';

const INITIAL_STATE = {
    all: [],
    selected: null
};

export default ( state = INITIAL_STATE, action ) => {

	switch( action.type ) {
        case FETCH_PUNDITS:
            const response = action.payload.data;
            // check data here TODO

            if ('success' === response.status) {
                return { ...state, all: response.data };
            } else {
                return state;
            }

		default:
			return state;
	}
}