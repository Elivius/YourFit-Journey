<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        // Get the form identifier (which form submitted)
        const targetForm = '<?= $_SESSION['target_form'] ?? '' ?>';
        const messageType = '<?= isset($_SESSION['error']) ? 'error' : 'success' ?>';
        const message = '<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : $_SESSION['success'] ?>';

        if (targetForm) {
            const container = document.getElementById(targetForm + 'Message');
            if (container) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${messageType === 'error' ? 'danger' : 'success'}`;
                alertDiv.setAttribute('role', 'alert');
                alertDiv.textContent = message;
                container.appendChild(alertDiv);

                // Fade out after 5 seconds
                setTimeout(() => {
                    alertDiv.style.transition = 'opacity 0.5s ease';
                    alertDiv.style.opacity = '0';
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 500);
                }, 5000);
            }
        }
    });
    </script>
    <?php
        // Clear session messages
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        unset($_SESSION['target_form']);
    endif;
    ?>
</body>
</html>