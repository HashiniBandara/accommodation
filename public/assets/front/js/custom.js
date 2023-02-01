// new WOW().init({
// 	mobile: false,
// });

jQuery(document).ready(function ($) {

	// let windowWidth = $(window).width();
	// if (windowWidth < 1025) {
	// 	new Mmenu('#navbarCollapse',
	// 		{
	// 			"extensions": [
	// 				"pagedim-black",
	// 			]
	// 		}
	// 	);
	// }

	// Cards Carosuel

	if ($('#cardsCarousel').length) {

		let cardsCarousel = $('#cardsCarousel').owlCarousel({
			loop: true,
			nav: false,
			margin: 35,
			autoPlay: false,
			autoplayTimeout: 5000,
			dots: false,
			responsive: {
				0: {
					items: 1,
				},
				768: {
					items: 2,
				},
				1024: {
					items: 4,
				}
			}
		});

		$('#cardsPrev, .cards-left-nav').on('click', function (event) {
			event.preventDefault();
			cardsCarousel.trigger('prev.owl.carousel');
		});

		$('#cardsNext, .cards-right-nav').on('click', function (event) {
			event.preventDefault();
			cardsCarousel.trigger('next.owl.carousel');
		});
	}

	// Occasion Inquiry Form
	if ($('#customizeCardForm').length > 0) {

		$('#customizeCardForm').on('submit', function (event) {
			event.preventDefault();

			let updated = updateNames();
			console.log(updated);
			if (updated) {
				html2canvas(document.querySelector("#cardImage"), {
					allowTaint: true,
					useCORS: true,
					scale: scale,
					x: 0,
				}).then(canvas => {
					$('#dataUrl').val(canvas.toDataURL("image/png"));
					ThemeOverlay.show();
					$.ajax({
						type: "POST",
						url: $(this).attr('action'),
						data: $(this).serializeArray(),
						success: function (response) {
							ThemeOverlay.hide();
							if (response['status']) {
								// themeSwal.fire(
								// 	'Success!',
								// 	response['message'],
								// 	'success'
								// );
								// document.getElementById('customizeCardForm').reset();
								window.location.href = response['redirect'];
							} else {
								themeSwal.fire(
									'Error!',
									response['message'],
									'error'
								);
							}
						}
					});
				});
			}
		});

		let scale = 1200 / $("#cardImage").width();

		$('#updateCardBtn').on('click', function (event) {
			event.preventDefault();

			updateNames();

		});

		$('#font').on('change', function (event) {
			let fontClass = $(this).val();
			if (fontClass) {
				$('.names-wrapper').removeClass().addClass('names-wrapper').addClass(fontClass);
			} else {
				$('.names-wrapper').removeClass().addClass('names-wrapper');
			}
		});
	}

	function updateNames() {

		let validated = true;

		$('#customizeCardForm').find('input[type=text]').each(function () {
			if (!$(this).val()) {
				$('#customizeCardForm').addClass('was-validated');
				validated = false;
			}
		});

		if (validated) {
			$('#from').html($('#from_name').val());
			$('#to').html($('#to_name').val());
			return true;
		} else {
			return false;
		}

	}

});

const themeSwal = Swal.mixin({
	customClass: {
		confirmButton: 'theme-btn',
		cancelButton: 'theme-btn secondary'
	},
	buttonsStyling: false
});

var ThemeOverlay = function () {
	return {
		show: function () {
			$('#loadingOverlay').removeClass('d-none');
		},
		hide: function () {
			$('#loadingOverlay').addClass('d-none');
		}
	};
}();