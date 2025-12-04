let page = window.location.pathname.split("/").pop();

if (page === "index.php") {
    elem = document.getElementById("home").classList.add("active");
}
else if (page === "posts.php") {
    elem = document.getElementById("posts").classList.add("active");
}
else if (page === "about.php") {
    elem = document.getElementById("about").classList.add("active");
}