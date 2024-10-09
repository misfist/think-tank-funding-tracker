/**
 * File: scroll-to-top.js
 *
 * Scroll page top
 */
const scrollToTopButton = document.getElementById('scroll-to-top');
const scrollThreshold = 500;
const topCoord = 0;

if (scrollToTopButton) {
	const scrollFunction = () => {
		if (
			document.body.scrollTop > scrollThreshold ||
			document.documentElement.scrollTop > scrollThreshold
		) {
			scrollToTopButton.classList.remove('is-hidden');
			scrollToTopButton.classList.add('is-visible');
		} else {
			scrollToTopButton.classList.add('is-hidden');
			scrollToTopButton.classList.remove('is-visible');
		}
	};

	const backToTop = () => {
		window.scrollTo({
			top: topCoord,
			behavior: 'smooth',
		});
	};

	scrollToTopButton.addEventListener('click', backToTop);

	window.addEventListener('scroll', scrollFunction);
}
