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

    static async addToCart(productId, productQty, variation_id) {
        const formData = new FormData();
        formData.append("action",'alex_room_add_to_cart');
        formData.append("qty", productQty);
        formData.append("product_id", productId);
        formData.append("variation_id", variation_id);
        return await fetch(ajaxUrl.url, {
            method: "POST",
            body: formData
        }).then( response => {
            return response.json();
        }).then(data => {
            DOMService.updateFragments(data.fragments);
            document.querySelector('.minicart ').querySelector('.loader').classList.remove("active");
            return data;
        });
    }
    static async setCoupon(couponCode) {
        const formData = new FormData();
        formData.append("action",'alex_room_set_coupon');
        formData.append("coupon_code", couponCode);
        return await fetch(ajaxUrl.url, {
            method: "POST",
            body: formData
        }).then( response => {
            return response.json();
        }).then(data => {
            DOMService.updateFragments(data.fragments);
            return data;
        });
    }
    static async removeCoupon() {
        const formData = new FormData();
        formData.append("action",'alex_room_remove_coupon');
        return await fetch(ajaxUrl.url, {
            method: "POST",
            body: formData
        }).then( response => {
            return response.json();
        }).then(data => {
            DOMService.updateFragments(data.fragments);
            return data;
        });
    }
}