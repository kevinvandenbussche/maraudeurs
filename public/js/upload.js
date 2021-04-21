

// pour inserer plusieur fichier en meme temps
function test() {
    document.getElementById("media").innerHTML =
        "<label for=\"test\">Media:</label>\n" +
        "\n" +
        "<input type=\"file\"\n" +
        "       id=\"file\" name=\"test\"\n" +
        "       accept=\"image/png, image/jpeg\">";
}