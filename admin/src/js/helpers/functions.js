export function domReady(handler) {
    if(document.readyState !== "loading") handler();
    else {
        document.addEventListener("DOMContentLoaded", () => {
            handler();
        });
    }
}