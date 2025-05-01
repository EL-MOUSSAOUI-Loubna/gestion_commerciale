<?php // At the top of the form page (add.php):
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<div class="category-container" id="category-tree">
    <!-- Toast notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span id="toastMessage">Category deleted successfully</span>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h1>Ajouter categorie</h1>
        <!-- Display errors if any -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error">Erreur lors de l'ajout du client.</div>
        <?php endif; ?>

        <form method="post" action="/stage/categories/store" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <label for="categorie">Nom categorie : </label>
            <input type="text" id="categorie" name="categorie"><br>

            <label for="categorie_parente">Categorie parente : </label>
            <select name="categorie_parente" id="categorie_parente">
                <option value="">- catégorie racine</option>
                <?php 
                // Recursive function to display categories with proper indentation
                function displayCategoryOptions($categories, $indent = '') {
                    foreach ($categories as $category) {
                        // Output this category
                        echo '<option value="' . htmlspecialchars($category['id']) . '">' . 
                            $indent . htmlspecialchars($category['nom']) . 
                            '</option>';
                        
                        // If this category has children, recursively add them with increased indentation
                        if (!empty($category['children'])) {
                            displayCategoryOptions($category['children'], $indent . '&nbsp;&nbsp;&nbsp;&nbsp;');
                        }
                    }
                }
                
                // Start the recursive display
                displayCategoryOptions($categories);
                ?>
            </select><br>

            <input type="submit" value="Ajouter">
        </form>
    </div>

    <div>
    <?php function renderCategories($categories, $level = 0) { ?>
        <?php foreach ($categories as $category): ?>
            <?php if (empty($category['children'])): ?>
                <!-- Simple category (no children) -->
                <div class="category-item" data-category-id="<?= $category['id'] ?>">
                    <div class="category-content">
                        <span class="category-name"><?= htmlspecialchars($category['nom']) ?></span>
                    </div>
                    <div class="category-actions">
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px;">
                                action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" data-id="<?= $category['id'] ?>">show</a></li>
                                <li><a class="dropdown-item" href="/stage/categories/edit?id=<?= $category['id'] ?>">edit</a></li>
                                <li>
                                    <form method="post" class="delete-category-form" data-confirm="Êtes-vous sûr de vouloir supprimer cette catégorie?">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Category with children -->
                <div class="category-item parent-category flex-column <?= $level > 0 ? 'nested' : '' ?>" data-category-id="<?= $category['id'] ?>">
                    <div class="category-row">
                        <div class="category-content">
                            <span class="category-name"><?= htmlspecialchars($category['nom']) ?></span>
                            <span class="toggle-icon ps-2" data-category-id="<?= $category['id'] ?>">
                                <i class="fa fa-chevron-right"></i>
                            </span> 
                        </div>
                        <div class="category-actions">
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 12px;">
                                    action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-id="<?= $category['id'] ?>">show</a></li>
                                    <li><a class="dropdown-item" href="/stage/categories/edit?id=<?= $category['id'] ?>">edit</a></li>
                                    <li>
                                        <form method="post" class="delete-category-form" 
                                        data-confirm="Êtes-vous sûr de vouloir supprimer cette catégorie et toutes ses sous-catégories?">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="subcategories w-100" id="children-<?= $category['id'] ?>" style="display: none;">
                        <?php renderCategories($category['children'], $level + 1); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php } ?>
    
    <?php renderCategories($categories); ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle functionality
    document.querySelectorAll('.toggle-icon').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            
            var categoryId = this.getAttribute('data-category-id');
            var childrenContainer = document.getElementById('children-' + categoryId);
            var icon = this.querySelector('i');
            
            if (childrenContainer.style.display === 'none' || !childrenContainer.style.display) {
                childrenContainer.style.display = 'block';
                if (icon) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            } else {
                childrenContainer.style.display = 'none';
                if (icon) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            }
        });
    });
    
    // Row click to toggle
    document.querySelectorAll('.parent-category .category-row').forEach(function(row) {
        row.addEventListener('click', function() {
            var toggle = this.querySelector('.toggle-icon');
            if (toggle) {
                toggle.click();
            }
        });
    });
    
    // AJAX Delete functionality
    document.querySelectorAll('.delete-category-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        if (!confirm('Delete this category?')) return;

        const formData = new FormData(form);
        
        try {
            const response = await fetch('/stage/categories/delete', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Helps identify AJAX
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || 'Delete failed');
            }
            
            const data = await response.json();
            if (data.success) {
                form.closest('.category-item').remove();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Delete error: ' + error.message);
        }
    });
});
    
});
</script>



<style>
#category-tree {
    width: 100%;
    font-family: Arial, sans-serif;
    border-radius: 4px;
    overflow: hidden;
}

#category-tree .category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    border-top: 1px solid #eee;
    background-color: white;
}

#category-tree .category-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    cursor: pointer;
}

#category-tree .category-content {
    display: flex;
    align-items: center;
}

#category-tree .category-content img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 15px;
}

#category-tree .category-name {
    font-size: 15px;
    color: #333;
}

#category-tree .category-actions {
    display: flex;
    align-items: center;
}

#category-tree .toggle-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    cursor: pointer;
    color: #888;
}

#category-tree .toggle-icon i {
    transition: transform 0.2s;
}

#category-tree .fa-chevron-down {
    transform: rotate(90deg);
}

#category-tree .edit-btn {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
}

#category-tree .edit-btn:hover {
    text-decoration: underline;
}

#category-tree .subcategories {
    padding-left: 0;
}

#category-tree .subcategories .category-item {
    padding-left: 45px;
    background-color: #ffffff;
}

#category-tree .subcategories .subcategories .category-item {
    padding-left: 45px;
    background-color:rgb(255, 255, 255);
}

/* Optional: Add a slight hover effect */
#category-tree .category-item:hover {
    background-color: rgb(253, 253, 253);
}

#category-tree .parent-category .category-row:hover {
    background-color:rgb(253, 253, 253);
}
</style>

<!-- Note: This implementation uses Font Awesome icons. Add this to your header if you don't already have it: -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->