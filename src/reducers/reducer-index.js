import { combineReducers } from 'redux';
import { reducer as formReducer } from 'redux-form';
import punditsReducer from './reducer-pundits';

const rootReducer = combineReducers({
	form: formReducer,
	pundits: punditsReducer
});

export default rootReducer;