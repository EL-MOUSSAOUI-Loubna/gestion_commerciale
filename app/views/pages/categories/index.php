<script src="/sggi/public/assets/js/bootstrap.bundle.min.js"></script>
<script src="/sggi/public/assets/js/jquery-3.6.0.min.js"></script>

<div class="container categories mt-4">

    <?php
    $toastMessage = null;
    $toastType = 'success';
    if (isset($_GET['success'])) {
        switch ($_GET['success']) {
            case 'deleted':
                $toastMessage = 'Categorie a été supprimée avec succès 👍';
                break;
            case 'created':
                $toastMessage = 'Categorie est ajoutée avec succès 🤩';
                break;
            case 'updated':
                $toastMessage = 'Categorie a été modifié avec succès 😊';
                break;
            case 'renamed':
                $toastMessage = 'Categorie a été renommée avec succès 🎉';
                break;
        }
        $toastType = 'success';
    } elseif (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'delete_failed':
                $toastMessage = 'Echec de suppression 🥺';
                break;
            case 'create_failed':
                $toastMessage = 'Echec de creation 🥺';
                break;
            case 'update_failed':
                $toastMessage = 'Echec de modification 🥺';
                break;
            case 'rename_failed':
                $toastMessage = 'Echec de renommage 🥺';
                break;
        }
        $toastType = 'danger';
    }

    if ($toastMessage): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="actionToast" class="toast align-items-center text-white bg-<?= $toastType ?> border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body"><?= htmlspecialchars($toastMessage) ?></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Add Category Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="h5 mb-0"><i class="fas fa-folder-plus me-2"></i>Ajouter une Nouvelle Catégorie</div>
        </div>
        <div class="card-body">
            <form id="addCategoryForm" action="/sggi/categories/store" method="POST" class="needs-validation"
                novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="categoryName" class="form-label">Nom Catégorie <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un nom pour la catégorie
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="parentCategory" class="form-label">Catégorie Parente</label>
                        <select class="form-select" name="parentCategory" id="parentCategory">
                            <option value="">- Catégorie Racine -</option>
                            <?php
                            function displayCategoryOptions($categories, $indent = '')
                            {
                                foreach ($categories as $category) {
                                    echo '<option value="' . htmlspecialchars($category['id']) . '">' .
                                        $indent . htmlspecialchars($category['nom']) .
                                        '</option>';

                                    if (!empty($category['children'])) {
                                        displayCategoryOptions($category['children'], $indent . '&nbsp;&nbsp;');
                                    }
                                }
                            }
                            displayCategoryOptions($categories);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Tree -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="h5 mb-0"><i class="fas fa-sitemap me-2"></i>Liste des Catégories</div>
            <button id="expandAllBtn" class="btn btn-sm btn-outline-light">
                <i class="fas fa-expand me-1"></i> Déplier Tout
            </button>
        </div>
        <div class="card-body p-0">
            <div id="categoryTree" class="tree-view">
                <?php function renderCategories($categories, $level = 0)
                { ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="tree-node" data-level="<?= $level ?>" data-category-id="<?= $category['id'] ?>">
                            <div class="node-header">
                                <?php if (!empty($category['children'])): ?>
                                    <button class="toggle-btn btn btn-sm btn-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="toggle-spacer"></span>
                                <?php endif; ?>

                                <span class="node-name-container">
                                    <a href="/sggi/categories/show?id=<?= $category['id'] ?>" class="node-name">
                                        <?= htmlspecialchars($category['nom']) ?>
                                    </a>
                                    <!-- Formulaire de renommage (initialement caché) -->
                                    <form action="/sggi/categories/rename" method="POST" class="rename-form d-none">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm rename-input" 
                                                name="categoryName" value="<?= htmlspecialchars($category['nom']) ?>" required>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary cancel-rename">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </form>
                                </span>

                                <div class="node-actions dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button class="dropdown-item rename-btn" data-category-id="<?= $category['id'] ?>">
                                                <i class="fas fa-pen me-2"></i>Renommer
                                            </button>
                                        </li>
                                        <li>
                                            <form method="POST" action="/sggi/categories/delete" class="delete-category-form"
                                                data-category-id="<?= $category['id'] ?>">
                                                <input type="hidden" name="csrf_token"
                                                    value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <?php if (!empty($category['children'])): ?>
                                <div class="node-children">
                                    <?php renderCategories($category['children'], $level + 1); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>

                <?php renderCategories($categories); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .categories {
        font-size: 13px;
        height: 80vh;
    }

    .categories .card-header {
        font-size: 16px;
    }

    .tree-view {
        padding: 15px;
    }

    .tree-node {
        margin-bottom: 5px;
    }

    .node-header {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        background-color: #f8f9fa;
        transition: all 0.2s;
    }

    .node-header:hover {
        background-color: #e9ecef;
    }

    .toggle-btn,
    .toggle-spacer {
        width: 24px;
        min-width: 24px;
        text-align: center;
        margin-right: 8px;
    }

    .toggle-btn i {
        transition: transform 0.2s;
    }

    .tree-node.expanded>.node-header>.toggle-btn i {
        transform: rotate(90deg);
    }

    .node-name {
        font-weight: 500;
        text-decoration: none;
        color: #212529;
        display: inline;
    }

    .node-name:hover {
        color: #0d6efd;
        text-decoration: underline;
    }
    
    .node-name-container {
        flex-grow: 1;
        padding: 4px 0;
    }

    .node-actions {
        margin-left: auto;
    }

    .node-children {
        margin-left: 32px;
        border-left: 2px solid #dee2e6;
        padding-left: 10px;
        padding-top: 5px;
        display: none;
    }

    .tree-node.expanded>.node-children {
        display: block;
    }

    .node-children>.tree-node {
        margin-bottom: 5px;
    }

    .dropdown-toggle::after {
        display: none;
    }
    
    /* Style pour le formulaire de renommage */
    .rename-form {
        margin: 0;
        padding: 0;
    }
    
    .input-group-sm > .form-control-sm {
        height: calc(1.5em + .5rem + 2px);
        padding: .25rem .5rem;
        font-size: .875rem;
    }
    
    .rename-form.d-none {
        display: none !important;
    }
    
    .node-name.d-none {
        display: none !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .node-header {
            padding: 6px 8px;
        }

        .node-children {
            margin-left: 20px;
        }
    }
</style>

<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();

        if ($('#actionToast').length) {
            const toast = new bootstrap.Toast(document.getElementById('actionToast'), {
                delay: 5000
            });
            toast.show();

            // Clean up URL parameters after displaying toast
            if (window.history && window.history.replaceState) {
                const urlWithoutParams = window.location.pathname;
                window.history.replaceState({}, document.title, urlWithoutParams);
            }
        }

        // Gestion du clic sur les boutons d'expansion des catégories
        $('.tree-node').each(function () {
            const $node = $(this);
            const $toggleBtn = $node.find('> .node-header .toggle-btn').first();

            if ($toggleBtn.length) {
                $toggleBtn.on('click', function (e) {
                    e.stopPropagation();
                    $node.toggleClass('expanded');
                });

                const $header = $node.find('> .node-header').first();
                $header.on('click', function (e) {
                    if (!$(e.target).closest('.dropdown').length && 
                        !$(e.target).is('.node-name') && 
                        !$(e.target).closest('.node-name').length && 
                        !$(e.target).closest('.toggle-btn').length &&
                        !$(e.target).closest('.rename-form').length) {
                        $toggleBtn.click();
                    }
                });
            }
        });

        // Bouton d'expansion/réduction globale
        $('#expandAllBtn').on('click', function () {
            const $btn = $(this);
            const shouldExpand = !$btn.hasClass('active');

            $btn.toggleClass('active', shouldExpand);
            $btn.html(shouldExpand
                ? '<i class="fas fa-compress me-1"></i> Replier Tout'
                : '<i class="fas fa-expand me-1"></i> Déplier Tout');

            $('.tree-node').each(function () {
                if ($(this).find('.node-children').length) {
                    $(this).toggleClass('expanded', shouldExpand);
                }
            });
        });

        // Confirmation de suppression
        $('.delete-category-form').on('submit', function (e) {
            const $form = $(this);
            const $node = $form.closest('.tree-node');
            const hasChildren = $node.find('.node-children').length > 0;

            const confirmMessage = hasChildren
                ? 'Vous êtes sûre de vouloir supprimer cette catégorie et toutes ses sous-catégories ?'
                : 'Vous êtes sûre de vouloir supprimer cette catégorie ?';

            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        });

        // Validation du formulaire d'ajout
        $('#addCategoryForm').on('submit', function (e) {
            const form = this;
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            $(form).addClass('was-validated');
        });
        
        // Gestion du bouton Renommer
        $('.rename-btn').on('click', function(e) {
            e.preventDefault();
            
            // Fermer tout formulaire de renommage déjà ouvert
            $('.node-name').removeClass('d-none');
            $('.rename-form').addClass('d-none');
            
            // Ouvrir le formulaire de renommage pour cette catégorie
            const $node = $(this).closest('.tree-node');
            const $nameContainer = $node.find('.node-name-container');
            const $nodeName = $nameContainer.find('.node-name');
            const $renameForm = $nameContainer.find('.rename-form');
            
            $nodeName.addClass('d-none');
            $renameForm.removeClass('d-none');
            $renameForm.find('.rename-input').focus();
            
            // Fermer le dropdown
            $(this).closest('.dropdown-menu').removeClass('show');
        });
        
        // Annuler le renommage
        $('.cancel-rename').on('click', function(e) {
            e.preventDefault();
            const $nameContainer = $(this).closest('.node-name-container');
            $nameContainer.find('.node-name').removeClass('d-none');
            $nameContainer.find('.rename-form').addClass('d-none');
        });
        
        // Validation du formulaire de renommage
        $('.rename-form').on('submit', function(e) {
            const form = this;
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                $(form).addClass('was-validated');
            }
        });
        
        // Fermeture du formulaire de renommage si on clique ailleurs
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.rename-form').length && 
                !$(e.target).closest('.rename-btn').length) {
                $('.node-name').removeClass('d-none');
                $('.rename-form').addClass('d-none');
            }
        });
    });
</script>