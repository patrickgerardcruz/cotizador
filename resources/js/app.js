import './bootstrap';
import 'bootstrap';

document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
	toggle.addEventListener('click', () => {
		const input = document.getElementById(toggle.dataset.passwordToggle);
		const isVisible = input.type === 'text';

		input.type = isVisible ? 'password' : 'text';
		toggle.setAttribute('aria-label', isVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
		toggle.setAttribute('aria-pressed', String(!isVisible));
	});
});

const imagePreviewDialog = document.querySelector('[data-image-preview-dialog]');
const imagePreviewTarget = imagePreviewDialog?.querySelector('[data-image-preview-target]');
const imagePreviewCaption = imagePreviewDialog?.querySelector('[data-image-preview-caption]');
const imagePreviewCounter = imagePreviewDialog?.querySelector('[data-image-preview-counter]');
const imagePreviewPrev = imagePreviewDialog?.querySelector('[data-image-preview-prev]');
const imagePreviewNext = imagePreviewDialog?.querySelector('[data-image-preview-next]');
let imagePreviewGallery = [];
let imagePreviewIndex = 0;

function renderImagePreview() {
	if (!imagePreviewTarget || imagePreviewGallery.length === 0) return;

	const image = imagePreviewGallery[imagePreviewIndex];
	imagePreviewTarget.src = image.src;
	imagePreviewTarget.alt = image.alt || '';
	if (imagePreviewCaption) imagePreviewCaption.textContent = image.alt || '';
	if (imagePreviewCounter) imagePreviewCounter.textContent = `${imagePreviewIndex + 1} / ${imagePreviewGallery.length}`;
	if (imagePreviewPrev) imagePreviewPrev.hidden = imagePreviewGallery.length < 2;
	if (imagePreviewNext) imagePreviewNext.hidden = imagePreviewGallery.length < 2;
}

function moveImagePreview(step) {
	if (imagePreviewGallery.length < 2) return;
	imagePreviewIndex = (imagePreviewIndex + step + imagePreviewGallery.length) % imagePreviewGallery.length;
	renderImagePreview();
}

document.querySelectorAll('[data-image-preview]').forEach((trigger) => {
	trigger.addEventListener('click', () => {
		if (!imagePreviewDialog || !imagePreviewTarget) return;

		try {
			imagePreviewGallery = JSON.parse(trigger.dataset.imagePreviewGallery || '[]');
		} catch {
			imagePreviewGallery = [];
		}

		if (imagePreviewGallery.length === 0 && trigger.dataset.imagePreview) {
			imagePreviewGallery = [{
				src: trigger.dataset.imagePreview,
				alt: trigger.dataset.imagePreviewAlt || '',
			}];
		}

		imagePreviewIndex = 0;
		renderImagePreview();
		imagePreviewDialog.showModal();
	});
});

document.querySelectorAll('[data-image-preview-close]').forEach((closeButton) => {
	closeButton.addEventListener('click', () => imagePreviewDialog?.close());
});

imagePreviewDialog?.addEventListener('click', (event) => {
	if (event.target === imagePreviewDialog) imagePreviewDialog.close();
});

imagePreviewPrev?.addEventListener('click', () => moveImagePreview(-1));
imagePreviewNext?.addEventListener('click', () => moveImagePreview(1));

imagePreviewDialog?.addEventListener('keydown', (event) => {
	if (event.key === 'ArrowLeft') moveImagePreview(-1);
	if (event.key === 'ArrowRight') moveImagePreview(1);
});
