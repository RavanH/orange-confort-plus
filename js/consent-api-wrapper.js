// Load on document ready, needed for cache compatibility.
document.addEventListener("DOMContentLoaded", function(e) {
    if (!window.waitfor_consent_hook) {
        if (wp_has_consent('functional')) {
            appendOCplusToolbar();
        }
    }
});

// Listen to consent change event.
document.addEventListener("wp_listen_for_consent_change", function (e) {
    var changedConsentCategory = e.detail;
    for (var key in changedConsentCategory) {
        if (changedConsentCategory.hasOwnProperty(key)) {
            if (key === 'functional' && changedConsentCategory[key] === 'allow') {
                appendOCplusToolbar();
            }
        }
    }
});

// Append our toolbar script.
function appendOCplusToolbar() {
    var script   = document.createElement("script");
    script.type  = "text/javascript";
    script.src   = hebergementFullPath + "js/toolbar.min.js";
    document.body.appendChild(script);
}