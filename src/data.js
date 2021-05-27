// need to create my custom store for our options. 

import apiFetch from '@wordpress/api-fetch';
import { registerStore } from '@wordpress/data';

const initialState = {
    charitynumber: 0,
    charitytext: "",
};

const myStore = 'forflcharity/charitydata';

    reducer ( state = initialState, action);

const actions = {
    setState, 
    updateState,
    persistValuetodb
}

const selectors {
    getCharityNumberText ( state ),
}

const controls {
    fetchFromApi ( action ) {
        return apiFetch( { path: action.path })
    }
}
registerStore(forflcharity/charitydata);
