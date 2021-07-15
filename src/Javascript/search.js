function generatePreviews(e) {
    let t = document.createElement("figure");
    t.setAttribute("class", "card-found standard-border sb");
    let n = document.createElement("a");
    n.setAttribute("href", "/article/" + e.link), n.setAttribute("class", "overlay");
    let a = document.createElement("img");
    a.setAttribute("class", "image"), a.setAttribute("src", "/src/View/image/" + e.src), a.setAttribute("alt", "/article/" + e.name);
    let r = document.createElement("figcaption"), i = document.createElement("h2");
    i.setAttribute("class", "title"), i.innerHTML = e.title;
    let c = document.createElement("p");
    c.setAttribute("class", "content"), c.innerHTML = e.digest, t.appendChild(a), r.appendChild(i), r.appendChild(c);
    let d = document.createElement("a");
    return n.setAttribute("href", "/" + localizationCode + "/article/" + e.link), t.appendChild(n), t.appendChild(r), t.appendChild(d), t
}

function search() {
    let searchLocation = 'https://api.toms.click';

    waiting();
    let e = new XMLHttpRequest, t = document.getElementById("search-loading-bar");

    const searched = document.getElementById("search").value;

    t.style.width = "0", e.open("GET", encodeURI(searchLocation+"/?do=search&language="+ localizationCode+"&content=" + searched)), e.onload = function () {
        //localizationCode
        if (200 === e.status) {
            let n = document.getElementById("found");
            n.innerHTML = null;
            let a = JSON.parse(e.responseText);

            let heading = document.createElement('div');
            heading.id = 'search-heading';

            n.insertBefore(heading, n.firstChild);

            if (localizationCode === 'cs-cz') {
                if (a.length !== 0) {
                    document.getElementById('search-heading').innerHTML = 'Nalezeno ' + a.length + ' výsledků pro hledaný výraz: "' + searched + '"';
                } else {
                    document.getElementById('search-heading').innerHTML = 'No results for  \'' + searched + '\'';
                }
            } else {
                if (a.length !== 0) {
                    document.getElementById('search-heading').innerHTML = 'Displaying ' + a.length + ' results for: \'' + searched + '\'';
                } else {
                    document.getElementById('search-heading').innerHTML = 'No results for  \'' + searched + '\'';
                }
            }
            t.max = a.length, t.style.width = 0;
            for (let r = 0; r < a.length; r++) n.appendChild(generatePreviews(a[r])), t.style.width += 100 / a.length + "%";
            t.style.width = "100%", setTimeout(function () {
                notWaiting()
            }, 500)
        } else document.getElementById("found").innerHTML = "Request failed.  Returned status of " + e.status
    }, e.send()
}

function waiting() {
    // noinspection JSUndefinedPropertyAssignment
    document.getElementById("search-containter").style.cursor = "wait", document.getElementById("search-wait").style.display = "block", document.getElementById("search-button").style.cursor = "wait", document.getElementById("search-button").disabled = !0
}

function notWaiting() {
    document.getElementById("search-containter").style.cursor = "default", document.getElementById("search-wait").style.display = "none", document.getElementById("search-button").style.cursor = "default"
}

let input = document.getElementById("search");
input.addEventListener("keyup", function (e) {
    13 === e.keyCode && !0 !== document.getElementById("search").disabled && (e.preventDefault(), document.getElementById("search-button").click())
});