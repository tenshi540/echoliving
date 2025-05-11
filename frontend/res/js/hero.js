document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelector('.hero-slider .slides');
  const total  = document.querySelectorAll('.hero-slider .slide').length;
  let index    = 0;

  function update() {
    slides.style.transform = `translateX(${-index * 100}%)`;
  }

  document.querySelector('.hero-slider .prev')
    .addEventListener('click', () => { index = (index - 1 + total) % total; update(); });

  document.querySelector('.hero-slider .next')
    .addEventListener('click', () => { index = (index + 1) % total; update(); });

  // show first slide immediately
  update();

  // auto‐advance
  setInterval(() => { index = (index + 1) % total; update(); }, 5000);
});
