// Mobile menu functionality
function toggleMenu(menuId) {
  // Hide all menus first
  document.querySelectorAll('.bottom-nav-dropup').forEach(menu => {
      menu.classList.remove('show');
  });
  
  // Show the clicked menu
  const menu = document.getElementById(menuId + '-menu');
  menu.classList.toggle('show');
}

// Close menus when clicking elsewhere
document.addEventListener('click', function(event) {
  if (!event.target.closest('.bottom-nav-dropup-item')) {
      document.querySelectorAll('.bottom-nav-dropup').forEach(menu => {
          menu.classList.remove('show');
      });
  }
});