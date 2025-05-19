<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <script>
        // Form Validation
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Add custom validation UI
                    const invalidInputs = form.querySelectorAll(':invalid');
                    invalidInputs.forEach(input => {
                        input.classList.add('is-invalid');
                        
                        // Add error message if not already present
                        const parent = input.parentElement;
                        if (!parent.querySelector('.invalid-feedback')) {
                            const errorMessage = document.createElement('div');
                            errorMessage.className = 'invalid-feedback';
                            errorMessage.textContent = input.validationMessage || 'This field is required';
                            parent.appendChild(errorMessage);
                        }
                    });
                } else {                
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success mt-3';
                    successMessage.textContent = 'Loading...';
                    form.appendChild(successMessage);
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                }
                
                form.classList.add('was-validated');
            });
            
            // Clear validation on input
            form.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    const errorMessage = this.parentElement.querySelector('.invalid-feedback');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>
