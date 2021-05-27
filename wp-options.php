<?php 
namespace wp4good\forflcharity;

$fltext = "A COPY OF THE OFFICIAL REGISTRATION AND FINANCIAL INFORMATION MAYBE BE OBTAINED FROM THE DIVISION OF CONSUMER SERVICES BY CALLING TOLL-FREE (800-435-7352) WITHIN THE STATE. REGISTRATION DOES NOT IMPLY ENDORSEMENT, APPROVAL, OR RECOMMENDATION BY THE STATE. Website: <a href='https://floridaconsumerhelp.com\'>FloridaConsumerHelp</a>";

$flnumber = 'CH48852';
// for testing purposes, for the release sent it to empty

$option_number = 'forflcharity_number';

if( get_option( $option_number ) === false ) {
    update_option( $option_number, $flnumber);
}


$option_text = 'forflcharity_text';

if( get_option( $option_text )  === false ){
    update_option( $option_text, $fltext );
};