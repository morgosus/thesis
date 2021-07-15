function setCookie(e, t, o) {
    let n = new Date;
    n = new Date(n.getTime() + 24 * o * 60 * 60 * 1e3), document.cookie = e + "=" + t + "; expires=" + n + "; path=/"
}

function getCookie(e) {
    for (let t, o = document.cookie.split("; "), n = o.length; n--;) if ((t = o[n].split("="))[0] === e) return t[1];
    return !1
}

function deleteCookie(e) {
    document.cookie = e + "=null; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/"
}

function revokeCookieConsent() {
    deleteCookie("consent"), deleteCookie("animations");
    let e = document.getElementById("settings-button");
    e.parentNode.removeChild(e), alert("Cookie consent revoked.");
    let t = document.getElementById("settings");
    t.parentNode.removeChild(t)
}

function setCookieConsent(e) {
    setCookie("consent", e, 182.5), document.getElementById("cookie-banner").style.display = "none", document.getElementById("settings-button-fake").classList.remove("hidden"), document.getElementById("settings-button-fake").classList.add("flash"), "enable" === e && (document.getElementById("speech-bubble").style.display = "block", document.getElementById("speech-bubble").classList.add("flash"))
}

function displaySettingsMenu() {
    document.getElementById("top-anchor").classList.toggle('header--expanded');

    document.getElementById("settings").style.display = "flex";
    document.getElementById("navigation").classList.toggle('navigation--collapsed');
    document.getElementById("navigation").classList.toggle('navigation--expanded');
    document.getElementById("languages").classList.toggle('languages--row');

    document.getElementById('settings-button').onclick=()=>{concealSettingsMenu()};
}

function displaySimpleMenu() {
    document.getElementById("settings-button").style.display = "none", document.getElementById("settings-basic").style.display = "block", document.getElementById("settings-basic").classList.add("flash")
}

function concealSettingsMenu() {
    document.getElementById("settings").style.display = "none";
    document.getElementById("top-anchor").classList.toggle('header--expanded');
    document.getElementById("navigation").classList.toggle('navigation--collapsed');
    document.getElementById("navigation").classList.toggle('navigation--expanded');
    document.getElementById("languages").classList.toggle('languages--row');
    document.getElementById('settings-button').onclick=()=>{displaySettingsMenu()};
}

function concealSimpleMenu() {
    document.getElementById("settings-basic").style.display = "none", document.getElementById("settings-button").style.display = "block", document.getElementById("settings-button").classList.add("flash")
}

function toggleFooter() {
    let footer = document.getElementById('footer');

    if (footer.style.display !== 'block') {
        document.getElementById('footer').style.display = 'block';
        window.scrollTo(0, document.body.scrollHeight);
        console.log('Footer expanded');
    } else {
        document.getElementById('footer').style.display = 'none';
        console.log('Footer collapsed');
    }
}

//TODO: Enable in production at some point
console.log("%cGreetings & Felicitations!\n\nAre you looking for something? Are you lost?\n\nHere's my LinkedIn: https://www.linkedin.com/in/morgosus/\n\nMartin Toms", "color: indigo;");
