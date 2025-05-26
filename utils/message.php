<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const errorAlert = document.querySelector('.alert-danger');
            if (errorAlert) {
                // Auto-hide the alert after 5 seconds with fade out
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s ease';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
