import {DOMService} from "./dom-service.js";
export class AsyncHandler {
    static async changeCartItemQty(cartItemKey, newValue) {
        document.querySelector('.minicart ').querySelector('.loader').classList.add("active");
        const formData = new FormData();
        formData.append("action",'change_cart_item_qty');
        formData.append("qty", newValue);
        formData.append("cart_item_key", cartItemKey);
        return await fetch(ajaxUrl.url, {
            method: "POST",
            body: formData
        }).then( response => {
            return response.json();
        }).then(data => {
            DOMService.updateFragments(data.fragments)
            document.querySelector('.minicart ').querySelector('.loader').classList.remove("active");
        });
    }
}