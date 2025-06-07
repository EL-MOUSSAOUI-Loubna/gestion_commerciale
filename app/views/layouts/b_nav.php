<!-- Bottom Navigation (Mobile) -->
<div class="bottom-nav d-md-none">
        <div class="bottom-nav-item" onclick="toggleMenu('clients')">
            <i class="fas fa-users"></i>
            <div class="bottom-nav-dropup" id="clients-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-list me-2"></i>Clients</div>
            </div>
        </div>
        <div class="bottom-nav-item" onclick="toggleMenu('products')">
            <i class="fas fa-boxes"></i>
            <div class="bottom-nav-dropup" id="products-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-list me-2"></i>Produits</div>
            </div>
        </div>
        <div class="bottom-nav-item" onclick="toggleMenu('categories')">
            <i class="fas fa-tags"></i>
            <div class="bottom-nav-dropup" id="categories-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-list me-2"></i>Catégories</div>
            </div>
        </div>
        <div class="bottom-nav-item" onclick="toggleMenu('bonl')">
            <i class="fas fa-tags"></i>
            <div class="bottom-nav-dropup" id="bonl-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-list me-2"></i>Bons de Livraison</div>
            </div>
        </div>
        <div class="bottom-nav-item" onclick="toggleMenu('factures')">
            <i class="fas fa-tags"></i>
            <div class="bottom-nav-dropup" id="factures-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-list me-2"></i>Factures</div>
            </div>
        </div>
        <!--<div class="bottom-nav-item" onclick="toggleMenu('documents')">
            <i class="fas fa-file-alt"></i>
            <div class="bottom-nav-dropup" id="documents-menu">
                <div class="bottom-nav-dropup-item"><i class="fas fa-file-invoice me-2"></i>Devis</div>
                <div class="bottom-nav-dropup-item"><i class="fas fa-truck me-2"></i>Bon de Livraison</div>
                <div class="bottom-nav-dropup-item"><i class="fas fa-file-invoice-dollar me-2"></i>Factures</div>
            </div>
        </div>-->
    </div>

<script>
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
</script>