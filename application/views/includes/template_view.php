<?
	$this->load->view('includes/header_view');
	$this->load->view('includes/css_view');
	$this->load->view('includes/js_view');
	?>
	<div id="wapper">
	<?
	$this->load->view('includes/nav_view');
	$this->load->view('includes/sliderbar_view');
	?>
	<div id="content">
	<?
	$this->load->view($main_content);
	?>
	</div>
	<?
	$this->load->view('includes/footer_view');
	?>
	</div>