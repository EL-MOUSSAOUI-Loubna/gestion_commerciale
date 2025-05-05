<di?php // At the top of the form page (add.php):
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="container categories mt-4">
    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="actionToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">Action completed successfully</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Add Category Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="h5 mb-0"><i class="fas fa-folder-plus me-2"></i>Add New Category</div>
        </div>
        <div class="card-body">
            <form id="addCategoryForm" class="needs-validation" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="categoryName" class="form-label">Category Name <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        <div class="invalid-feedback">
                            Please enter a category name.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="parentCategory" class="form-label">Parent Category</label>
                        <select class="form-select" name="parentCategory" id="parentCategory">
                            <option value="">- Root Category -</option>
                            <?php 
                            function displayCategoryOptions($categories, $indent = '') {
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
                        <i class="fas fa-plus-circle me-1"></i> Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Tree -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="h5 mb-0"><i class="fas fa-sitemap me-2"></i>Categories Hierarchy</div>
            <button id="expandAllBtn" class="btn btn-sm btn-outline-light">
                <i class="fas fa-expand me-1"></i> Expand All
            </button>
        </div>
        <div class="card-body p-0">
            <div id="categoryTree" class="tree-view">
                <?php function renderCategories($categories, $level = 0) { ?>
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
                                
                                <span class="node-name"><?= htmlspecialchars($category['nom']) ?></span>
                                
                                <div class="node-actions dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="/stage/categories/edit?id=<?= $category['id'] ?>">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form class="delete-category-form" data-category-id="<?= $category['id'] ?>">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>Delete
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
/* Tree View Styles */
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

.toggle-btn, .toggle-spacer {
    width: 24px;
    min-width: 24px;
    text-align: center;
    margin-right: 8px;
}

.toggle-btn i {
    transition: transform 0.2s;
}

.tree-node.expanded > .node-header > .toggle-btn i {
    transform: rotate(90deg);
}

.node-name {
    flex-grow: 1;
    font-weight: 500;
}

.node-actions {
    margin-left: auto;
}

.node-children {
    margin-left: 32px;
    border-left: 2px solid #dee2e6;
    padding-left: 10px;
    display: none;
}

.tree-node.expanded > .node-children {
    display: block;
}

.dropdown-toggle::after {
    display: none;
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
class CategoryManager {
    constructor() {
        this.initEventListeners();
        this.initTreeView();
        this.toast = new bootstrap.Toast(document.getElementById('actionToast'));
    }

    initEventListeners() {
        // Add category form submission
        document.getElementById('addCategoryForm').addEventListener('submit', (e) => this.handleAddCategory(e));
        
        // Expand all button
        document.getElementById('expandAllBtn').addEventListener('click', () => this.toggleAllNodes());
        
        // Initialize dropdowns
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            new bootstrap.Dropdown(toggle);
        });
    }

    initTreeView() {
        document.querySelectorAll('.tree-node').forEach(node => {
            const toggleBtn = node.querySelector('.toggle-btn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    node.classList.toggle('expanded');
                });
            }
            
            // Make entire header clickable for toggling
            const header = node.querySelector('.node-header');
            if (header && node.querySelector('.toggle-btn')) {
                header.addEventListener('click', (e) => {
                    if (!e.target.closest('.dropdown') && !e.target.closest('.toggle-btn')) {
                        node.classList.toggle('expanded');
                    }
                });
            }
            
            // Delete category forms
            const deleteForm = node.querySelector('.delete-category-form');
            if (deleteForm) {
                deleteForm.addEventListener('submit', (e) => this.handleDeleteCategory(e));
            }
        });
    }

    toggleAllNodes() {
        const expandAllBtn = document.getElementById('expandAllBtn');
        const shouldExpand = !expandAllBtn.classList.contains('active');
        
        expandAllBtn.classList.toggle('active', shouldExpand);
        expandAllBtn.innerHTML = shouldExpand 
            ? '<i class="fas fa-compress me-1"></i> Collapse All' 
            : '<i class="fas fa-expand me-1"></i> Expand All';
        
        document.querySelectorAll('.tree-node').forEach(node => {
            if (node.querySelector('.node-children')) {
                node.classList.toggle('expanded', shouldExpand);
            }
        });
    }

    async handleAddCategory(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        
        try {
            const response = await fetch('/stage/categories/store', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                this.showToast('Category added successfully');
                this.addCategoryToTree(result.category);
                form.reset();
                form.classList.remove('was-validated');
            } else {
                throw new Error(result.message || 'Failed to add category');
            }
        } catch (error) {
            this.showToast(error.message, 'danger');
            console.error('Error:', error);
        }
    }

    addCategoryToTree(category) {
        const parentId = category.parent_id || '';
        const parentSelect = document.getElementById('parentCategory');
        
        // Add to dropdown
        const option = new Option(
            (category.parent_id ? '    ' : '') + category.nom, 
            category.id
        );
        parentSelect.add(option);
        
        // Add to tree view
        if (!category.parent_id) {
            // Add as root node
            const treeContainer = document.getElementById('categoryTree');
            const newNode = this.createTreeNode(category, 0);
            treeContainer.prepend(newNode);
        } else {
            // Find parent node and add as child
            const parentNode = document.querySelector(`.tree-node[data-category-id="${category.parent_id}"]`);
            if (parentNode) {
                parentNode.classList.add('expanded');
                let childrenContainer = parentNode.querySelector('.node-children');
                
                if (!childrenContainer) {
                    childrenContainer = document.createElement('div');
                    childrenContainer.className = 'node-children';
                    parentNode.appendChild(childrenContainer);
                    
                    // Add toggle button if it didn't exist
                    const header = parentNode.querySelector('.node-header');
                    const toggleSpacer = header.querySelector('.toggle-spacer');
                    if (toggleSpacer) {
                        toggleSpacer.replaceWith(this.createToggleButton());
                    }
                }
                
                const newNode = this.createTreeNode(category, parseInt(parentNode.dataset.level) + 1);
                childrenContainer.appendChild(newNode);
            }
        }
        
        // Reinitialize tree interactions for new nodes
        this.initTreeView();
    }

    createTreeNode(category, level) {
        const node = document.createElement('div');
        node.className = 'tree-node';
        node.dataset.level = level;
        node.dataset.categoryId = category.id;
        
        node.innerHTML = `
            <div class="node-header">
                <span class="toggle-spacer"></span>
                <span class="node-name">${category.nom}</span>
                <div class="node-actions dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/stage/categories/edit?id=${category.id}">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        </li>
                        <li>
                            <form class="delete-category-form" data-category-id="${category.id}">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                <input type="hidden" name="id" value="${category.id}">
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        `;
        
        return node;
    }

    createToggleButton() {
        const btn = document.createElement('button');
        btn.className = 'toggle-btn btn btn-sm btn-link';
        btn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        return btn;
    }

    async handleDeleteCategory(e) {
        e.preventDefault();
        const form = e.target;
        const categoryId = form.dataset.categoryId;
        const confirmMessage = form.closest('.tree-node').querySelector('.node-children') 
            ? 'Are you sure you want to delete this category and all its subcategories?'
            : 'Are you sure you want to delete this category?';
        
        if (!confirm(confirmMessage)) return;
        
        try {
            const response = await fetch('/stage/categories/delete', {
                method: 'POST',
                body: new FormData(form)
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                this.showToast('Category deleted successfully');
                form.closest('.tree-node').remove();
                
                // Remove from dropdown
                const parentSelect = document.getElementById('parentCategory');
                const option = parentSelect.querySelector(`option[value="${categoryId}"]`);
                if (option) option.remove();
            } else {
                throw new Error(result.message || 'Failed to delete category');
            }
        } catch (error) {
            this.showToast(error.message, 'danger');
            console.error('Error:', error);
        }
    }

    showToast(message, type = 'success') {
        const toast = document.getElementById('actionToast');
        const toastMessage = document.getElementById('toastMessage');
        
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toastMessage.textContent = message;
        
        this.toast.show();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CategoryManager();
});
</script>