import axios from 'axios';

const ROOT_URL = 'http://localhost:8080/api.php/pundits';

export const FETCH_PUNDITS = 'FETCH_PUNDITS';

export const fetchPundits = () => {

	const request = axios.get( ROOT_URL );

	return {
		type: FETCH_PUNDITS,
		payload: request
	};
};

export const UPDATE_PUNDIT = 'UPDATE_PUNDIT';

export const updatePundit = () => {

    const request = axios.patch( ROOT_URL, { id: 3, 'firstname': 'Andy'} );

    return {
        type: UPDATE_PUNDIT,
        payload: request
    };
};