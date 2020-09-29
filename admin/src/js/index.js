import { domReady } from "@helpers/functions";
import Authorize from "./authorize";

domReady(() => {
    if(window.SELLBROKE_INIT) {
        new Authorize();
    }
});