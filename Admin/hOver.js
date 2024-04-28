document.addEventListener('DOMContentLoaded', function () {
    var menuItems = document.querySelectorAll('.sidebar .menu li a');

    menuItems.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the link from navigating immediately
            // Remove the active class from all items
            menuItems.forEach(function (item) {
                item.parentElement.classList.remove('active');
            });

            // Add the active class to the clicked item's parent li
            this.parentElement.classList.add('active');

            // Optionally navigate to the href attribute of the anchor
            window.location.href = this.href;
        });
    });
});