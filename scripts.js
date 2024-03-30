function showSection(sectionId) {
    document.querySelectorAll('.menu-section').forEach(function(section) {
      section.style.display = 'none';
    });
  
    document.getElementById(sectionId).style.display = 'block';
  }
  
  var currentIndex = 0;

function showNextImage() {
  var items = document.getElementsByClassName('carousel-item');
  if (currentIndex < items.length - 1) {
    currentIndex++;
  } else {
    currentIndex = 0;
  }
  updateCarousel();
}

const flowers = [
    { name: 'Casa Blanca', src: 'Flowers/Casa Blanca.jpg' },
    { name: 'Dandelion', src: 'Flowers/Dandelion.jpg' },
    { name: 'Hanashobu', src: 'Flowers/Hanashobu.jpg' },
    { name: 'Lily of the Valley', src: 'Flowers/Lily of the Valley.jpg' },
    { name: 'Lotus', src: 'Flowers/Lotus.jpg' },
    { name: 'Roses', src: 'Flowers/Roses.jpg' },
    { name: 'Sunflower', src: 'Flowers/Sunflower.jpg' },
    // Add more flowers data later on
  ];
  
  function populateGallery() {
    const gallery = document.getElementById('gallery');
    flowers.forEach(flower => {
      const flowerDiv = document.createElement('div');
      flowerDiv.className = 'w-1/4 flex-none text-center'; 
      flowerDiv.innerHTML = `
        <img src="${flower.src}" alt="${flower.name}" class="mx-auto" style="width: 100%; height: auto;">
        <p class="text-white">${flower.name}</p>
      `;
      gallery.appendChild(flowerDiv);
      
    });
  }
  
  function scrollGallery(direction) {
    const gallery = document.getElementById('gallery');
    gallery.scrollBy({ left: direction * gallery.clientWidth / 4, behavior: 'smooth' });
  }
  
  document.addEventListener('DOMContentLoaded', populateGallery);
  