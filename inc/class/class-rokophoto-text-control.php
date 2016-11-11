<?php
class RokoPhoto_Text extends WP_Customize_Control{
	private $message = '';
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if(!empty($args['rokophoto_message'])){
			$this->message = $args['rokophoto_message'];
		}
	}

	public function render_content(){
		echo $this->message;
	}
}
?>