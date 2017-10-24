<div class="options_group woo-gotobweinar-<?php echo $product_type_key;?>" id="<?php echo $product_type_key;?>">
	<?php 
		woocommerce_wp_text_input(
			array(
			'id'             => 'woogotowebinar_price_field',
			'label'          => __( 'Price', 'woocommerce' ),
			'placeholder'	=> '',
			'desc_tip'    	=> 'true',
			'description'    => __( 'Enter Price for this product.', 'woocommerce' ),
			'type'           => 'price',
			'value'			=> ''
		)); 
	?>
</div>