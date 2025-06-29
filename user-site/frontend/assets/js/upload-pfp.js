document.getElementById('pfpInput').addEventListener('change', function () {
    if (this.files.length > 0) {
        document.getElementById('pfpForm').submit();
    }
});