import Toastify from 'toastify-js'
const selectors = {
    form: "#js-sellbroke-auth-form",
    login: "#js-sellbroke-auth-login",
    password: "#js-sellbroke-auth-password",
    msg: {
        auth: "#js-sellbroke-auth-message",
        guest: "#js-sellbroke-guest-message"
    },
    auth: {
        id: "#js-sellbroke-auth-merchant-id",
        name: "#js-sellbroke-auth-merchant-name"
    }
},
    ajaxUrl = `${window.location.origin}/wp-admin/admin-ajax.php`;

class SellbrokeAuthorize {
    constructor() {
        Object.defineProperties(this, {
            $form: { value: document.querySelector(selectors.form) },
            $login: { value: document.querySelector(selectors.login) },
            $password: { value: document.querySelector(selectors.password) },
            $msg: {
                value: {
                    auth: document.querySelector(selectors.msg.auth),
                    guest: document.querySelector(selectors.msg.guest)
                }
            },
            $auth: {
                value: {
                    id: document.querySelector(selectors.auth.id),
                    name: document.querySelector(selectors.auth.name)
                }
            },
            login: {
                get() { return this.$login.value; },
                set(val) { this.$login.value = val; }
            },
            password: {
                get() { return this.$password.value },
                set(val) { this.$password.value = val; }
            }
        });
        this.init();
    }

    get formData() {
        const data = new FormData();
        data.append("username", this.login);
        data.append("password", this.password);
        data.append("action", "sellbroke_authorize");
        return data;
    }

    init() {
        this.$form.addEventListener("submit", (e) => {
            e.preventDefault();
            this.authorize();
        })
    }

    authorize() {
        fetch(ajaxUrl, {
            method: "POST",
            credentials: 'same-origin',
            body: this.formData
        }).then((resp) => resp.json())
            .then((data) => {
                console.log(data);
                if((data.success && data.isInserted) || data.hasAuthToken) {
                    if(!data.success || !data.isInserted) {
                        this.__showFiledMessage();
                    } else {
                        this.$auth.id.innerText = data.merchant.id;
                        this.$auth.name.innerText = data.merchant.name;
                        this.__showSuccessMessage();
                        this.login = "";
                        this.password = "";
                    }
                    this.$msg.guest.classList.add("hidden");
                    this.$msg.auth.classList.remove("hidden");
                } else {
                    this.$msg.auth.classList.add("hidden");
                    this.$msg.guest.classList.remove("hidden");
                }
            });
    }

    __showSuccessMessage() {
        Toastify({
            text: "Authorization success!",
            duration: 5000,
            close: true,
            position: "center",
            backgroundColor: "green"
        }).showToast();
    }

    __showFiledMessage() {
        Toastify({
            text: "Authorization failed!",
            duration: 5000,
            close: true,
            position: "center",
            backgroundColor: "red"
        }).showToast();
    }
}

export default SellbrokeAuthorize;