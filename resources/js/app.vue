<template>
    <div class="container-fluid">
        <div class="container mt-5">
            <div class="profile-card">
                <form ref="login" @submit.prevent="onSubmit">
                    <div class="form-group mt-3">
                        <label for="email">Email address</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            placeholder="Enter email"
                            v-model="form.email"
                        />
                        <small
                            v-if="errors.email"
                            class="form-text text-danger"
                            >{{ errors.email[0] }}</small
                        >
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            placeholder="Password"
                            v-model="form.password"
                        />
                        <small
                            v-if="errors.password"
                            class="form-text text-danger"
                            >{{ errors.password[0] }}</small
                        >
                    </div>

                    <div class="mt-3" v-if="form.submit >= 2">
                        <div id="gRecaptcha"></div>
                        <small
                            v-if="errors.recaptcha"
                            class="form-text text-danger"
                            >{{ errors.recaptcha[0] }}</small
                        >
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { submit } from "./function/formSubmit";

export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
                submit: 0,
                recaptcha: null,
            },
            errors: {},
            submitUrl: "/api/form-submit",
            recaptchaWidget: null,
            theme: "light",
        };
    },
    methods: {
        async onSubmit() {
            submit(this);
        },
        onloadCallback() {
            this.recaptchaWidget = grecaptcha.render("gRecaptcha", {
                sitekey: this.recapcha_site_key,
                theme: this.theme,
            });
        },
    },
    watch: {
        "form.submit"(newVal) {
            if (newVal == 2) {
                this.$nextTick(() => {
                    if (!window.grecaptcha) {
                        const recaptchaScript =
                            document.createElement("script");
                        recaptchaScript.src =
                            "https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit";
                        recaptchaScript.async = true;
                        recaptchaScript.defer = true;
                        document.head.appendChild(recaptchaScript);
                    } else {
                        this.onloadCallback();
                    }
                });
            }
        },
    },
    mounted() {
        window.verifyCallback = this.verifyCallback;
        window.onloadCallback = this.onloadCallback;
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
