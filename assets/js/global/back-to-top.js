document.addEventListener('DOMContentLoaded', function () {
	const backToTop = () => {
		let y = window.scrollY;
		if (y > 0) {
			scrollToTopButton.className = 'back-to-top show';
		} else {
			scrollToTopButton.className = 'back-to-top hide';
		}
	};
});
