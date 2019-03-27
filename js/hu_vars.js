// URL String
rootURL     = "http://www.cis355.com/";
userNameURL = "alpero/";
healthyuURL = "HealthyU/";
URL         = rootURL + userNameURL + healthyuURL;

// Get ID from URL
function getID() {
    id = window.location.search.substring(1);
    id = id.split("=");
    return id[1];
}