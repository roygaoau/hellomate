<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	
	<div class="input-group">
		<input name="s" id="s" type="text" class="form-control input-sm" value="<?php if (isset($_GET) && isset($_GET['s'])) echo esc_attr($_GET['s']);?>">
		<span class="input-group-btn">
			<?php /*?><button id="searchsubmit" type="submit" class="btn btn-sm btn-default"><?php _e("Search");?></button><?php */?>
      <input type="submit" value="<?php _e("Search");?>" id="searchsubmit" class="button">
		</span>
	</div>

</form>