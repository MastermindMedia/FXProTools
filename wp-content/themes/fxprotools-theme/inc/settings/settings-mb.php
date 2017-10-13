<?php
/**
 * ----------------
 * Metaboc Settings
 * ----------------
 * Metabox Setup - See https://metabox.io/docs/ for documentation
 */

if(!defined('ABSPATH')){
	exit;
}

if(!class_exists('SettingsMB')){

	class SettingsMB {
		
		// Initialize function(s)
		public function __construct()
		{
			$metaboxes = array('mb_courses', 'mb_products', 'mb_capture_page', 'mb_webinar', 'mb_emails');
			if($metaboxes) {
				foreach ($metaboxes as $key => $mb) {
					add_filter('rwmb_meta_boxes', array($this, $mb));
				}
			}
		}

		// MB - Courses(LearnDash LMS)
		public function mb_courses($meta_boxes)
		{
			$prefix = '';
			$meta_boxes[] = array(
				'id'         => 'course_custom_fields',
				'title'      => 'Course Custom Fields',
				'post_types' => array( 'sfwd-courses' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'autosave'   => false,
				'fields' => array(
					array(
						'id'   => $prefix . 'short_description',
						'type' => 'textarea',
						'name' => 'Short Description',
					),
					array(
						'id'   => $prefix . 'subtitle',
						'type' => 'text',
						'name' => 'Subtitle', 'fxprotools',
					),
				),
			);
			return $meta_boxes;
		}

		// MB - Products(Woocommerce)
		public function mb_products($meta_boxes)
		{
			$prefix = '';
			$meta_boxes[] = array(
				'id'         => 'product_custom_fields',
				'title'      => 'Product Custom Fields',
				'post_types' => array( 'product' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'autosave'   => false,
				'fields' => array(
					array(
						'id'          => $prefix . 'subtitle',
						'type'        => 'text',
						'placeholder' => 'Short Description',
						'name'        => 'Short Description',
					),
				),
			);
			return $meta_boxes;
		}

		// MB - Capture Page
		public function mb_capture_page($meta_boxes)
		{
			$prefix = '';
			$meta_boxes[] = array(
				'id'         => 'capture_page_fields',
				'title'      => 'Capture Page Fields',
				'post_types' => array( 'fx_funnel' ),
				'context'    => 'advanced',
				'priority'   => 'high',
				'autosave'   => false,
				'fields' => array(
					array(
						'id'   => $prefix . 'capture_page_title',
						'type' => 'text',
						'name' => 'Capture Page Title',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'capture_sub_title',
						'type' => 'text',
						'name' => 'Capture Sub Title',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'capture_page_url',
						'type' => 'text',
						'name' => 'Capture Page URL',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'capture_page_thumbnail',
						'type' => 'image_advanced',
						'name' => 'Cature Page Thumbnail',
						'force_delete' => false,
						'max_file_uploads' => '1',
					),
				),
			);
			$meta_boxes[] = array(
				'id'         => 'landing_page_fields',
				'title'      => 'Landing Page Fields',
				'post_types' => array( 'fx_funnel' ),
				'context'    => 'advanced',
				'priority'   => 'high',
				'autosave'   => false,
				'fields' => array(
					array(
						'id'   => $prefix . 'landing_page_title',
						'type' => 'text',
						'name' => 'Capture Page Title',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'landing_sub_title',
						'type' => 'text',
						'name' => 'Capture Sub Title',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'landing_page_url',
						'type' => 'text',
						'name' => 'Landing Page URL',
						'size' => 80,
					),
					array(
						'id'   => $prefix . 'landing_page_thumbnail',
						'type' => 'image_advanced',
						'name' => 'Landing Page Thumbnail',
						'force_delete' => false,
						'max_file_uploads' => '1',
					),
				),
			);
			return $meta_boxes;
		}

		// MB - Webinar
		public function mb_webinar($meta_boxes)
		{
			$prefix = '';
			$meta_boxes[] = array(
				'id'         => 'webinar_custom_fields',
				'title'      => 'Webinar Custom Fields',
				'post_types' => array( 'fx_webinar' ),
				'context'    => 'advanced',
				'priority'   => 'high',
				'autosave'   => false,
				'fields' => array(
					array(
						'id'   => $prefix . 'webinar_topic',
						'type' => 'wysiwyg',
						'name' => 'Topic',
					),
					array(
						'id'   => $prefix . 'webinar_start_date',
						'type' => 'date',
						'name' => 'Start Date',
					),
					array(
						'id'   => $prefix . 'webinar_start_time',
						'type' => 'time',
						'name' => 'Start Time',
					),
					array(
						'id'   => $prefix . 'webinar_meeting_link',
						'type' => 'text',
						'name' => 'Meeting Link',
					),
				),
			);
			return $meta_boxes;
		}
		
		public function mb_emails($meta_boxes)
		{
			$prefix = '';
			$meta_boxes[] = array(
				'id'			=> 'email_custom_fields',
				'title' 		=> 'Email Details',
				'post_types'	=> array('fx_email'),
				'context'		=> 'advanced',
				'priority'		=> 'high',
				'autosave'		=> false,
				'fields'		=> array(
					array(
						'id'	=> $prefix . 'email_recipient_type',
						'type'	=> 'select',
						'name'	=> 'Recipient Type',
						'options' => array(
							'all'		=> 'All Users',
							'group'		=> 'Group',
							'product'	=> 'Product',
							'individual'=> 'Individual'
						)
					),
					array(
						'id'	=> $prefix . 'recipient_group',
						'type'	=> 'select',
						'name'	=> 'Group Type',
						'options' => array(
							'customer'		=> 'Customers',
							'distributor'	=> 'Distributors',
							'both'			=> 'Both'
						),
						'visible' => array($prefix . 'email_recipient_type', 'group')
					),
					array(
						'id'	=> $prefix . 'recipient_product',
						'type'	=> 'post',
						'name'	=> 'Product',
						'post_type' => 'product',
						'field_type' => 'select_advanced',
						'visible' => array($prefix . 'email_recipient_type', 'product')
					),
					array(
						'id'	=> $prefix . 'recipient_individual_type',
						'type'	=> 'select',
						'name'	=> 'Individual Type',
						'options' => array(
							'email'	=> 'Specified Email',
							'user'	=> 'User'
						),
						'visible' => array($prefix . 'email_recipient_type', 'individual')
					),
					array(
						'id'	=> $prefix . 'recipient_individual_name',
						'type'	=> 'text',
						'name'	=> 'Individual Name',
						'visible' => array($prefix . 'recipient_individual_type', 'email')
					),
					array(
						'id'	=> $prefix . 'recipient_individual_email',
						'type'	=> 'text',
						'name'	=> 'Individual Email',
						'visible' => array($prefix . 'recipient_individual_type', 'email')
					),
					array(
						'id'	=> $prefix . 'recipient_individual_user',
						'type'	=> 'user',
						'name'	=> 'Individual User',
						'field_type' => 'select_advanced',
						'visible' => array($prefix . 'recipient_individual_type', 'user')
					),
					array(
						'id'	=> $prefix . 'email_content',
						'type'	=> 'wysiwyg',
						'name'	=> 'Email Content'
					)
				)
			);
			
			return $meta_boxes;
		}
	
	}

}

return new SettingsMB();