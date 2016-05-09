jQuery(document).ready(function(){
	"use strict";

	jQuery('body').bind( 'added_to_cart', function( fragments, cart_hash ){
		var amount = jQuery(".total .amount", cart_hash['div.widget_shopping_cart_content']).first().text();

		if ( amount ) {
			jQuery('#widget--shop-cart .cart-money, #woocommerce-nav-cart .cart-money').html( amount );
		}

		jQuery.post( CloudFwOp.ajaxUrl, { action: "cloudfw_woocommerce_mini_cart" }, function( data ) {
			jQuery('#ui--side-cart').html( data );
		});

	});

	jQuery('body').bind( 'adding_to_cart', function( $thisbutton, data ){
		var button = jQuery(data);
		var delay = setInterval(function(){

			if ( button.hasClass('added') ) {
				var next = button.next('.added_to_cart');

				if ( next.length ) {
					button.hide();
					next.show();

					var delayMessage = setInterval(function(){
						var message = next.attr('data-i18n-view-cart') !== '' ? 
										next.attr('data-i18n-view-cart') :
										'View Cart';

						if(typeof wc_add_to_cart_params.cart_url !== 'undefined') {
							next.attr('href', wc_add_to_cart_params.cart_url);
						}

						next.html( message ).removeClass('btn-green').addClass('btn-grey');
						clearInterval(delayMessage);
					}, 1500);
				}

				clearInterval(delay);
			}

		}, 500);




	});


	jQuery('body').on( 'click', '#respond #submit', function(){
		var rating_select = jQuery(this).closest('#respond').find('#ui--rating-selector');
		var rating  = rating_select.val();

		if ( rating_select.size() > 0 && ! rating && woocommerce_params.review_rating_required === 'yes' ) {
			alert(woocommerce_params.i18n_required_rating_text);
			return false;
		}
	}); 


	jQuery('body').on( 'change', '.woocommerce-ordering [name="show_products"]', function(){
		jQuery(this).parents('form:first').submit();
	}); 

});

jQuery( function( $ ) {

	// Orderby
	$( '.woocommerce-ordering' ).on( 'change', 'select.orderby', function() {
		$( this ).closest( 'form' ).submit();
	});

	// Quantity buttons
	$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );

	// Target quantity inputs on product pages
	$( 'input.qty:not(.product-quantity input.qty)' ).each( function() {
		var min = parseFloat( $( this ).attr( 'min' ) );

		if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
			$( this ).val( min );
		}
	});

	$( document ).on( 'click', '.plus, .minus', function() {

		// Get values
		var $qty		= $( this ).closest( '.quantity' ).find( '.qty' ),
			currentVal	= parseFloat( $qty.val() ),
			max			= parseFloat( $qty.attr( 'max' ) ),
			min			= parseFloat( $qty.attr( 'min' ) ),
			step		= $qty.attr( 'step' );

		// Format values
		if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if ( max === '' || max === 'NaN' ) max = '';
		if ( min === '' || min === 'NaN' ) min = 0;
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

		// Change the value
		if ( $( this ).is( '.plus' ) ) {

			if ( max && ( max == currentVal || currentVal > max ) ) {
				$qty.val( max );
			} else {
				$qty.val( currentVal + parseFloat( step ) );
			}

		} else {

			if ( min && ( min == currentVal || currentVal < min ) ) {
				$qty.val( min );
			} else if ( currentVal > 0 ) {
				$qty.val( currentVal - parseFloat( step ) );
			}

		}

		// Trigger change event
		$qty.trigger( 'change' );
	});
});

