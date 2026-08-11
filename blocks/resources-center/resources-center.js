jQuery(function($){

	$('.cdev_resources_loadmore').on('click', function(e){
		e.preventDefault();

		var button = $(this),
			$wrap = button.closest('.cdev_loadmore_wrap'),
			$block = button.closest('.resources-center-block'),
			$grid = $block.find('.resources-center-grid'),
			page = parseInt($grid.data('page'), 10) || 1,
			maxPage = parseInt($grid.data('max'), 10) || 1,
			perPage = parseInt($grid.data('per-page'), 10) || 2,
			excluded = $grid.data('excluded') || '',
			data = {
				'action': 'resources_loadmore',
				'page': page,
				'per_page': perPage,
				'excluded': excluded
			};

		$.ajax({
			url: cdev_resources_params.ajaxurl,
			data: data,
			type: 'POST',
			beforeSend: function () {
				button.addClass('loading');
				$wrap.stop(true, true).fadeOut(200);
			},
			success: function( response ){
				button.removeClass('loading');

				if ( response && response.trim() ) {
					var $newPosts = $(response.trim()).hide();
					$grid.append($newPosts);

					$newPosts.fadeIn(500).promise().done(function () {
						page++;
						$grid.data('page', page);

						if ( page >= maxPage ) {
							$wrap.remove();
						} else {
							$wrap.fadeIn(500);
						}
					});
				} else {
					$wrap.remove();
				}
			},
			error: function () {
				button.removeClass('loading');
				$wrap.fadeIn(300);
			}
		});
	});

});
