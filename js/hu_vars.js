// URL String
rootURL     = "http://www.cis355.com/";
userNameURL = "projects/";
healthyuURL = "healthyu/";
URL         = rootURL + userNameURL + healthyuURL;
URL         = ""; // remove for phonegap

// Get ID from URL
function getID() {
    id = window.location.search.substring(1);
    id = id.split("=");
    return id[1];
}