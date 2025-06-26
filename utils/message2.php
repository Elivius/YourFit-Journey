<?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
    <style>
        .alert-popup {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
            min-width: 250px;
            max-width: 400px;
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            animation: slideFade 0.5s ease;
        }

        .alert-success {
            background-color: var(--success);
        }

        .alert-danger {
            background-color: var(--danger);
        }

        @keyframes slideFade {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="alert-popup <?= isset($_SESSION['error']) ? 'alert-danger' : 'alert-success' ?>">
        <?= $_SESSION['error'] ?? $_SESSION['success'] ?>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-popup');
            if (alert) alert.remove();
        }, 4000); // auto-hide after 4s
    </script>

    <?php unset($_SESSION['error'], $_SESSION['success']); ?>
<?php endif; ?>
