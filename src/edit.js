import api from '@wordpress/api';
//import apiFetch from '@wordpress.api-fetch';
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder, Spinner, TextControl,} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { select, subscribe } from '@wordpress/data';
import { Component } from '@wordpress/element';


import './editor.scss';

const fltext = "A COPY OF THE OFFICIAL REGISTRATION AND FINANCIAL INFORMATION MAYBE BE OBTAINED FROM THE DIVISION OF CONSUMER SERVICES BY CALLING TOLL-FREE (800-435-7352) WITHIN THE STATE. REGISTRATION DOES NOT IMPLY ENDORSEMENT, APPROVAL, OR RECOMMENDATION BY THE STATE. Website: <a href='https://floridaconsumerhelp.com'>FloridaConsumerHelp</a>"

class CharityFields extends Component {
    constructor() {
        super( ...arguments );

        this.state = {
            isAPILoaded: false,
            number: '',
            text: `${fltext}`,
        };
    };

    componentDidMount() {

        subscribe( () => {
            const { number, text } = this.state;

            // no change on autosaves
            if ( select( 'core/editor' ).isAutosavingPost() ){
                return;
            }

            // only proceed on manual saves
            if (! select( 'core/editor' ).isSavingPost() ) {
                return;
            }

            const settings = new api.models.Settings( {
                    [ 'forflcharity_text' ]: text,
                    [ 'forflcharity_number' ]:number,
            } );
            settings.save();
        });

        api.loadPromise.then( () => {
            this.settings = new api.models.Settings();

            const { isAPILoaded } = this.state;

            if ( isAPILoaded === false ) {
                this.settings.fetch().then ( ( response ) =>{
                    this.setState( {
                        number: response [ 'forflcharity_number' ],
                        text: response[ 'forflcharity_text' ],
                        isAPILoaded: true,
                    });
                });
            }
        });
    }

/**
 * Render the interface
 */

    render() {
        const {
            number,
            text,
            isAPILoaded,
        } = this.state;


        const { setAttributes } = this.props;

        if ( !isAPILoaded ) {
            return (
                <Placeholder>
                    <Spinner/>
                </Placeholder>
            );
        }

        return (

            <div>
                <TextControl  
                    label="Your Charity Number: "
                    onChange={ number => {
                        this.setState( { number } );
                        setAttributes( { number } )
                    }}
                    value={ number }
                />
                <TextControl  
                    label="Read only Text"
                    readOnly = "true" 
                    onChange={ text => {
                        this.setState( { text } );
                        setAttributes( { text } )
                    }}
                    value={ text }
                />
            </div>
            );
        }
    }

    export default function EDIT ( props ) {
        return(
            <div className="modern" { ...useBlockProps() }>
                <CharityFields { ...props }/>
                <p><em>A preview of the text</em></p>
                <ServerSideRender
                    block="wp4good/forflcharity"
                    attributes={ props.attributes }
                    />
            </div>
        );
    }

