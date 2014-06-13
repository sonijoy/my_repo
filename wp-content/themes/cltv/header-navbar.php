<header id="header-navbar" <?php if(current_user_can('channel')): ?>data-role="channel"<?php endif; ?> role="banner">

	<div id="inner-header" class="clearfix">
		
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid nav-container">
					<nav role="navigation">
						<a class="brand" id="logo" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php echo get_bloginfo('name'); ?>" />
						</a>
						
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar icon-white"></span>
							<span class="icon-bar icon-white"></span>
							<span class="icon-bar icon-white"></span>
						</a>
						
						<div class="nav-collapse">
							<ul class="nav">
								<li class="dropdown hidden-phone">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										Channels <b class="caret"></b>
									</a>
									<div data-get-url="<?php echo get_permalink(5481); ?>" class="dropdown-menu channels span8">	
										<div class="row-fluid channel_cat"> 
											<div class="span2 directions">
												Pick a category <i class="icon-circle-arrow-right pull-right"></i>
											</div>
											<div class="span10">
												<ul>
													<?php $categories = get_terms('channel_cat', array('hide_empty'=>0)); ?>	
													<?php foreach($categories as $cat): ?>											
														<li><a data-category="<?php echo $cat->slug; ?>" href="#"><?php echo $cat->name; ?></a></li>
													<?php endforeach; ?>
												</ul>
											</div>
										</div>
										<div class="row-fluid state">
											<div class="span2 directions">
												And a state <i class="icon-circle-arrow-right pull-right"></i>
											</div>
											<div class="span10">
												<select>
													<option value=""></option>
													<?php foreach(cltv_states() as $key => $value): ?>
														<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
													<?php endforeach; ?>
												</select>
												<img class="ajax_loader" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" alt="Loading..." />
											</div>
										</div>
										<div class="row-fluid">
											<div class="span12">
												<div class="results">
												
												</div>
											</div>
										</div>																		
									</div>									
								</li>
								<li><a href="<?php echo get_permalink(144); ?>">About</a></li>
								<li><a href="<?php echo get_permalink(5188); ?>">Contact</a></li>
							</ul>	
							<div class="navbar_tools" style="display:none;"></div>
							<form class="navbar-search pull-right" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
								<input name="s" id="s" type="text" class="search-query" autocomplete="off" placeholder="<?php _e('Search Channels','bonestheme'); ?>">
							</form>
						</div>
						
					</nav>
					
				</div>
			</div>
		</div>
	
	</div> <!-- end #inner-header -->

</header> <!-- end header -->

<!--[if lte IE 9 ]> 
	<div class="container">
		<div class="row-fluid">
			<div class="span12 alert alert-error">
				Your browser is out of date. To properly experience this site, please <a href="http://browsehappy.com/">upgrade</a>.
			</div>
		</div>
	</div>
<![endif]-->