let href_page = window.location.href;
let slice_href = href_page.slice(href_page.lastIndexOf('/')).slice(1);
let element = null;

switch (slice_href) {
    case 'news':
        element = document.getElementById("nav-news");
        break;

    case 'promo':
        element = document.getElementById("nav-promo");
        break;

    case 'events':
        element = document.getElementById("nav-events");
        break;

    case 'add':
        element = document.getElementById("nav-add");
        break;

    case '':
    default:
        element = document.getElementById("nav-index");
        break;
}

if (element != null) {
    element.className += 'active';
}