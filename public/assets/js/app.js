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


$(document).ready(function() {
    // Handle clicks on category toggle icons
    $('.toggle-icon').click(function(e) {
        e.stopPropagation();
        
        var categoryId = $(this).data('category-id');
        var childrenContainer = $('#children-' + categoryId);
        var icon = $(this).find('i');
        
        // Toggle the visibility of children
        childrenContainer.slideToggle(200);
        
        // Toggle the icon rotation
        if (icon.hasClass('fa-chevron-right')) {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
        } else {
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }
    });
    
    // Handle edit button clicks
    $('.edit-btn').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var categoryId = $(this).data('id');
        // You can add your edit functionality here
        console.log('Edit category ID: ' + categoryId);
        // For example: window.location.href = 'edit-category.php?id=' + categoryId;
    });
    
    // Make the entire row clickable for toggling (optional)
    $('.parent-category .category-row').click(function() {
        $(this).find('.toggle-icon').click();
    });
});

