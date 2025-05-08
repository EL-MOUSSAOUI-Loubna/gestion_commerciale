<div>
    test home
    <style>
        .info-container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px;
            position: relative;
        }
        
        .edit-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .modal-actions {
            text-align: right;
            margin-top: 20px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        
        .btn-secondary {
            background: #f1f1f1;
        }
    </style>

    <div class="info-container">
        <h2>Informations Personnelles</h2>
        <button class="edit-btn">Modifier</button>
        <div class="info-content">
            <p><strong>Nom complet:</strong> <span id="fullname">Jean Dupont</span></p>
            <p><strong>Date de naissance:</strong> <span id="birthdate">15/03/1985</span></p>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Modifier les informations</h2>
            <form id="editForm">
                <div class="form-group">
                    <label for="editFullname">Nom complet:</label>
                    <input type="text" id="editFullname" required>
                </div>
                <div class="form-group">
                    <label for="editBirthdate">Date de naissance:</label>
                    <input type="text" id="editBirthdate" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Open modal when edit button is clicked
            $('.edit-btn').click(function() {
                // Get current values
                const currentName = $('#fullname').text();
                const currentDate = $('#birthdate').text();
                
                // Set values in form
                $('#editFullname').val(currentName);
                $('#editBirthdate').val(currentDate);
                
                // Show modal
                $('#editModal').show();
            });
            
            // Close modal when cancel button is clicked
            $('#cancelBtn').click(function() {
                $('#editModal').hide();
            });
            
            // Close modal when clicking outside the modal content
            $(window).click(function(event) {
                if (event.target.id === 'editModal') {
                    $('#editModal').hide();
                }
            });
            
            // Handle form submission
            $('#editForm').submit(function(e) {
                e.preventDefault();
                
                // Get new values
                const newName = $('#editFullname').val();
                const newDate = $('#editBirthdate').val();
                
                // Update the display
                $('#fullname').text(newName);
                $('#birthdate').text(newDate);
                
                // Close modal
                $('#editModal').hide();
                
                // Here you would typically make an AJAX call to save to backend
                // For this example, we're just updating the frontend
            });
        });
    </script>

</div>