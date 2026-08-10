<form role="search" method="get" class="tool-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="tool-search-input" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="tool-search-submit"><i class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>
</form>
