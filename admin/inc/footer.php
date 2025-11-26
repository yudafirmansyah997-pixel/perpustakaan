<?php include "../main/connect.php"; ?>
<script>
document.getElementById("sidebarToggle").addEventListener("click", function() {
    document.querySelector(".sidebar").classList.toggle("collapsed");
    document.querySelector(".content").classList.toggle("collapsed");
    document.querySelector(".topbar").classList.toggle("collapsed");
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
