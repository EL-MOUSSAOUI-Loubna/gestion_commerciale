<!-- Sidebar -->
<div class="sidebar d-none d-md-block">
    <div class="sidebar-header p-3">
        <h5 class="mb-0 text-primary"><i class="fas fa-cube me-2"></i>Menu</h5>
    </div>
    <div class="sidebar-menu">
        <div class="accordion" id="sidebarMenu">
            <!-- Factures -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#factures">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Factures
                    </button>
                </h2>
                <div id="factures" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item ms-3"><a href="/stage/factures/add"
                                class="text-decoration-none d-block"><i class="fas fa-plus-circle me-2"></i> Ajouter
                                Factures</a></div>
                        <div class="submenu-item ms-3"><a href="/stage/factures" class="text-decoration-none d-block"><i
                                    class="fas fa-list me-2"></i> Liste Factures</a></div>
                    </div>
                </div>
            </div>

            <!-- Bon de Livraison -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#bonl">
                        <i class="fas fa-truck me-2"></i> Bon de Livraison
                    </button>
                </h2>
                <div id="bonl" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item ms-3"><a href="/stage/bonsLivraison/add"
                                class="text-decoration-none d-block"><i class="fas fa-plus-circle me-2"></i> Ajouter Bon
                                de L</a></div>
                        <div class="submenu-item ms-3"><a href="/stage/bonsLivraison"
                                class="text-decoration-none d-block"><i class="fas fa-list me-2"></i> Liste Bons de
                                Livraison</a></div>
                    </div>
                </div>
            </div>

            <!-- Clients -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#clients">
                        <i class="fas fa-users me-2" style='color: rgb(255, 255, 255);'></i>Clients
                    </button>
                </h2>
                <div id="clients" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item ms-3"><a href="/stage/clients/add"
                                class="text-decoration-none d-block"><i class="fas fa-plus-circle me-2"></i> Ajouter
                                Client</a></div>
                        <div class="submenu-item ms-3"><a href="/stage/clients" class="text-decoration-none d-block"><i
                                    class="fas fa-list me-2"></i> Liste Clients</a></div>
                    </div>
                </div>
            </div>

            <!-- Fournisseurs -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#fournisseurs">
                        <i class="fas fa-users me-2" style='color: rgb(255, 255, 255);'></i>Fournisseurs
                    </button>
                </h2>
                <div id="fournisseurs" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item ms-3"><a href="/stage/fournisseurs/add"
                                class="text-decoration-none d-block"><i class="fas fa-plus-circle me-2"></i> Ajouter
                                Fournisseurs</a></div>
                        <div class="submenu-item ms-3"><a href="/stage/fournisseurs"
                                class="text-decoration-none d-block"><i class="fas fa-list me-2"></i> Liste
                                Fournisseurs</a></div>
                    </div>
                </div>
            </div>


            <!-- Products -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#products">
                        <i class="fas fa-boxes me-2" style='color: rgb(175, 142, 107);'></i>Produits
                    </button>
                </h2>
                <div id="products" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item"><a href="/stage/produits/add" class="text-decoration-none d-block"><i
                                    class="fas fa-plus-circle me-2"></i> Ajouter Produit</a></div>
                        <div class="submenu-item"><a href="/stage/produits" class="text-decoration-none d-block"><i
                                    class="fas fa-list me-2"></i> Liste Produits</a></div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#categories">
                        <i class="fas fa-tags me-2" style='color: rgb(237, 117, 25);'></i>Catégories
                    </button>
                </h2>
                <div id="categories" class="accordion-collapse collapse " data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item"><a href="" class="text-decoration-none d-block"><i
                                    class="fas fa-plus-circle me-2"></i> Ajouter Catégorie</a></div>
                        <div class="submenu-item"><a href="/stage/categories" class="text-decoration-none d-block"><i
                                    class="fas fa-list me-2"></i> Liste Catégories</a></div>
                    </div>
                </div>
            </div>

            <!-- Documents 
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#documents">
                        <i class="fas fa-file-alt me-2" style='color: rgb(148, 149, 151);'></i> Documents
                    </button>
                </h2>
                <div id="documents" class="accordion-collapse collapse" data-bs-parent="#sidebarMenu">
                    <div class="accordion-body p-0">
                        <div class="submenu-item"><a href="#" class="text-decoration-none d-block"><i
                                    class="fas fa-file-invoice me-2"></i> Devis</a></div>
                        <div class="submenu-item"><a href="#" class="text-decoration-none d-block"><i
                                    class="fas fa-truck me-2"></i> Bon de Livraison</a></div>
                        <div class="submenu-item"><a href="#" class="text-decoration-none d-block"><i
                                    class="fas fa-file-invoice-dollar me-2"></i> Factures</a></div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>