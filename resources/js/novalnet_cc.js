jQuery(document).ready(function () {
     if(typeof(window.NovalnetUtility) === 'undefined') {
           setTimeout(function(){
               loadNovalnetCcIframe();
          },1000);
          } else {
             loadNovalnetCcIframe();
          }
        jQuery('#nn_cc_form').submit( function (e) {
                jQuery('#novalnet_form_btn').attr('disabled',true);
               
                if(jQuery('#nn_pan_hash').val().trim() == '') {
                    NovalnetUtility.getPanHash();
                    e.preventDefault();
                    e.stopImmediatePropagation();
                }
         });    
});

function loadNovalnetCcIframe()
{
     var ccCustomFields = jQuery('#nn_cc_formfields').val() != '' ? JSON.parse(jQuery('#nn_cc_formfields').val()) : null;
     var ccFormDetails= jQuery('#nn_cc_formdetails').val() != '' ? JSON.parse(jQuery('#nn_cc_formdetails').val()) : null;
    
    // Set your Client key
    NovalnetUtility.setClientKey((ccFormDetails.client_key !== undefined) ? ccFormDetails.client_key : '');

     var requestData = {
        'callback': {
          on_success: function (result) {
            jQuery('#nn_pan_hash').val(result['hash']);
            jQuery('#nn_unique_id').val(result['unique_id']);
            jQuery('#nn_cc3d_redirect').val(result['do_redirect']);
            jQuery('#nn_cc_form').submit();
            jQuery('.modal').hide();
            return true;
          },
          on_error: function (result) {
           if ( undefined !== result['error_message'] ) {
                jQuery('#novalnet_form_btn').attr('disabled',false);
              alert(result['error_message']);
              return false;
            }
          },

           // Called in case the challenge window Overlay (for 3ds2.0) displays
          on_show_overlay:  function (result) {
            jQuery( '#nn_iframe' ).addClass( 'novalnet_cc_overlay' );
          },

           // Called in case the Challenge window Overlay (for 3ds2.0) hided
          on_hide_overlay:  function (result) {
            jQuery( '#nn_iframe' ).removeClass( 'novalnet_cc_overlay' );
          }
        },

         // You can customize your Iframe container style, text etc.
        'iframe': {

         // Passed the Iframe Id
          id: "nn_iframe",

          // Display the normal cc form
          inline: '0',
         
          // Adjust the creditcard style and text 
          style: {
            container: (ccCustomFields.novalnet_cc_standard_style_css !== undefined) ? ccCustomFields.novalnet_cc_standard_style_css : '',
            input: (ccCustomFields.novalnet_cc_standard_style_field !== undefined) ? ccCustomFields.novalnet_cc_standard_style_field : '' ,
            label: (ccCustomFields.novalnet_cc_standard_style_label !== undefined) ? ccCustomFields.novalnet_cc_standard_style_label : '' ,
          },
          
          text: {
            lang : (ccFormDetails.lang !== undefined) ? ccFormDetails.lang : 'en',
            error: (ccCustomFields.credit_card_error !== undefined) ? ccCustomFields.credit_card_error : '',
            card_holder : {
              label: (ccCustomFields.novalnet_cc_holder_Label !== undefined) ? ccCustomFields.novalnet_cc_holder_Label : '',
              place_holder: (ccCustomFields.novalnet_cc_holder_input !== undefined) ? ccCustomFields.novalnet_cc_holder_input : '',
              error: (ccCustomFields.novalnet_cc_error !== undefined) ? ccCustomFields.novalnet_cc_error : ''
            },
            card_number : {
              label: (ccCustomFields.novalnet_cc_number_label !== undefined) ? ccCustomFields.novalnet_cc_number_label : '',
              place_holder: (ccCustomFields.novalnet_cc_number_input !== undefined) ? ccCustomFields.novalnet_cc_number_input : '',
              error: (ccCustomFields.novalnet_cc_error !== undefined) ? ccCustomFields.novalnet_cc_error : ''
            },
            expiry_date : {
              label: (ccCustomFields.novalnet_cc_expirydate_label !== undefined) ? ccCustomFields.novalnet_cc_expirydate_label : '',
              place_holder: (ccCustomFields.novalnet_cc_expirydate_input !== undefined) ? ccCustomFields.novalnet_cc_expirydate_input : '',
              error: (ccCustomFields.novalnet_cc_error !== undefined) ? ccCustomFields.novalnet_cc_error : ''
            },
            cvc : {
              label: (ccCustomFields.novalnet_cc_cvc_label !== undefined) ? ccCustomFields.novalnet_cc_cvc_label : '',
              place_holder: (ccCustomFields.novalnet_cc_cvc_input !== undefined) ? ccCustomFields.novalnet_cc_cvc_input : '',
              error: (ccCustomFields.novalnet_cc_error !== undefined) ? ccCustomFields.novalnet_cc_error : ''
            }
          }
        },

         // Add Customer data
        customer: {
          first_name: (ccFormDetails.first_name !== undefined) ? ccFormDetails.first_name : '',
          last_name: (ccFormDetails.last_name !== undefined) ? ccFormDetails.last_name : ccFormDetails.first_name,
          email: (ccFormDetails.email !== undefined) ? ccFormDetails.email : '',
          billing: {
            street: (ccFormDetails.street !== undefined) ? ccFormDetails.street : '',
            city: (ccFormDetails.city !== undefined) ? ccFormDetails.city : '',
            zip: (ccFormDetails.zip !== undefined) ? ccFormDetails.zip : '',
            country_code: (ccFormDetails.country_code !== undefined) ? ccFormDetails.country_code : ''
          },
          shipping: {
            same_as_billing: (ccFormDetails.same_as_billing !== undefined) ? ccFormDetails.same_as_billing : 0,
          },
        },
        
         // Add transaction data
        transaction: {
          amount: (ccFormDetails.amount !== undefined) ? ccFormDetails.amount : '',
          currency: (ccFormDetails.currency !== undefined) ? ccFormDetails.currency : '',
          test_mode: (ccFormDetails.test_mode !== undefined) ? ccFormDetails.test_mode : '0',
          enforce_3d: (ccFormDetails.enforce_3d !== undefined) ? ccFormDetails.enforce_3d : '0',
        }
      };

      NovalnetUtility.createCreditCardForm(requestData);
     jQuery('.loader').hide(700);
}
