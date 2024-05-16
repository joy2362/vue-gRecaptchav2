<template>
    <div class="container-fluid">
        <div class="container mt-5">
            <div class="profile-card">
                <form ref="login">
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

                    <div class="mt-3">
                        <vue-recaptcha
                            v-if="form.submit >= 2"
                            :sitekey="recapcha_site_key"
                            v-on:verify="recaptchaUpdated"
                            hl="en"
                            ref="vueRecaptcha"
                        ></vue-recaptcha>
                        <small
                            v-if="errors.recaptcha"
                            class="form-text text-danger"
                            >{{ errors.recaptcha[0] }}</small
                        >
                    </div>
                    <button
                        type="button"
                        @click="onSubmit"
                        class="btn btn-primary mt-3"
                    >
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import vueRecaptcha from "vue3-recaptcha2";
import { submit } from "./function/formSubmit";

export default {
    components: {
        vueRecaptcha,
    },
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
        };
    },
    methods: {
        recaptchaUpdated(recaptcha) {
            this.form.recaptcha = recaptcha;
        },
        async onSubmit() {
            submit(this);
        },
    },
};
</script>
